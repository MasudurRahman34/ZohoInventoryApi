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
            $table->string('supplier_name', 100)->default(NULL)->nullable();
            $table->unsignedBigInteger('warehouse_id')->default(NULL)->nullable()->comment('id value warhouses table');
            $table->string('purchase_number', 50)->nullable()->default(NULL)->comment('generate from system');
            // $table->string('invoice_no', 50)->nullable()->default(NULL);
            $table->string('reference', 50)->nullable()->default(NULL);
            $table->float('total_amount', 14, 4)->default(0); //12 precision, 4 fraction
            $table->float('total_whole_amount', 14, 4)->default(0)->comment("sum of each product whole_price ");
            $table->float('total_tax', 14, 4)->default(0)->nullable();
            $table->float('total_product_discount', 14, 4)->default(0)->nullable();
            $table->float('due_amount', 14, 4)->default(0)->nullable();
            $table->float('paid_amount', 14, 4)->default(0)->nullable();
            $table->float('grand_total_amount', 14, 4)->default(0);
            $table->float('balance', 14, 4)->default(0)->nullable();
            $table->float('discount_percentage', 14, 4)->default(0)->nullable();
            $table->float('discount_amount', 14, 4)->default(0)->nullable();
            $table->float('order_tax', 14, 4)->default(0)->nullable();
            $table->float('order_tax_amount', 14, 4)->default(0)->nullable();
            $table->float('shipping_charge', 14, 4)->default(0)->nullable();
            $table->float('order_adjustment', 14, 4)->default(0)->nullable();
            $table->float('last_paid_amount', 14, 4)->default(0)->nullable();
            $table->string('adjustment_text')->nullable()->default(NULL);
            $table->dateTime('purchase_date')->nullable()->default(NULL);
            $table->dateTime('delivery_date')->nullable()->default(NULL);

            $table->text('purchase_terms')->default(NULL)->nullable();
            $table->text('purchase_description')->default(NULL)->nullable();
            $table->string('purchase_type')->default(NULL)->nullable();
            $table->string('purchase_currency')->default(NULL)->nullable();
            $table->string('pdf_link', 255)->default(NULL)->nullable();
            // $table->string('attachment_file')->nullable()->default(NULL);
            // $table->string('image')->nullable()->default(NULL);
            $table->tinyInteger('status')->nullable()->default(0);
            $table->tinyInteger('payment_status')->default(0)->comment('0=unpaid, 1 =paid,2=Partial Paid');
            $table->unsignedBigInteger('account_id')->default(1)->comment('Reference of account');
            $table->unsignedBigInteger('created_by')->default(0);
            $table->unsignedBigInteger('modified_by')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->index(['supplier_id', 'purchase_date', 'account_id']);
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
