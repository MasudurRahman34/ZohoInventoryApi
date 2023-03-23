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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->default(NULL)->nullable();
            $table->string('company_category_id')->comment('referece of company category id')->default(0)->nullable();
            $table->unsignedTinyInteger('sort')->default(0)->nullable();
            $table->enum('default', ['yes', 'no'])->default('no');
            $table->enum('status', ['active', 'inactive'])->default('inactive');
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
        Schema::dropIfExists('companies');
    }
};
