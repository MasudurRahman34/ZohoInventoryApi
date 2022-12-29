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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('supplier_id')->comment('id value suppliers table');
            $table->unsignedBigInteger('warehouse_id')->comment('id value warhouses table');
            $table->string('invoice_no',50)->nullable()->default(NULL);
            $table->string('reference',50)->nullable()->default(NULL);
            $table->float('total_amount',12,4)->default(0);
            $table->float('due_amount',12,4)->default(0);
            $table->float('paid_amount',12,4)->default(0);
            $table->float('grand_total_amount',12,4)->default(0);
            $table->float('order_discount',10,4)->default(0);
            $table->float('discount_currency')->default(0);
            $table->float('order_tax')->default(0);
            $table->float('order_tax_amount',10,2)->default(0);
            $table->float('shipping_charge',10,4)->default(0);
            $table->float('order_adjustment',12,4)->default(0);
            $table->float('last_paid_amount',12,4)->default(0);
            $table->string('adjustment_text')->nullable()->default(NULL);
            $table->dateTime('purchase_date')->nullable()->default(NULL);
            $table->dateTime('delivery_date')->nullable()->default(NULL);
            $table->string('attachment_file')->nullable()->default(NULL);
            $table->string('image')->nullable()->default(NULL);
            $table->enum('status',['0','1'])->nullable()->default(NULL);
            $table->enum('payment_status',['0','1','2'])->default(0)->comment('0=unpaid, 1 =paid,2=Partial Paid');
            $table->integer('account_id')->default(1)->comment('Reference of account');
            $table->integer('created_by')->default(0);
            $table->integer('modified_by')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->index(['warehouse_id','purchase_date','account_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchases');
    }
};
