<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use SebastianBergmann\Type\NullType;

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
            $table->unsignedBigInteger('purchase_id')->comment('id value purchases table')->index('purchase_id');
            $table->unsignedBigInteger('warehouse_id')->comment('id value warhouses table')->index('warehouse_id');
            $table->unsignedBigInteger('product_id')->comment('id value product table')->index('product_id');
            $table->string('product_name')->nullable()->default(NULL)->index('product_name');
            $table->string('sku', 20)->nullable()->default(NULL)->index('sku');
            $table->string('serial_number')->nullable()->default(NULL)->index('serial_number')->comment('formate Ymd-string');
            $table->string('group_number', 100)->default(NULL)->nullable()->comment('generate when product is serialized')->index('group_number')->comment('formate Ymd-string');
            $table->integer('product_qty')->default(0);
            $table->integer('received_qty')->default(0)->nullable();
            $table->integer('sold_qty')->default(0)->nullable();
            $table->float('unit_price')->default(0); //10 pricition , 4 fraction
            $table->float('product_discount')->default(0)->nullable(); //
            $table->string('tax_name', 255)->default(NULL)->nullable();
            $table->float('tax_rate', 14, 4)->default(0)->nullable(); //8 precision, 4 fraction
            $table->float('tax_amount', 14, 4)->default(0)->nullable();
            $table->float('whole_price', 14, 4)->default(0)->nullable()->comment('qty*unite_price');
            $table->float('subtotal')->default(0); //12 precision, 4 fraction
            $table->dateTime('package_date')->default(NULL)->nullable();
            $table->dateTime('expire_date')->default(NULL)->nullable();
            $table->tinyInteger('is_serialized')->default(0)->nullable()->comment('1=true, 0=false');
            $table->text('description')->nullable()->default(NULL);
            $table->tinyInteger('status')->default(0)->nullable()->comment('0=available, 1=sold out');
            $table->tinyInteger('is_taxable')->default(0)->nullable()->comment('0=no, 1=yes');
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
