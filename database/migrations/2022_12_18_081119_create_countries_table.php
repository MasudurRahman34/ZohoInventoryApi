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
            $table->char('countryCode',4);
            $table->string('countryName',50);
            $table->string('currency',50)->nullable();
            $table->integer('sort')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->unsignedBigInteger('account_id')->default(1);;
            $table->unsignedBigInteger('created_by')->default(1);
            $table->unsignedBigInteger('modified_by')->default(1);
            $table->timestamps();
            $table->softDeletes();
            $table->index(['countryName', 'account_id','created_at']);
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
