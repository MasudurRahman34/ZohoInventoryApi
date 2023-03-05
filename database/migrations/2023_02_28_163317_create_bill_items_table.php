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
        Schema::create('bill_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('bill_id');
            $table->unsignedInteger('product_id')->default(NULL)->nullable();
            $table->unsignedBigInteger('warehouse_id')->default(NULL)->nullable();

            $table->string('product_name')->default(NULL)->nullable();
            $table->string('serial_number')->default(NULL)->nullable();
            $table->string('group_number')->default(NULL)->nullable();
            $table->text('product_description')->default(NULL)->nullable();
            $table->dateTime('service_date')->default(NULL)->nullable();

            $table->unsignedBigInteger('order_id')->default(NULL)->nullable();
            $table->string('order_number')->default(NULL)->nullable();
            $table->float('product_qty', 14, 4)->default(1)->nullable();
            $table->float('unit_price', 14, 4)->default(0);
            $table->float('product_discount', 14, 4)->default(0)->nullable();
            $table->string('tax_name', 255)->default(NULL)->nullable();
            $table->float('tax_rate', 14, 4)->default(0)->nullable();
            $table->float('tax_amount', 14, 4)->default(0)->nullable();
            $table->float('whole_price', 14, 4)->default(0)->nullable()->comment('qty*unite_price');
            $table->float('subtotal', 14, 4)->default(0)->comment("(whole_price+tax_amount)-discount");
            $table->tinyInteger('is_taxable')->default(0)->nullable();
            $table->tinyInteger('is_serialized')->default(0)->nullable();
            $table->integer('sort')->default(NULL)->nullable();
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
        Schema::dropIfExists('bill_items');
    }
};
