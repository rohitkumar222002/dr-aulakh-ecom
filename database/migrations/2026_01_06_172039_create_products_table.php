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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
          $table->foreignId('category_id')
      ->nullable()
      ->constrained('categories')
      ->cascadeOnDelete();

$table->foreignId('subcategory_id')
      ->nullable()
      ->constrained('subcategories')
      ->cascadeOnDelete();

            $table->string('name');
            $table->string('slug')->unique();
            $table->text('short_description')->nullable();

            // Pricing
            $table->decimal('price', 10, 2);
            $table->decimal('mrp', 10, 2)->nullable();
            $table->decimal('discount_price', 10, 2)->nullable();

            $table->integer('stock_qty')->default(0);

            $table->enum('badge', ['NEW', 'BESTSELLER', 'PREMIUM', 'IMMUNITY'])
                  ->nullable();

            $table->decimal('rating_avg', 2, 1)->default(0);
            $table->integer('rating_count')->default(0);

            $table->string('primary_image')->nullable(); 
            $table->string('images')->nullable(); 

            // Status
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
