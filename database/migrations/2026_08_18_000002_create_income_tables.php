<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('majoo_cash', function (Blueprint $table) {
            $table->id();
            $table->date('date')->index();
            $table->decimal('cashier_amount', 15, 2)->default(0);
            $table->decimal('actual_amount', 15, 2)->default(0);
            $table->decimal('difference', 15, 2)->default(0); // actual - cashier
            $table->text('notes')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->unique('date');
        });

        Schema::create('majoo_transfers', function (Blueprint $table) {
            $table->id();
            $table->date('date')->index();
            $table->decimal('amount', 15, 2)->default(0);
            $table->text('notes')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->unique('date');
        });

        Schema::create('majoo_qris_cetaks', function (Blueprint $table) {
            $table->id();
            $table->date('date')->index();
            $table->decimal('amount', 15, 2)->default(0);
            $table->text('notes')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->unique('date');
        });

        Schema::create('majoo_edc_transactions', function (Blueprint $table) {
            $table->id();
            $table->enum('edc_type', ['qris_edc', 'debit', 'credit'])->index();
            $table->date('proc_date')->nullable();
            $table->string('mid', 50)->nullable();
            $table->string('ob', 50)->nullable();
            $table->string('gb', 50)->nullable();
            $table->string('seq', 50)->nullable();
            $table->string('type', 20)->nullable();
            $table->date('trx_date')->index();
            $table->string('auth', 50)->nullable();
            $table->string('card_no', 50)->nullable();
            $table->decimal('amount', 15, 2)->default(0);
            $table->string('tid', 50)->nullable();
            $table->string('jenis_trx', 50)->nullable();
            $table->string('ptr', 50)->nullable();
            $table->decimal('rate', 8, 4)->default(0);
            $table->decimal('disc_amount', 15, 2)->default(0);
            $table->decimal('air_fare', 15, 2)->default(0);
            $table->string('plan', 50)->nullable();
            $table->decimal('ss_amount', 15, 2)->default(0);
            $table->string('ss_fee_type', 50)->nullable();
            $table->string('flag', 50)->nullable();
            $table->decimal('nett_amount', 15, 2)->default(0);
            $table->string('merchant_account', 100)->nullable();
            $table->string('merchant_name', 120)->nullable();
            $table->string('fingerprint_hash', 64)->nullable()->index(); // for duplicate detection
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('gobiz_transactions', function (Blueprint $table) {
            $table->id();
            $table->date('date')->index();
            $table->decimal('gross_sales', 15, 2)->default(0);
            $table->decimal('commission_fee', 15, 2)->default(0);
            $table->decimal('promo_fee', 15, 2)->default(0);
            $table->decimal('ads_fee', 15, 2)->default(0);
            $table->decimal('discount_fee', 15, 2)->default(0);
            $table->decimal('net_sales', 15, 2)->default(0); // Gross - (Commission + Promo + Ads + Discount)
            $table->text('notes')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->unique('date');
        });

        Schema::create('incomes', function (Blueprint $table) {
            $table->id();
            $table->date('date')->index();
            $table->string('holding_account', 10)->default('INC');
            $table->string('ref_number', 50)->unique();
            $table->enum('type', ['MJO', 'GBZ'])->index(); // MJO = Majoo POS, GBZ = GoBiz
            $table->decimal('amount', 15, 2)->default(0);
            $table->text('notes')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('incomes');
        Schema::dropIfExists('gobiz_transactions');
        Schema::dropIfExists('majoo_edc_transactions');
        Schema::dropIfExists('majoo_qris_cetaks');
        Schema::dropIfExists('majoo_transfers');
        Schema::dropIfExists('majoo_cash');
    }
};
