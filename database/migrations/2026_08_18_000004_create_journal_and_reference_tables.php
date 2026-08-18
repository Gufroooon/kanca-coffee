<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reference_sequences', function (Blueprint $table) {
            $table->id();
            $table->string('date_key', 10); // YYYY-MM-DD or YYYY-MM
            $table->string('holding_type', 20); // INC, EXP, EXP_MONTHLY
            $table->integer('daily_sequence')->default(0);
            $table->integer('monthly_sequence')->default(0);
            $table->timestamps();
            $table->unique(['date_key', 'holding_type']);
        });

        Schema::create('journal_entries', function (Blueprint $table) {
            $table->id();
            $table->date('entry_date')->index();
            $table->string('ref_number', 60)->nullable();
            $table->string('holding_account', 10)->index(); // INC or EXP
            $table->decimal('debit', 15, 2)->default(0);
            $table->decimal('credit', 15, 2)->default(0);
            $table->string('source_type', 100)->nullable();
            $table->unsignedBigInteger('source_id')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('journal_entries');
        Schema::dropIfExists('reference_sequences');
    }
};
