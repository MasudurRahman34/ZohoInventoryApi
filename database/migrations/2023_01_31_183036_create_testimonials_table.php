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
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('employee_name');
            $table->string('position')->default(NULL)->nullable();
            $table->string('title')->default(NULL)->nullable();
            $table->string('company_logo')->default(NULL)->nullable();
            $table->string('company_name')->default(NULL)->nullable();
            $table->string('company_address')->default(NULL)->nullable();
            $table->string('image')->default(NULL)->nullable();
            $table->string('video')->default(NULL)->nullable();
            $table->text('description')->default(NULL)->nullable();
            $table->unsignedBigInteger('account_id')->default(1)->comment('Reference of account');
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
        Schema::dropIfExists('testimonials');
    }
};
