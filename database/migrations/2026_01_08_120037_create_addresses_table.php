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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
             $table->unsignedBigInteger('user_id')->index();
                $table->enum('type', ['home', 'office', 'other'])->default('home');

                $table->string('full_name');
                $table->string('phone');

                $table->string('pincode', 10);
                $table->text('address_line1');
                $table->text('address_line2')->nullable();
                $table->string('city');
                
    $table->unsignedBigInteger('state_id')->nullable();
                $table->string('landmark')->nullable();

                $table->boolean('is_default')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
