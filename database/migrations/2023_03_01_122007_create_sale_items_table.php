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
        Schema::create('sale_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sale_id')->comment('id value sales table')->index();
            $table->unsignedBigInteger('warehouse_id')->comment('id value warhouses table')->index();
            $table->unsignedBigInteger('product_id')->comment('id value product table')->index();
            $table->string('serial_number',100)->nullable()->default(NULL);
            $table->integer('product_qty')->default(0);
            $table->integer('packed_qty')->default(0)->nullable()->comment('This field is used for keep track how much product are packed for this sales');
            $table->integer('shipped_qty')->default(0)->nullable()->comment('This field is used for keep track how much product are shipped for this sales');
            $table->integer('invoice_qty')->default(0)->nullable()->comment('This field is used for keep track how much product are invoiced for this sales');
            $table->float('unit_price',16,4)->default(0);
            $table->float('product_discount',16,4)->nullable()->default(0);
            $table->float('product_tax',16,4)->nullable()->default(0);
            $table->float('subtotal',16,4)->default(0);
    
            $table->text('description')->nullable()->default(NULL);
            $table->tinyInteger('is_serialized')->default(0)->nullable()->comment('0=true, 1=false');
            $table->unsignedBigInteger('account_id')->default(1)->comment('Reference of account');
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
        Schema::dropIfExists('purchase_items');
    }
};
