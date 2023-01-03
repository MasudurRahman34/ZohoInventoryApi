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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id')->comment('id value suppliers table');
            $table->unsignedBigInteger('warehouse_id')->comment('id value warhouses table');
            $table->string('order_number',50)->nullable()->default(NULL);
            $table->dateTime('sales_order_date')->nullable()->default(NULL);
            $table->dateTime('expected_shipment_date')->nullable()->default(NULL);
            $table->text('billing_address')->nullable()->default(NULL);
            $table->text('shipping_address')->nullable()->default(NULL);
            $table->string('delivery_method',255)->nullable()->default(NULL);
            $table->string('reference',50)->nullable()->default(NULL);
            $table->float('order_discount',10,4)->default(0);
           
            $table->integer('discount_currency')->default(0)->nullable();
            $table->float('order_discount_amount',10,4)->default(0);
            $table->integer('order_tax')->nullable()->default(0);
            $table->float('order_tax_amount',10,2)->default(0);
            $table->float('shipping_charge',10,4)->default(0);
            $table->float('order_adjustment',12,4)->default(0);
            $table->text('adjustment_text')->nullable()->default(NULL);
            $table->text('customer_note')->nullable()->default(NULL);
            $table->text('terms_condition')->nullable()->default(NULL);
            $table->float('total_amount',12,4)->default(0);
            $table->float('grand_total_amount',12,4)->default(0);
            $table->float('due_amount',12,4)->default(0);
            $table->float('paid_amount',12,4)->default(0);
            $table->float('recieved_amount',12,4)->default(0);
            $table->float('changed_amount',12,4)->default(0);
            $table->float('last_paid_amount',12,4)->default(0);
            $table->string('attachment_file')->nullable()->default(NULL);
            $table->string('image')->nullable()->default(NULL);
            $table->string('offer_to',512)->nullable()->default(NULL);
            $table->string('offer_subject',512)->nullable()->default(NULL);
            $table->string('offer_greetings',512)->nullable()->default(NULL);
            $table->string('offer_terms_condition',512)->nullable()->default(NULL);
            $table->tinyInteger('invoice_status')->default(0)->comment('0=pending, 1=invoiced');
            $table->tinyInteger('shipment_status')->default(0)->comment('0 = Pending; 1 = Shipped');
            $table->tinyInteger('status')->nullable()->default(0)->commnet('0 = Draft; 1 = Confirmed; 2 = Closed');
            $table->tinyInteger('payment_status')->default(0)->comment('0=unpaid, 1 =paid,2=Partial Paid');
            $table->tinyInteger('sales_type')->default(0)->comment('1 = POS Sales; 2 = Order Sales');
            $table->unsignedBigInteger('salesperson')->nullable()->default(NULL);
            $table->unsignedBigInteger('account_id')->default(1)->comment('Reference of account');
            $table->unsignedBigInteger('created_by')->default(0);
            $table->unsignedBigInteger('modified_by')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->index(['customer_id','sales_order_date','account_id']);
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
