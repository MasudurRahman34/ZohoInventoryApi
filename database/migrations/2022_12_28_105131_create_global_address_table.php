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
        Schema::create('global_address', function (Blueprint $table) {
            $table->id();
            $table->integer('country_id')->default(0)->comment('Reference of country');
            $table->unsignedBigInteger('state_id')->default(0)->comment('Reference of states');
            $table->unsignedBigInteger('district_id')->default(0)->comment('Reference of district');
            $table->unsignedBigInteger('thana_id')->default(0)->comment('Reference of thana');
            $table->unsignedBigInteger('union_id')->default(0)->comment('Reference of union');
            $table->unsignedBigInteger('zipcode_id')->default(0)->comment('Reference of zipcodes');
            $table->unsignedBigInteger('street_address_id')->default(0)->comment('Reference of street_address');
            $table->text('plain_address')->comment()->nullable();
            $table->tinyInteger('status')->default(0)->comment('0 = pending; 1 = Approved, 2=reject')->default(1);
            $table->json('full_address')->nullable()->default(NULL)->comment('Keep full address as json format, as key/value pair. key is the reference id');


            /* Common fields for all table*/

            $table->unsignedBigInteger('account_id')->default(1)->comment('Reference of account');
            $table->unsignedBigInteger('created_by')->default(0);
            $table->unsignedBigInteger('modified_by')->default(0);
            $table->timestamps();
            $table->softDeletes();
            //$table->index(['full_address','account_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('global_addresses');
    }
};
