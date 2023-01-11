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
        Schema::create('purchase_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('purchase_id')->comment('id value purchases table');
            $table->unsignedBigInteger('warehouse_id')->comment('id value warhouses table');
            $table->unsignedBigInteger('product_id')->comment('id value product table');
            $table->string('serial_number',100)->nullable()->default(NULL);
            $table->integer('product_qty')->default(0);
            $table->integer('received_qty')->default(0)->nullable();
            $table->float('unit_price',10,4)->default(0);
            $table->float('product_discount',10,4)->default(0);
            $table->float('product_tax',10,4)->default(0);
            $table->float('subtotal',12,4)->default(0);
    
            $table->text('description')->nullable()->default(NULL);
            $table->integer('account_id')->default(1)->comment('Reference of account');
            $table->integer('created_by')->default(0);
            $table->integer('modified_by')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->index(['product_id','purchase_id','account_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_items');
    }
};
