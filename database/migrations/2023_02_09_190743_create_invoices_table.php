<?php

use Carbon\Carbon;
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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->index()->default(NULL);
            $table->unsignedBigInteger('customer_id')->default(NULL)->nullable();

            $table->string('customer_name', 255)->default(NULL)->nullable();
            $table->unsignedBigInteger('salesperson')->default(NULL)->nullable();
            $table->string('shipping_address', 512)->default(NULL)->nullable();
            $table->string('billing_address', 512)->default(NULL)->nullable();
            $table->string('invoice_number', 255)->default(NULL)->nullable()->comment("generate from system serialized");
            $table->string('short_code', 255)->unique()->index()->default(NULL)->nullable()->comment("generate from system random unique use as guest user route");

            $table->json('order_id', 255)->default(NULL)->nullable()->comment("invoice can be created from multiple order");
            $table->json('order_number', 255)->default(NULL)->nullable()->comment("invoice can be created from multiple order, can input guest user");

            $table->dateTime('invoice_date')->default(now())->nullable();
            $table->dateTime('due_date')->default(NULL)->nullable();

            $table->float('order_tax')->default(0)->nullable();
            $table->float('order_tax_amount')->default(0)->nullable();
            $table->float('order_discount')->default(0)->nullable();
            $table->float('discount_type')->default(0)->nullable();
            $table->float('shipping_charge')->default(0)->nullable();
            $table->float('order_adjustment')->default(0)->nullable();

            $table->float('total_amount')->default(0);
            $table->float('total_tax')->default(0);
            $table->float('grand_total_amount')->default(0);
            $table->float('due_amount')->default(0)->nullable();
            $table->float('paid_amount')->default(0)->nullable();
            $table->float('change_amount')->default(0)->nullable();
            $table->float('last_paid')->default(0)->nullable();

            $table->string('adjustment_text')->default(NULL)->nullable();
            $table->string('invoice_terms')->default(NULL)->nullable();
            $table->string('invoice_type')->default(NULL)->nullable();
            $table->string('invoice_currency')->default(NULL)->nullable();


            $table->tinyInteger('status')->nullable()->default(1)->comment('0 = Draft, 1 = Sent, 2 = Partially Paid, 3 = Overdue, 4 = Paid, 5 = Confirmed, 6 = Cancelled');
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
        Schema::dropIfExists('invoices');
    }
};
