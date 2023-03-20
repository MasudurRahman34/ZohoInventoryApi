<?php

use Egulias\EmailValidator\Parser\Comment;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use SebastianBergmann\Type\NullType;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('purchase_id')->comment('purchase table id')->index();
            $table->morphs('addressable');
            $table->enum('deliver_to', ['warehouse', 'customer'])->default('warehouse')->nullable()->comment("warehouse, customer");
            $table->enum('type', ['billing', 'shipping'])->default('billing')->nullable()->comment("billing, shipping");
            $table->string('company_name')->comment('company/reciever name')->default(NULL)->nullable();
            $table->string('display_name')->default(NULL)->nullable();
            $table->text('company_info')->default(NUll)->nullable()->comment('company/sender info');
            $table->text('company_logo')->default(NUll)->nullable()->comment('sender company_logo');
            $table->text('client_info')->default(NUll)->nullable()->comment('receiver info');
            $table->text('additional_info')->default(NUll)->nullable()->comment('receiver additional info');
            $table->string('attention')->default(NULL)->nullable();
            $table->string('first_name', 100)->default(NULL)->nullable();
            $table->string('last_name', 100)->default(NULL)->nullable();
            $table->string('mobile', 20)->default(NULL)->nullable();
            $table->string('mobile_country_code', 20)->default(NULL)->nullable();
            $table->string('email')->default(NULL)->nullable();
            $table->string('phone', 20)->nullable()->defalut(NULL)->comment('Phone number');
            $table->string('fax', 20)->nullable()->defalut(NULL)->comment('fax number');
            $table->string('website')->nullable()->defalut(NULL)->comment('website');
            $table->string('tax_number', 20)->nullable()->defalut(NULL)->comment('tax registration number');
            $table->unsignedBigInteger('country_id')->nullable()->default(0)->comment('Reference of country');
            $table->string('country_name')->nullable()->default(0)->comment('Reference of country iso2, iso3');
            $table->string('state_name', 50)->nullable()->default(0)->comment('Reference of states');
            $table->string('district_name', 50)->nullable()->default(0)->comment('Reference of district');
            $table->string('thana_name', 50)->nullable()->default(0)->comment('Reference of thana');
            $table->string('union_name', 50)->nullable()->default(0)->comment('Reference of union');
            $table->string('zipcode', 20)->nullable()->default(0)->comment('Reference of zipcodes');
            $table->string('street_address_line_1')->nullable()->default(0)->comment('Reference of street_address');
            $table->string('street_address_line_2')->nullable()->default(0)->comment('Reference of street_address');
            $table->string('house')->nullable()->default(NULL)->comment();
            $table->text('plain_address')->default(NULL)->nullable();
            $table->json('full_address')->nullable()->default(NULL)->comment('Keep full address as json format, as key/value pair. key is the reference id');
            $table->tinyInteger('is_bill_address')->default(0)->nullable()->comment('this field is used for bill address 0=no 1=yes');
            $table->tinyInteger('is_ship_address')->default(0)->nullable()->comment('this field is used for bill address 0=no 1=yes');
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
        Schema::dropIfExists('purchase_addresses');
    }
};
