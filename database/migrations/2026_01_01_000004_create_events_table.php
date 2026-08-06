<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->date('date');
            $table->string('start_time')->default('18:00');
            $table->string('end_time')->default('21:00');
            $table->string('location')->default('Kanca Coffee Main Lounge');
            $table->integer('capacity')->default(50);
            $table->integer('registered_count')->default(0);
            $table->string('poster')->nullable();
            $table->decimal('price', 10, 2)->default(0.00);
            $table->string('speaker_name')->nullable();
            $table->string('speaker_title')->nullable();
            $table->enum('status', ['upcoming', 'ongoing', 'completed', 'cancelled'])->default('upcoming');
            $table->boolean('is_featured')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
