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
        Schema::create('unions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("thana_id");
            $table->string("union_name",150);
            $table->string("union_slug",150);
            
            /* Common fields for all table*/
            
            $table->integer("sort")->default(0)->nullable();
            $table->tinyInteger("status")->default(1);
            $table->unsignedBigInteger('created_by')->default(1);
            $table->unsignedBigInteger('modified_by')->default(1);
            $table->unsignedBigInteger('account_id')->default(1);
            $table->timestamps();
            $table->softDeletes();
            $table->index(['thana_id', 'account_id','union_name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('unions');
    }
};
