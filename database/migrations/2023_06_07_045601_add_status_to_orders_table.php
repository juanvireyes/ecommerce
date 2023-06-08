<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('order_number')->nullable()->after('user_id');
            $table->string('url')->nullable()->after('order_number');
            $table->enum('currency', ['USD', 'EUR', 'COP'])->default('USD')->after('url');
            $table->enum('status', ['pending', 'completed', 'approved', 'rejected', 'cancelled'])
                    ->default('pending')->after('currency');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('order_number');
            $table->dropColumn('url');
            $table->dropColumn('currency');
            $table->dropColumn('status');
        });
    }
};
