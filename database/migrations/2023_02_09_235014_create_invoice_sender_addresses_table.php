<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_sender_addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_id')->comment('invoice table id')->index();
            $table->string('display_name')->default(NULL)->nullable();
            $table->string('company_name')->comment('company/sender name');
            $table->string('company_logo')->default(NULL)->nullable()->comment('company logo');
            $table->string('attension')->default(NULL)->nullable();
            $table->string('first_name', 100)->default(NULL)->nullable();
            $table->string('last_name', 100)->default(NULL)->nullable();
            $table->string('mobile', 20)->default(NULL)->nullable();
            $table->string('mobile_country_code', 20)->default(NULL)->nullable();
            $table->string('email')->default(NULL)->nullable();
            $table->string('phone', 20)->nullable()->defalut(NULL)->comment('Phone number');
            $table->string('fax', 20)->nullable()->defalut(NULL)->comment('fax number');
            $table->unsignedBigInteger('country_id')->nullable()->default(0)->comment('Reference of country');
            $table->unsignedBigInteger('state_id')->nullable()->default(0)->comment('Reference of states');
            $table->unsignedBigInteger('district_id')->nullable()->default(0)->comment('Reference of district');
            $table->unsignedBigInteger('thana_id')->nullable()->default(0)->comment('Reference of thana');
            $table->unsignedBigInteger('union_id')->nullable()->default(0)->comment('Reference of union');
            $table->unsignedBigInteger('zipcode_id')->nullable()->default(0)->comment('Reference of zipcodes');
            $table->unsignedBigInteger('street_address_id')->nullable()->default(0)->comment('Reference of street_address');
            $table->text('plain_address')->default(NULL)->nullable();
            $table->json('full_address')->nullable()->default(NULL)->comment('Keep full address as json format, as key/value pair. key is the reference id');
            $table->tinyInteger('status')->default(1)->nullable()->comment('0 = Invalid Address; 1 = Valid Address');
            $table->unsignedBigInteger('account_id')->default(1)->index();
            $table->unsignedBigInteger('created_by')->default(0)->index();
            $table->unsignedBigInteger('modified_by')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_sender_addresses');
    }
};
