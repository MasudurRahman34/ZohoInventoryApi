<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Carbon;
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
        Schema::create('adjustment_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inventory_adjustment_id')->comment('ref inventory_adjustment table')->index();
            $table->unsignedBigInteger('product_id')->comment('ref product table')->index();
            $table->unsignedBigInteger('warehouse_id')->default(0)->comment('ref warehouses table')->index();    
            $table->dateTime("item_adjustment_date")->default(Carbon::now());
            $table->integer('quantity');
            $table->integer('quantity_available')->default(0)->nullable();
            $table->integer('new_quantity_on_hand')->default(0)->nullable();
            $table->text('description')->nullable()->default(NULL);            
            $table->unsignedTinyInteger('status')->default(0)->comment('0=pending, 1=approved,2=cancel');
            $table->unsignedBigInteger('account_id')->default(1)->index();
            $table->unsignedBigInteger('created_by')->default(0)->index();
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
        Schema::dropIfExists('adjustment_items');
    }
};
