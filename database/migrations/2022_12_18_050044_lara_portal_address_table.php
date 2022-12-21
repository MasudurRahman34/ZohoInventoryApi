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
        if (!Schema::hasTable('lara_portal_address')) {
            Schema::create('lara_portal_address', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('ref_object_key', 100)->comment('The reference table for the address. i.e. users | customers | supplires etc.')->default('CUSTOMERS');
                $table->unsignedBigInteger('ref_id')->comment('The id value reference table i.e. users | customers | supplires -  for the address.');

                $table->string('attention')->comment('Contact person name for this address')->nullable();
                $table->unsignedBigInteger('country_id')->default(0)->comment('The id value country table');
                $table->unsignedBigInteger('state_id')->default(0)->comment('The id value states table');
                $table->unsignedBigInteger('district_id')->default(0)->comment('The id value district table');
                $table->unsignedBigInteger('thana_id')->default(0)->comment('The id value thana table');
                $table->unsignedBigInteger('union_id')->default(0)->comment('The id value union table');
                $table->unsignedBigInteger('zipcode_id')->default(0)->comment('The id value zipcodes table');
                $table->unsignedBigInteger('street_address_id')->default(0)->comment('The id value street_address table');
                $table->string('house')->comment('House/suite/apartment number')->nullable();
                $table->string('phone',20)->comment('Phone number')->nullable();
                $table->string('fax',20)->comment('fax number')->nullable();
                $table->tinyInteger('is_bill_address')->comment('this field is used for bill address 0=no 1=yes')->default(0)->nullable();
                $table->tinyInteger('is_ship_address')->comment('this field is used for bill address 0=no 1=yes')->default(0)->nullable();
                $table->tinyInteger('status')->comment('0 = Invalid Address; 1 = Valid Address')->default(0);
                $table->json('address')->comment('address_json')->nullable();
                

                /* Common fields for all table*/
               
                $table->unsignedBigInteger('account_id')->default(0);
                $table->unsignedBigInteger('created_by')->default(0);
                $table->unsignedBigInteger('modified_by')->default(0);
                $table->timestamps();
                $table->softDeletes();
                $table->index(['ref_object_key','ref_id','account_id']);
    
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
        //
    }
};
