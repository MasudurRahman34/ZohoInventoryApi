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
        Schema::create('thanas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("district_id")->index();
            $table->string("thana_name",150)->index();
            $table->string("thana_slug",150)->nullable()->default(NULL);
            
            /* Common fields for all table*/
            
            $table->integer("sort")->default(0)->nullable();
            $table->tinyInteger("status")->default(0);
            $table->unsignedBigInteger('created_by')->default(1)->index();
            $table->unsignedBigInteger('modified_by')->default(0);
            $table->unsignedBigInteger('account_id')->default(0);
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
        Schema::dropIfExists('thanas');
    }
};
