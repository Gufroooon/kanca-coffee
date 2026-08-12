<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ingredient_id')->constrained()->restrictOnDelete();
            $table->date('log_date');
            $table->decimal('opening_stock', 14, 3);
            $table->decimal('closing_stock', 14, 3);
            $table->decimal('usage', 14, 3);
            $table->text('notes')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
            $table->unique(['ingredient_id', 'log_date']);
            $table->index('log_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_logs');
    }
};
