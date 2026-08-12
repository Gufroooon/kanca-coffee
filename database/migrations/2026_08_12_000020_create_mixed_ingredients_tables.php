<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mixed_ingredients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('unit', 20);
            $table->decimal('output_quantity', 14, 3);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('mixed_ingredient_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mixed_ingredient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('ingredient_id')->constrained()->restrictOnDelete();
            $table->decimal('quantity', 14, 3);
            $table->timestamps();
            $table->unique(['mixed_ingredient_id', 'ingredient_id']);
        });

        Schema::create('mixed_ingredient_productions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mixed_ingredient_id')->constrained()->restrictOnDelete();
            $table->decimal('quantity', 14, 3);
            $table->date('produced_at');
            $table->text('notes')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mixed_ingredient_productions');
        Schema::dropIfExists('mixed_ingredient_items');
        Schema::dropIfExists('mixed_ingredients');
    }
};
