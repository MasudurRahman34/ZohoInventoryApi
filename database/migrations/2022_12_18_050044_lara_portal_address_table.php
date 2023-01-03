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
        if (!Schema::hasTable('portal_address')) {
            Schema::create('portal_address', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('ref_object_key', 100)->comment('Required, The reference table for the address. i.e. users | customers | supplires etc.')->default('App\Models\Customers');
                $table->unsignedBigInteger('ref_id')->comment('The id value reference table i.e. users | customers | supplires -  for the address.');

                $table->string('attention')->nullable()->comment('Contact person name for this address');
                $table->integer('country_id')->default(0)->comment('Reference of country');
                $table->unsignedBigInteger('state_id')->default(0)->comment('Reference of states');
                $table->unsignedBigInteger('district_id')->default(0)->comment('Reference of district');
                $table->unsignedBigInteger('thana_id')->default(0)->comment('Reference of thana');
                $table->unsignedBigInteger('union_id')->default(0)->comment('Reference of union');
                $table->unsignedBigInteger('zipcode_id')->default(0)->comment('Reference of zipcodes');
                $table->unsignedBigInteger('street_address_id')->default(0)->comment('Reference of street_address');
                $table->string('house')->nullable()->defalut(NULL)->comment('House/suite/apartment number');
                $table->string('phone', 20)->nullable()->defalut(NULL)->comment('Phone number');
                $table->string('fax', 20)->nullable()->defalut(NULL)->comment('fax number');
                $table->tinyInteger('is_bill_address')->default(0)->nullable()->comment('this field is used for bill address 0=no 1=yes');
                $table->tinyInteger('is_ship_address')->default(0)->nullable()->comment('this field is used for bill address 0=no 1=yes');
                $table->tinyInteger('status')->default(1)->comment('0 = Invalid Address; 1 = Valid Address');
                $table->json('full_address')->nullable()->default(NULL)->comment('Keep full address as json format, as key/value pair. key is the reference id');


                /* Common fields for all table*/

                $table->integer('account_id')->default(1)->comment('Reference of account');
                $table->integer('created_by')->default(0);
                $table->integer('modified_by')->default(0);
                $table->timestamps();
                $table->softDeletes();
                $table->index(['ref_object_key', 'ref_id', 'account_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('portal_address');
    }
};
