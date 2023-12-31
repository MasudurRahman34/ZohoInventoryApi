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
        Schema::create('item_adjustment_reasons', function (Blueprint $table) {
            $table->id();
            $table->string('reason_name',255);
            $table->text('desription')->default(NULL)->nullable();
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
        Schema::dropIfExists('item_adjustment_reasons');
    }
};
