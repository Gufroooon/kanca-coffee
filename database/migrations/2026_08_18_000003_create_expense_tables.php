<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->date('date')->index();
            $table->string('holding_account', 10)->default('EXP');
            $table->string('ref_number', 60)->unique();
            $table->string('invoice_number', 80)->nullable();
            $table->string('title', 150);
            $table->foreignId('supplier_id')->nullable()->constrained('suppliers')->nullOnDelete();
            $table->enum('status', ['Lunas', 'Pending'])->default('Lunas')->index();
            $table->string('invoice_path', 255)->nullable();
            $table->decimal('total_amount', 15, 2)->default(0); // Sum of subtotal_3 of details
            $table->text('notes')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('expense_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('expense_id')->constrained('expenses')->cascadeOnDelete();
            $table->string('item_name', 150);
            $table->foreignId('financial_sub_account_id')->nullable()->constrained('financial_sub_accounts')->nullOnDelete();
            $table->foreignId('expense_category_id')->nullable()->constrained('expense_categories')->nullOnDelete();
            $table->enum('cost_category', ['Fixed', 'Variable'])->default('Variable')->index();
            $table->foreignId('ingredient_id')->nullable()->constrained('ingredients')->nullOnDelete(); // for stock update integration
            $table->decimal('qty', 12, 3)->default(1);
            $table->decimal('price', 15, 2)->default(0);
            $table->decimal('delivery_fee', 15, 2)->default(0);
            $table->decimal('delivery_insurance', 15, 2)->default(0);
            $table->decimal('admin_app_fee', 15, 2)->default(0);
            $table->decimal('item_discount', 15, 2)->default(0);
            $table->decimal('delivery_discount', 15, 2)->default(0);
            $table->decimal('ppn', 15, 2)->default(0);
            $table->decimal('bank_admin', 15, 2)->default(0);
            $table->decimal('subtotal_1', 15, 2)->default(0); // (qty*price) + delivery + insurance + admin_app - item_disc - deliv_disc
            $table->decimal('subtotal_2', 15, 2)->default(0); // subtotal_1 + ppn
            $table->decimal('subtotal_3', 15, 2)->default(0); // subtotal_2 + bank_admin
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expense_details');
        Schema::dropIfExists('expenses');
    }
};
