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
        Schema::create('warehouses', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->index()->default(NULL);
            $table->string('name',255);
            $table->string('code',50)->default(NULL)->nullable();
            $table->string('phone_country_code',10)->default(NULL)->nullable();
            $table->string('mobile_country_code',10)->default(NULL)->nullable();
            $table->integer('phone')->default(NULL)->nullable();
            $table->integer('mobile')->default(NULL)->nullable();
            $table->string('email')->unique('email')->default(NULL)->nullable();
            $table->text('description')->default(NULL)->nullable();
            $table->text('address')->default(NULL)->nullable();
            $table->float('current_balance')->default(0)->nullable();
            $table->unsignedBigInteger('account_id')->default(1)->comment('Reference of user account')->index();
            $table->unsignedBigInteger('created_by')->default(0);
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
        Schema::dropIfExists('warehouses');
    }
};
