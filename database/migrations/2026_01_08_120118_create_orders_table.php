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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            
        $table->unsignedBigInteger('user_id')->index();
        $table->unsignedBigInteger('address_id')->index();

        $table->decimal('total_amount', 18, 2);

        $table->enum('payment_method', ['cod', 'online'])->default('cod');
        $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending');
        $table->enum('order_status', [
            'processing', 'packed', 'shipped', 'out_for_delivery', 'delivered', 'cancelled'
        ])->default('processing');

        $table->string('order_number')->nullable();
        $table->string('phone')->nullable();
        $table->string('tracking_id')->nullable();
        $table->timestamp('delivered_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
