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
            $table->unsignedBigInteger('purchase_id')->comment('id value purchases table');
            $table->unsignedBigInteger('warehouse_id')->comment('id value warhouses table');
            $table->unsignedBigInteger('product_id')->comment('id value product table');
            $table->string('product_name')->nullable()->default(NULL);
            $table->string('serial_number')->nullable()->default(NULL);
            $table->string('group_number',100)->default(NULL)->nullable()->comment('generate when product is serialized');
            $table->integer('product_qty')->default(0);
            $table->integer('received_qty')->default(0)->nullable();
            $table->integer('sold_qty')->default(0)->nullable();
            $table->float('unit_price')->default(0); //10 pricition , 4 fraction
            $table->float('product_discount')->default(0)->nullable(); //
            $table->float('product_tax')->default(0)->nullable(); //8 precision, 4 fraction
            $table->float('subtotal')->default(0); //12 precision, 4 fraction
            $table->dateTime('package_date')->default(NULL)->nullable();
            $table->dateTime('expire_date')->default(NULL)->nullable();
            $table->tinyInteger('is_serialized')->default(0)->nullable()->comment('0=true, 1=false');
            $table->text('description')->nullable()->default(NULL);
            $table->tinyInteger('status')->default(0)->nullable()->comment('0=available, 1=sold out');
            $table->tinyInteger('is_taxable')->default(0)->nullable()->comment('0=no, 1=yes');
            $table->unsignedBigInteger('account_id')->default(1)->comment('Reference of account');
            $table->unsignedBigInteger('created_by')->default(0);
            $table->unsignedBigInteger('modified_by')->default(0);
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
