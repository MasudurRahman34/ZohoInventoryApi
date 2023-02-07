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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('plan_name');
            $table->string('price_monthly')->nullable();
            $table->string('price_yearly')->nullable();
            $table->string('business_type', 100);
            $table->tinyInteger('status')->comment('0=inactive, 1=active')->default(1);
            $table->integer('account_id')->default(1);
            $table->integer('created_by')->default(0);
            $table->integer('modified_by')->default(0);

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
        Schema::dropIfExists('plans');
    }
};
