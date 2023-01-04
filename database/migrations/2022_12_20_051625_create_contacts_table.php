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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('ref_object_key', 100)->comment('The reference table for the address. i.e. users | customers | supplires etc.')->default('PORTAL_CUSTOMERS_TBL');
            $table->unsignedBigInteger('ref_id')->comment('The id value reference table i.e. users | customers | supplires -  for the address.');
            $table->string('salutation',20)->nullable();
            $table->string('first_name',50)->nullable();
            $table->string('last_name',50)->nullable();
            $table->string('display_name',150);
            $table->string('company_name')->nullable();
            $table->string('contact_email',100)->nullable();
            $table->string('phone_number_country_code',10)->nullable();
            $table->string('contact_work_phone',20)->nullable();
            $table->string('contact_mobile',20)->nullable();
            $table->string('skype',100)->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
           
            $table->string('designation',150)->nullable();
            $table->string('department',150)->nullable();
            $table->string('website')->nullable();
            $table->tinyInteger('is_primary_contact')->default(0)->comment('This field is used for primary contact status. 0 = Not Primary Contact, 1 = Primary Contact');
            $table->unsignedBigInteger('contact_type_id')->nullable()->comment('id contact_type table');
            $table->unsignedBigInteger('created_by')->default(0);
            $table->unsignedBigInteger('modified_by')->default(0);
            $table->unsignedBigInteger('account_id')->default(1);
            $table->timestamps();
            $table->softDeletes();
            $table->index(['account_id','ref_object_key', 'ref_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
};
