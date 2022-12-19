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
            $table->unsignedBigInteger("district_id");
            $table->string("thana_name",150);
            $table->string("thana_slug",150);
            
            /* Common fields for all table*/
            
            $table->integer("sort")->default(0)->nullable();
            $table->tinyInteger("status")->default(1);
            $table->unsignedBigInteger('created_by')->default(1);
            $table->unsignedBigInteger('modified_by')->default(1);
            $table->unsignedBigInteger('account_id')->default(1);
            $table->timestamps();
            $table->softDeletes();
            $table->index(['district_id', 'account_id','thana_name']);
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
