<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('financial_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('holding_type', 10); // INC or EXP
            $table->string('code', 20)->unique();
            $table->string('name', 100);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('financial_sub_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('financial_account_id')->constrained('financial_accounts')->cascadeOnDelete();
            $table->string('code', 20)->unique();
            $table->string('name', 100);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('expense_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 120);
            $table->string('phone', 30)->nullable();
            $table->text('address')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Seed initial reference master accounts from template & brief
        $now = now();
        
        // Holding EXP Accounts
        $opsId = DB::table('financial_accounts')->insertGetId([
            'holding_type' => 'EXP', 'code' => 'OPS', 'name' => 'Operasional & Utilities', 'created_at' => $now, 'updated_at' => $now
        ]);
        $finId = DB::table('financial_accounts')->insertGetId([
            'holding_type' => 'EXP', 'code' => 'FIN', 'name' => 'Finansial & Payroll', 'created_at' => $now, 'updated_at' => $now
        ]);
        $mktId = DB::table('financial_accounts')->insertGetId([
            'holding_type' => 'EXP', 'code' => 'MKT', 'name' => 'Marketing & Pemasaran', 'created_at' => $now, 'updated_at' => $now
        ]);
        $othId = DB::table('financial_accounts')->insertGetId([
            'holding_type' => 'EXP', 'code' => 'OTH', 'name' => 'Lain-lain', 'created_at' => $now, 'updated_at' => $now
        ]);
        $csnId = DB::table('financial_accounts')->insertGetId([
            'holding_type' => 'EXP', 'code' => 'CSN', 'name' => 'Konsinyasi', 'created_at' => $now, 'updated_at' => $now
        ]);

        // Sub Accounts for EXP
        $subAccounts = [
            ['financial_account_id' => $opsId, 'code' => 'BAH', 'name' => 'Bahan Baku'],
            ['financial_account_id' => $opsId, 'code' => 'UTI', 'name' => 'Utilities'],
            ['financial_account_id' => $opsId, 'code' => 'AST', 'name' => 'Aset'],
            ['financial_account_id' => $finId, 'code' => 'PAY', 'name' => 'Payroll'],
            ['financial_account_id' => $opsId, 'code' => 'WIF', 'name' => 'Wifi'],
            ['financial_account_id' => $opsId, 'code' => 'STA', 'name' => 'Stationery'],
            ['financial_account_id' => $opsId, 'code' => 'LIS', 'name' => 'Listrik'],
            ['financial_account_id' => $opsId, 'code' => 'AIR', 'name' => 'PDAM / Air'],
            ['financial_account_id' => $opsId, 'code' => 'MTC', 'name' => 'Maintenance'],
            ['financial_account_id' => $mktId, 'code' => 'MKT', 'name' => 'Marketing'],
            ['financial_account_id' => $opsId, 'code' => 'RND', 'name' => 'RnD'],
            ['financial_account_id' => $othId, 'code' => 'OTH', 'name' => 'Other'],
            ['financial_account_id' => $csnId, 'code' => 'CSN', 'name' => 'Consignment'],
            ['financial_account_id' => $opsId, 'code' => 'TBL', 'name' => 'Team Building'],
        ];

        foreach ($subAccounts as $sub) {
            DB::table('financial_sub_accounts')->insert(array_merge($sub, ['created_at' => $now, 'updated_at' => $now]));
        }

        // Seed initial Expense Categories
        $categories = [
            'Bahan Baku', 'Bahan Baku Bar', 'Bahan Baku Kitchen', 'Utilities', 'Listrik',
            'PDAM', 'Wifi', 'Stationery', 'Maintenance', 'Marketing', 'RnD', 'Asset',
            'Payroll', 'Consignment', 'Other'
        ];
        foreach ($categories as $cat) {
            DB::table('expense_categories')->insert(['name' => $cat, 'created_at' => $now, 'updated_at' => $now]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('suppliers');
        Schema::dropIfExists('expense_categories');
        Schema::dropIfExists('financial_sub_accounts');
        Schema::dropIfExists('financial_accounts');
    }
};
