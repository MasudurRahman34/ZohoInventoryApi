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
            $table->uuid('uuid')->unique()->index()->default(NULL)->nullale();
            $table->unsignedBigInteger('customer_id')->comment('id value suppliers table')->index();
            $table->unsignedBigInteger('warehouse_id')->comment('id value warhouses table')->index();
            $table->string('order_number',50)->nullable()->default(NULL);
            $table->dateTime('sales_order_date')->nullable()->default(NULL);
            $table->dateTime('expected_shipment_date')->nullable()->default(NULL);
            $table->text('billing_address')->nullable()->default(NULL);
            $table->text('shipping_address')->nullable()->default(NULL);
            $table->string('delivery_method',255)->nullable()->default(NULL);
            $table->string('reference',50)->nullable()->default(NULL);
            $table->float('order_discount',16,4)->default(0);
            $table->integer('discount_currency')->default(0)->nullable();
            $table->float('order_discount_amount',16,4)->default(0);
            $table->integer('order_tax')->nullable()->default(0);
            $table->float('order_tax_amount',16,4)->default(0);
            $table->float('shipping_charge',16,4)->default(0);
            $table->float('order_adjustment',16,4)->default(0);
            $table->text('adjustment_text')->nullable()->default(NULL);
            $table->text('customer_note')->nullable()->default(NULL);
            $table->text('terms_condition')->nullable()->default(NULL);
            $table->float('total_amount',16,4)->default(0);
            $table->float('grand_total_amount',16,4)->default(0);
            $table->float('due_amount',16,4)->default(0)->nullable();
            $table->float('paid_amount',16,4)->default(0)->nullble();
            $table->float('recieved_amount',16,4)->default(0)->nullable();
            $table->float('changed_amount',16,4)->default(0)->nullable();
            $table->float('last_paid_amount',16,4)->default(0)->nullable();
            $table->string('attachment_file')->nullable()->default(NULL);
            $table->string('image')->nullable()->default(NULL);
            $table->string('offer_to',512)->nullable()->default(NULL);
            $table->string('offer_subject',512)->nullable()->default(NULL);
            $table->string('offer_terms_condition',512)->nullable()->default(NULL);
            $table->tinyInteger('invoice_status')->default(0)->nullable()->comment('0=pending, 1=invoiced');
            $table->tinyInteger('shipment_status')->default(0)->nullable()->comment('0 = Pending; 1 = Shipped');
            $table->tinyInteger('status')->nullable()->default(0)->nullable()->commnet('0 = Draft; 1 = Confirmed; 2 = Closed');
            $table->tinyInteger('payment_status')->default(0)->nullable()->comment('0=unpaid, 1 =paid,2=Partial Paid');
            $table->tinyInteger('sales_type')->default(0)->nullable()->comment('1 = POS Sales; 2 = Order Sales');
            $table->unsignedBigInteger('salesperson')->nullable()->default(NULL);
            $table->unsignedBigInteger('account_id')->default(1)->index()->comment('Reference of account');
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
        Schema::dropIfExists('purchases');
    }
};
