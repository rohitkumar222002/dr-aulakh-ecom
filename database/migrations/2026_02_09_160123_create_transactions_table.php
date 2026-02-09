<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('user_id');

            $table->unsignedBigInteger('from_user_id')->nullable();

            $table->integer('level')->nullable();

            $table->unsignedBigInteger('order_id')->nullable();

            $table->decimal('amount', 18, 2)->default(0);

            $table->string('trx_id')->nullable();

            $table->string('trx_type')->nullable();

            $table->decimal('tax', 12, 2)->nullable();

            $table->text('note')->nullable();

            $table->timestamps();

            $table->index('user_id');
            $table->index('from_user_id');
            $table->index('order_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
