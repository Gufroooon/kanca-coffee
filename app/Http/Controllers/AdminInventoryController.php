<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use App\Models\InventoryLog;
use App\Models\MixedIngredient;
use App\Models\MixedIngredientProduction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminInventoryController extends Controller
{
    public function ingredients(Request $request)
    {
        $query = Ingredient::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%'.$request->string('search').'%');
        }
        if ($request->filled('status')) {
            $query->where('is_active', $request->string('status') === 'active');
        }

        $sort = in_array($request->get('sort'), ['name', 'current_stock', 'minimum_stock', 'created_at'], true)
            ? $request->get('sort')
            : 'name';
        $direction = $request->get('direction') === 'desc' ? 'desc' : 'asc';
        $ingredients = $query->orderBy($sort, $direction)
            ->paginate(12)->withQueryString();

        return view('admin.inventory.ingredients.index', compact('ingredients'));
    }

    public function storeIngredient(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'unit' => ['required', 'string', 'max:20'],
            'minimum_stock' => ['required', 'numeric', 'min:0'],
            'current_stock' => ['required', 'numeric', 'min:0'],
        ]);
        $data['is_active'] = $request->boolean('is_active', true);
        Ingredient::create($data);

        return back()->with('success', 'Bahan baku berhasil ditambahkan.');
    }

    public function updateIngredient(Request $request, Ingredient $ingredient)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'unit' => ['required', 'string', 'max:20'],
            'minimum_stock' => ['required', 'numeric', 'min:0'],
            'current_stock' => ['required', 'numeric', 'min:0'],
        ]);
        $data['is_active'] = $request->boolean('is_active');
        $ingredient->update($data);

        return back()->with('success', 'Bahan baku berhasil diperbarui.');
    }

    public function destroyIngredient(Ingredient $ingredient)
    {
        if ($ingredient->inventoryLogs()->exists() || $ingredient->mixedIngredientItems()->exists()) {
            $ingredient->update(['is_active' => false]);
            return back()->with('success', 'Bahan memiliki histori, sehingga dinonaktifkan agar data tetap aman.');
        }

        $ingredient->delete();
        return back()->with('success', 'Bahan baku berhasil dihapus.');
    }

    public function mixed(Request $request)
    {
        $query = MixedIngredient::with('items.ingredient');
        if ($request->filled('search')) {
            $query->where('name', 'like', '%'.$request->string('search').'%');
        }

        $mixedIngredients = $query->latest()->paginate(10)->withQueryString();
        $ingredients = Ingredient::where('is_active', true)->orderBy('name')->get();

        return view('admin.inventory.mixed.index', compact('mixedIngredients', 'ingredients'));
    }

    public function storeMixed(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'unit' => ['required', 'string', 'max:20'],
            'output_quantity' => ['required', 'numeric', 'gt:0'],
            'ingredient_ids' => ['required', 'array', 'min:1'],
            'ingredient_ids.*' => ['required', 'integer', 'distinct', 'exists:ingredients,id'],
            'quantities' => ['required', 'array', 'min:1'],
            'quantities.*' => ['required', 'numeric', 'gt:0'],
        ]);

        if (count($data['ingredient_ids']) !== count($data['quantities'])) {
            return back()->withInput()->withErrors(['quantities' => 'Formula bahan tidak lengkap.']);
        }

        DB::transaction(function () use ($data) {
            $mixed = MixedIngredient::create([
                'name' => $data['name'],
                'unit' => $data['unit'],
                'output_quantity' => $data['output_quantity'],
                'is_active' => true,
            ]);
            foreach ($data['ingredient_ids'] as $index => $ingredientId) {
                $mixed->items()->create(['ingredient_id' => $ingredientId, 'quantity' => $data['quantities'][$index]]);
            }
        });

        return back()->with('success', 'Formula mixed ingredient berhasil disimpan.');
    }

    public function updateMixed(Request $request, MixedIngredient $mixedIngredient)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'unit' => ['required', 'string', 'max:20'],
            'output_quantity' => ['required', 'numeric', 'gt:0'],
            'ingredient_ids' => ['required', 'array', 'min:1'],
            'ingredient_ids.*' => ['required', 'integer', 'distinct', 'exists:ingredients,id'],
            'quantities' => ['required', 'array', 'min:1'],
            'quantities.*' => ['required', 'numeric', 'gt:0'],
        ]);

        if (count($data['ingredient_ids']) !== count($data['quantities'])) {
            return back()->withInput()->withErrors(['quantities' => 'Formula bahan tidak lengkap.']);
        }

        DB::transaction(function () use ($data, $mixedIngredient) {
            $mixedIngredient->update([
                'name' => $data['name'], 'unit' => $data['unit'], 'output_quantity' => $data['output_quantity'],
                'is_active' => true,
            ]);
            $mixedIngredient->items()->delete();
            foreach ($data['ingredient_ids'] as $index => $ingredientId) {
                $mixedIngredient->items()->create(['ingredient_id' => $ingredientId, 'quantity' => $data['quantities'][$index]]);
            }
        });

        return back()->with('success', 'Formula mixed ingredient berhasil diperbarui.');
    }

    public function destroyMixed(MixedIngredient $mixedIngredient)
    {
        if ($mixedIngredient->productions()->exists()) {
            $mixedIngredient->update(['is_active' => false]);
            return back()->with('success', 'Mixed ingredient memiliki histori produksi, sehingga dinonaktifkan.');
        }
        $mixedIngredient->delete();
        return back()->with('success', 'Mixed ingredient berhasil dihapus.');
    }

    public function produceMixed(Request $request, MixedIngredient $mixedIngredient)
    {
        $data = $request->validate([
            'quantity' => ['required', 'numeric', 'gt:0'],
            'produced_at' => ['required', 'date'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        DB::transaction(function () use ($data, $mixedIngredient) {
            $mixedIngredient->load('items');
            $multiplier = (float) $data['quantity'] / (float) $mixedIngredient->output_quantity;
            $ingredients = Ingredient::whereIn('id', $mixedIngredient->items->pluck('ingredient_id'))->lockForUpdate()->get()->keyBy('id');

            foreach ($mixedIngredient->items as $item) {
                $required = (float) $item->quantity * $multiplier;
                $ingredient = $ingredients->get($item->ingredient_id);
                if ((float) $ingredient->current_stock < $required) {
                    abort(422, "Stok {$ingredient->name} tidak mencukupi untuk produksi.");
                }
                $ingredient->decrement('current_stock', $required);
            }

            MixedIngredientProduction::create([
                'mixed_ingredient_id' => $mixedIngredient->id,
                'quantity' => $data['quantity'],
                'produced_at' => $data['produced_at'],
                'notes' => $data['notes'] ?? null,
                'user_id' => auth()->id(),
            ]);
        });

        return back()->with('success', 'Produksi mixed ingredient berhasil dicatat dan stok bahan dikurangi proporsional.');
    }

    public function logs(Request $request)
    {
        $query = InventoryLog::with('ingredient');
        if ($request->filled('ingredient_id')) $query->where('ingredient_id', $request->integer('ingredient_id'));
        if ($request->filled('date_from')) $query->whereDate('log_date', '>=', $request->date_from);
        if ($request->filled('date_to')) $query->whereDate('log_date', '<=', $request->date_to);

        $logs = $query->latest('log_date')->paginate(15)->withQueryString();
        $ingredients = Ingredient::where('is_active', true)->orderBy('name')->get();
        return view('admin.inventory.logs.index', compact('logs', 'ingredients'));
    }

    public function storeLog(Request $request)
    {
        $data = $request->validate([
            'ingredient_id' => ['required', 'exists:ingredients,id'],
            'log_date' => ['required', 'date'],
            'opening_stock' => ['required', 'numeric', 'min:0'],
            'closing_stock' => ['required', 'numeric', 'min:0', 'lte:opening_stock'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);
        $data['usage'] = (float) $data['opening_stock'] - (float) $data['closing_stock'];
        $data['user_id'] = auth()->id();

        DB::transaction(function () use ($data) {
            InventoryLog::updateOrCreate(
                ['ingredient_id' => $data['ingredient_id'], 'log_date' => $data['log_date']],
                $data
            );
            Ingredient::whereKey($data['ingredient_id'])->update(['current_stock' => $data['closing_stock']]);
        });

        return back()->with('success', 'Opening, closing, dan usage stok berhasil dicatat.');
    }

    public function exportLogs(Request $request)
    {
        $logs = $this->filteredLogs($request)->latest('log_date')->get();
        if ($request->get('format') === 'pdf') {
            return Pdf::loadView('admin.reports.inventory-pdf', compact('logs'))->download('inventory-report-'.now()->format('Y-m-d').'.pdf');
        }
        return $this->excelDownload('inventory-report-'.now()->format('Y-m-d').'.xls', ['Tanggal', 'Bahan', 'Opening', 'Closing', 'Usage', 'Satuan'], $logs->map(fn ($log) => [$log->log_date->format('Y-m-d'), $log->ingredient->name, $log->opening_stock, $log->closing_stock, $log->usage, $log->ingredient->unit]));
    }

    private function filteredLogs(Request $request)
    {
        $query = InventoryLog::with('ingredient');
        if ($request->filled('ingredient_id')) $query->where('ingredient_id', $request->integer('ingredient_id'));
        if ($request->filled('date_from')) $query->whereDate('log_date', '>=', $request->date_from);
        if ($request->filled('date_to')) $query->whereDate('log_date', '<=', $request->date_to);
        return $query;
    }

    private function excelDownload(string $filename, array $headers, $rows)
    {
        $html = '<table><tr>'.collect($headers)->map(fn ($header) => '<th>'.e($header).'</th>')->implode('').'</tr>';
        foreach ($rows as $row) $html .= '<tr>'.collect($row)->map(fn ($cell) => '<td>'.e((string) $cell).'</td>')->implode('').'</tr>';
        $html .= '</table>';
        return response($html, 200, ['Content-Type' => 'application/vnd.ms-excel', 'Content-Disposition' => 'attachment; filename="'.$filename.'"']);
    }
}
