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
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->index()->default(NULL)->nullable();
            $table->unsignedBigInteger('supplier_id')->default(NULL)->nullable();

            $table->string('supplier_name', 255)->default(NULL)->nullable();
            $table->ipAddress('user_ip', 255)->default(NULL)->nullable();
            $table->unsignedBigInteger('billing_person')->default(NULL)->nullable();
            $table->string('shipping_address', 512)->default(NULL)->nullable();
            $table->string('billing_address', 512)->default(NULL)->nullable();
            $table->string('bill_number', 255)->default(NULL)->nullable()->comment("generate from system random unique");
            $table->string('short_code', 255)->unique()->index()->default(NULL)->nullable()->comment("generate from system random unique use as guest user route");

            $table->json('order_id', 255)->default(NULL)->nullable()->comment("bill can be created from multiple purchase");
            $table->json('order_number', 255)->default(NULL)->nullable()->comment("bill can be created from multiple purchase, can input guest user");

            $table->dateTime('bill_date')->default(now())->nullable();
            $table->dateTime('due_date')->default(NULL)->nullable();

            $table->float('order_tax', 14, 4)->default(0)->nullable();
            $table->float('order_tax_amount', 14, 4)->default(0)->nullable();
            $table->float('order_discount', 14, 4)->default(0)->nullable();
            $table->float('discount_amount', 14, 4)->default(0)->nullable();
            $table->float('shipping_charge', 14, 4)->default(0)->nullable();
            $table->float('order_adjustment', 14, 4)->default(0)->nullable();

            $table->float('total_amount', 14, 4)->default(0)->comment("sum of each product subtotal");
            $table->float('total_whole_amount', 14, 4)->default(0)->comment("sum of each product whole_price ");
            $table->float('total_tax', 14, 4)->default(0)->nullable();
            $table->float('total_product_discount', 14, 4)->default(0)->nullable();
            $table->float('grand_total_amount', 14, 4)->default(0);
            $table->float('balance', 14, 4)->default(0)->nullable();
            $table->float('due_amount', 14, 4)->default(0)->nullable();
            $table->float('paid_amount', 14, 4)->default(0)->nullable();
            $table->float('change_amount', 14, 4)->default(0)->nullable();
            $table->float('last_paid', 14, 4)->default(0)->nullable();

            $table->string('adjustment_text')->default(NULL)->nullable();
            $table->text('bill_terms')->default(NULL)->nullable();
            $table->text('bill_description')->default(NULL)->nullable();
            $table->unsignedBigInteger('bill_type')->default(NULL)->nullable();
            $table->string('bill_currency')->default(NULL)->nullable();
            $table->string('payment_term', 100)->default(NULL)->nullable()->comment('calculating due date eg: 7day due date with +7 from today');
            $table->integer('download')->default(0)->nullable();
            $table->string('pdf_link', 255)->default(NULL)->nullable();

            $table->enum('status', ['draft', 'sent', 'partially_paid', 'overdue', 'paid', 'confirmed', 'cancelled'])->nullable()->default('draft')->comment('draft, sent, partially_paid, overdue, paid, confirmed, cancelled');

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
        Schema::dropIfExists('bills');
    }
};
