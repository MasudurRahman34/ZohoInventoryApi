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
            $table->enum('paid_by', ['cash', 'check', 'credit_card', 'bank_transfer', 'bkash', 'bank_remitance', 'account_credit', 'nagad', 'surecash', 'rocket', 'cod'])->default('cash')->nullable()->comment('cash, check, credit_card , bank_transfer,bank_remittance, account_credit, bkash', 'nagad', 'surecash', 'rocket');
            $table->enum('payment_method', ['bank', 'cash', 'card', 'cod', 'mobile'])->default('cash')->nullable()->comment('bank,cash,card,cod, mobile');
            $table->string('payment_method_number')->default(NULL)->nullable()->comment('last 4 digit of transaction/account number');
            $table->enum('type', ['sent', 'recieved'])->default('sent')->nullable()->comment('sent,received');
            $table->enum('status', ['income', 'expense'])->comment('income,expense');
            $table->enum('is_thankyou', ['sent', 'pending'])->default('pending')->nullable()->comment('Status for is thank you message will sent or not to the cusomer');
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
