<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('users', function (Blueprint $table) {
        // Profile

        // KYC
        $table->string('aadhaar_number', 12)->nullable();
        $table->string('pan_number', 10)->nullable();
        $table->enum('kyc_status', ['pending', 'approved', 'rejected'])->default('pending');

        // Bank
        $table->string('bank_name')->nullable();
        $table->string('account_number')->nullable();
        $table->string('ifsc_code', 20)->nullable();
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn([
            'dob',
            'aadhaar_number','pan_number','kyc_status',
            'bank_name','account_number','ifsc_code'
        ]);
    });
}

};
