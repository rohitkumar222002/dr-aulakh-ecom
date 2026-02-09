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
        Schema::table('products', function (Blueprint $table) {
           $table->decimal('purchase_gst', 8, 2)->nullable()->after('mrp');
        $table->decimal('net_cost', 12, 2)->nullable()->after('purchase_gst');

        $table->decimal('sale_gst', 8, 2)->nullable()->after('discount_price');
        $table->decimal('distribute', 8, 2)->nullable()->after('sale_gst');

        $table->decimal('payable_gst', 12, 2)->nullable()->after('distribute');
        $table->decimal('profit_amount', 12, 2)->nullable()->after('payable_gst');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
             $table->dropColumn([
            'purchase_gst',
            'net_cost',
            'sale_gst',
            'distribute',
            'payable_gst',
            'profit_amount'
        ]);
        });
    }
};
