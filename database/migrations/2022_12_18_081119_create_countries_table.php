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
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->char('country_code',4)->default(NULL)->nullable();
            $table->string('country_name',100)->index();
            $table->string('currency',100)->nullable()->default(NULL);
            $table->integer('sort')->default(0)->nullable();
            $table->tinyInteger('status')->default(0);
            $table->unsignedBigInteger('account_id')->default(1)->index();
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
        Schema::dropIfExists('countries');
    }
};
