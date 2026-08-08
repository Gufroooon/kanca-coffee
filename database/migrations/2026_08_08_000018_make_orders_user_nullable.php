<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Make user_id nullable so guests (non-logged-in customers) can place orders
            $table->foreignId('user_id')->nullable()->change();
            // Add guest name & customer name fields
            $table->string('customer_name')->nullable()->after('user_id');
            $table->string('customer_note')->nullable()->after('customer_name');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable(false)->change();
            $table->dropColumn(['customer_name', 'customer_note']);
        });
    }
};
