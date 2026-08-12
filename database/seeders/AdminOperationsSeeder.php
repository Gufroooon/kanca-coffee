<?php

namespace Database\Seeders;

use App\Models\Cashflow;
use App\Models\Ingredient;
use App\Models\InventoryLog;
use App\Models\MixedIngredient;
use App\Models\MixedIngredientProduction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminOperationsSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::whereHas('role', fn ($query) => $query->where('slug', 'admin'))->first();

        if (! $admin) {
            $this->command?->warn('AdminOperationsSeeder dilewati: user admin belum tersedia.');
            return;
        }

        $ingredients = $this->seedIngredients();
        $this->seedInventoryLogs($ingredients, $admin->id);
        $mixedIngredients = $this->seedMixedIngredients($ingredients);
        $this->seedMixedProduction($mixedIngredients['krimer_susu'], $admin->id);
        $this->seedCashflows($admin->id);
    }

    private function seedIngredients(): array
    {
        $definitions = [
            'kopi' => ['name' => 'Kopi Arabika', 'unit' => 'kg', 'minimum_stock' => 1.5, 'current_stock' => 4.2],
            'susu' => ['name' => 'Susu Fresh Milk', 'unit' => 'liter', 'minimum_stock' => 3, 'current_stock' => 3],
            'krimer' => ['name' => 'Krimer', 'unit' => 'liter', 'minimum_stock' => 1.5, 'current_stock' => 1.4],
            'gula' => ['name' => 'Gula Aren', 'unit' => 'kg', 'minimum_stock' => 2, 'current_stock' => 3.2],
            'cokelat' => ['name' => 'Bubuk Cokelat', 'unit' => 'kg', 'minimum_stock' => 1, 'current_stock' => 1.8],
            'cup' => ['name' => 'Cup 16 oz', 'unit' => 'pcs', 'minimum_stock' => 50, 'current_stock' => 180],
        ];

        $ingredients = [];
        foreach ($definitions as $key => $definition) {
            $ingredient = Ingredient::withTrashed()->firstOrNew(['name' => $definition['name']]);
            $ingredient->fill(array_merge($definition, ['is_active' => true]));
            if ($ingredient->trashed()) {
                $ingredient->restore();
            }
            $ingredient->save();
            $ingredients[$key] = $ingredient;
        }

        return $ingredients;
    }

    private function seedInventoryLogs(array $ingredients, int $adminId): void
    {
        $profiles = [
            'kopi' => [4.8, 4.2, 0.1],
            'susu' => [5.0, 3.0, 0.35],
            'krimer' => [2.2, 1.4, 0.12],
            'gula' => [4.0, 3.2, 0.1],
            'cokelat' => [2.1, 1.8, 0.05],
            'cup' => [220, 180, 8],
        ];

        for ($daysAgo = 6; $daysAgo >= 0; $daysAgo--) {
            $date = Carbon::today()->subDays($daysAgo);

            foreach ($profiles as $key => [$startingStock, $todayClosing, $dailyUsage]) {
                $opening = $daysAgo === 6
                    ? $startingStock
                    : $todayClosing + ($dailyUsage * ($daysAgo + 1));
                $closing = $daysAgo === 0
                    ? $todayClosing
                    : $opening - $dailyUsage;

                $log = InventoryLog::where('ingredient_id', $ingredients[$key]->id)
                    ->whereDate('log_date', $date->toDateString())
                    ->first();
                $log ??= new InventoryLog([
                    'ingredient_id' => $ingredients[$key]->id,
                    'log_date' => $date->toDateString(),
                ]);
                $log->fill([
                    'opening_stock' => round($opening, 3),
                    'closing_stock' => round($closing, 3),
                    'usage' => round($opening - $closing, 3),
                    'notes' => $daysAgo === 0 ? 'Stok closing untuk dashboard demo.' : 'Log stok demo harian.',
                    'user_id' => $adminId,
                ])->save();
            }
        }

        foreach ($profiles as $key => [, $todayClosing]) {
            $ingredients[$key]->update(['current_stock' => $todayClosing]);
        }
    }

    private function seedMixedIngredients(array $ingredients): array
    {
        $krimerSusu = MixedIngredient::updateOrCreate(
            ['name' => 'Krimer + Susu 1 Liter'],
            ['unit' => 'liter', 'output_quantity' => 1, 'is_active' => true]
        );
        $krimerSusu->items()->delete();
        $krimerSusu->items()->createMany([
            ['ingredient_id' => $ingredients['krimer']->id, 'quantity' => 0.4],
            ['ingredient_id' => $ingredients['susu']->id, 'quantity' => 0.6],
        ]);

        $gulaSyrup = MixedIngredient::updateOrCreate(
            ['name' => 'Gula Aren Syrup 1 Liter'],
            ['unit' => 'liter', 'output_quantity' => 1, 'is_active' => true]
        );
        $gulaSyrup->items()->delete();
        $gulaSyrup->items()->createMany([
            ['ingredient_id' => $ingredients['gula']->id, 'quantity' => 0.7],
            ['ingredient_id' => $ingredients['susu']->id, 'quantity' => 0.3],
        ]);

        return [
            'krimer_susu' => $krimerSusu->fresh('items'),
            'gula_syrup' => $gulaSyrup->fresh('items'),
        ];
    }

    private function seedMixedProduction(MixedIngredient $mixedIngredient, int $adminId): void
    {
        $date = Carbon::today()->toDateString();
        $quantity = 1;
        $notes = 'Produksi demo untuk menguji pengurangan stok proporsional.';

        DB::transaction(function () use ($mixedIngredient, $adminId, $date, $quantity, $notes) {
            $production = MixedIngredientProduction::where('mixed_ingredient_id', $mixedIngredient->id)
                ->whereDate('produced_at', $date)
                ->where('quantity', $quantity)
                ->first();
            if (! $production) {
                MixedIngredientProduction::create([
                    'mixed_ingredient_id' => $mixedIngredient->id,
                    'quantity' => $quantity,
                    'produced_at' => $date,
                    'notes' => $notes,
                    'user_id' => $adminId,
                ]);
            }

            $multiplier = $quantity / (float) $mixedIngredient->output_quantity;
            foreach ($mixedIngredient->items as $item) {
                $closingStock = InventoryLog::where('ingredient_id', $item->ingredient_id)
                    ->whereDate('log_date', $date)
                    ->value('closing_stock');
                $currentStock = max(0, (float) $closingStock - ((float) $item->quantity * $multiplier));
                Ingredient::whereKey($item->ingredient_id)->update(['current_stock' => $currentStock]);
            }
        });
    }

    private function seedCashflows(int $adminId): void
    {
        $rows = [
            ['income', 6, 1850000, null, 'Penjualan cafe', 'Penjualan harian shift pagi dan sore.'],
            ['expense', 6, 425000, 'Belanja bahan', null, 'Restock susu, kopi, dan gula.'],
            ['income', 5, 2140000, null, 'Penjualan cafe', 'Penjualan harian dan pesanan takeaway.'],
            ['expense', 5, 180000, 'Operasional', null, 'Kebutuhan operasional bar.'],
            ['income', 4, 1985000, null, 'Penjualan cafe', 'Penjualan harian.'],
            ['expense', 4, 275000, 'Listrik', null, 'Pembayaran listrik mingguan.'],
            ['income', 3, 2460000, null, 'Penjualan cafe', 'Penjualan akhir pekan.'],
            ['expense', 3, 350000, 'Maintenance', null, 'Perawatan mesin kopi.'],
            ['income', 2, 2310000, null, 'Penjualan cafe', 'Penjualan harian.'],
            ['expense', 2, 210000, 'Transportasi', null, 'Transportasi pengambilan bahan.'],
            ['income', 1, 2750000, null, 'Penjualan cafe', 'Penjualan harian ramai.'],
            ['expense', 1, 500000, 'Belanja bahan', null, 'Pembelian bahan baku mingguan.'],
            ['income', 0, 3250000, null, 'Penjualan cafe', 'Penjualan hari ini untuk demo dashboard.'],
            ['expense', 0, 625000, 'Belanja bahan', null, 'Restock bahan dan kemasan.'],
        ];

        foreach ($rows as [$type, $daysAgo, $amount, $category, $source, $description]) {
            $date = Carbon::today()->subDays($daysAgo)->toDateString();
            $cashflow = Cashflow::where('type', $type)
                ->whereDate('transaction_date', $date)
                ->where('amount', $amount)
                ->where('description', $description)
                ->first();
            if (! $cashflow) {
                Cashflow::create([
                    'type' => $type,
                    'transaction_date' => $date,
                    'amount' => $amount,
                    'category' => $category,
                    'source' => $source,
                    'description' => $description,
                    'user_id' => $adminId,
                ]);
            }
        }
    }
}
