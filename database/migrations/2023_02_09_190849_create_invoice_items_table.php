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
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('invoice_id');
            $table->unsignedInteger('product_id')->default(NULL)->nullable();
            $table->string('product_name')->default(NULL)->nullable();
            $table->string('serial_number')->default(NULL)->nullable();
            $table->text('product_description')->default(NULL)->nullable();
            $table->unsignedBigInteger('warehouse_id')->default(NULL)->nullable();
            $table->unsignedBigInteger('order_id')->default(NULL)->nullable();
            $table->string('order_number')->default(NULL)->nullable();
            $table->float('product_qty')->default(1)->nullable();
            $table->float('unit_price')->default(0);
            $table->float('product_discount')->default(0)->nullable();
            $table->float('product_tax')->default(0)->nullable();
            $table->float('subtotal')->default(0);
            $table->text('description')->default(NULL)->nullable();
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
        Schema::dropIfExists('invoice_items');
    }
};
