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
        Schema::create('company_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('icon')->nullable()->default(null)->comment('Icon image for the business category');
            $table->integer('parent')->nullable()->default(0)->comment('Id value of same model to specify its parent.');
            $table->enum('default', ['yes', 'no'])->default('no')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('inactive');
            $table->unsignedTinyInteger('sort')->default(0)->nullable();
            $table->unsignedBigInteger('account_id')->default(1)->comment('Reference of account table.');
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
        Schema::dropIfExists('company_categories');
    }
};
