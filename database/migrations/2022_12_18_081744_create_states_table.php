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
        Schema::create('states', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("country_id");
            $table->string("state_name",100);
            $table->string("state_slug",150);
            $table->tinyInteger("status")->default(0);
            
            /* Common fields for all table*/
            $table->integer("sort")->default(0);
            $table->unsignedBigInteger('account_id')->default(1);;
            $table->unsignedBigInteger('created_by')->default(1);
            $table->unsignedBigInteger('modified_by')->default(1);
            $table->timestamps();
            $table->softDeletes();
            $table->index(['country_id', 'account_id','state_name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('states');
    }
};
