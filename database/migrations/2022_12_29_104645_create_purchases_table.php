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
            $table->uuid('uuid')->unique()->index();
            $table->unsignedBigInteger('supplier_id')->comment('id value suppliers table');
            $table->unsignedBigInteger('warehouse_id')->comment('id value warhouses table');
            $table->string('invoice_no',50)->nullable()->default(NULL);
            $table->string('reference',50)->nullable()->default(NULL);
            $table->float('total_amount')->default(0); //12 precision, 4 fraction
            $table->float('due_amount')->default(0);
            $table->float('paid_amount')->default(0);
            $table->float('grand_total_amount')->default(0);
            $table->float('order_discount')->default(0);
            $table->float('discount_currency')->default(0);
            $table->float('order_tax')->default(0);
            $table->float('order_tax_amount')->default(0);
            $table->float('shipping_charge')->default(0);
            $table->float('order_adjustment')->default(0);
            $table->float('last_paid_amount')->default(0);
            $table->string('adjustment_text')->nullable()->default(NULL);
            $table->dateTime('purchase_date')->nullable()->default(NULL);
            $table->dateTime('delivery_date')->nullable()->default(NULL);
            $table->string('attachment_file')->nullable()->default(NULL);
            $table->string('image')->nullable()->default(NULL);
            $table->tinyInteger('status')->nullable()->default(0);
            $table->tinyInteger('payment_status')->default(0)->comment('0=unpaid, 1 =paid,2=Partial Paid');
            $table->unsignedBigInteger('account_id')->default(1)->comment('Reference of account');
            $table->unsignedBigInteger('created_by')->default(0);
            $table->unsignedBigInteger('modified_by')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->index(['supplier_id','purchase_date','account_id']);
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
