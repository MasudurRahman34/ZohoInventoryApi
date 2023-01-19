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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id')->index();
            $table->unsignedBigInteger('warehouse_id')->index();
            $table->dateTime('date')->nullable()->default(now());
            $table->integer('quantity')->default(0)->nullable();
            $table->integer('purchase_quantity')->default(0)->nullable();
            $table->integer('sale_quantity')->default(0)->nullable();
            $table->integer('quantity_on_hand')->default(0)->nullable();
            $table->float('opening_stock_value')->default(0)->nullable();
    
            
            /* Common fields for all table*/
            $table->unsignedBigInteger('account_id')->default(1);
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
        Schema::dropIfExists('stocks');
    }
};
