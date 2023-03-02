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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->morphs('paymentable');
            $table->dateTime('payment_date')->nullable()->default(now());
            $table->float('total_amount', 16, 4);
            $table->string('reference', 20)->default(null)->nullable();
            $table->tinyInteger('paid_by')->default(1)->nullable()->comment('Payment Mood; 1 = Cash; 2 = Check; 3 = Credit Card; 4 = Bank Transfer; 5 = Bank Remittance; 6 = Account Credit; 7 = Bkash');
            $table->tinyInteger('payment_method')->default(1)->nullable()->comment('1=Bank,2=Cash,3=Card,4=COD,Mobile');
            $table->string('payment_method_number')->default(NULL)->nullable()->comment('last 4 digit of transaction/account number');
            $table->tinyInteger('type')->default(1)->nullable()->comment('1 = Sent | 2 = Received');
            $table->tinyInteger('status')->default(1)->nullable()->comment('1 = Income , 2 = Expense');
            $table->tinyInteger('is_thankyou')->default(0)->nullable()->comment('Status for is thank you message will sent or not to the cusomer; 0 = No Send; 1 = Send');
            $table->text('note')->default(NULL)->nullable();
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
        Schema::dropIfExists('payments');
    }
};
