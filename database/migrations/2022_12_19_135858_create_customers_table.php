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
        if (!Schema::hasTable('portal_customers')) {
            Schema::create('portal_customers', function (Blueprint $table) {
                $table->id();
                $table->string('customer_number', 50)->comment('Required, System automatically generate a unique customer number, editable');
                $table->tinyInteger('customer_type')->length(1)->comment('1=individual, 2=business')->default(1);
                $table->string('display_name', 100)->comment('Required, Alfa numeric');
                $table->string('company_name')->nullable()->comment('Alfa nuemeric');
                $table->string('website')->nullable()->default(NULL);
                $table->integer('tax_name')->nullable()->default(NULL);
                $table->float('tax_rate')->nullable()->default(0);
                $table->integer('currency')->nullable()->default(0);
                $table->string('image')->nullable()->default(NULL);
                $table->integer('payment_terms')->nullable()->default(NULL)->comment('Reference of Net payment terms');
                $table->tinyInteger('copy_bill_address')->length(1)->comment('0 = Not copy, 1 = copy to ship address');

                $table->integer('account_id')->default(1)->comment('Reference of account');
                $table->integer('created_by')->default(0);
                $table->integer('modified_by')->default(0);
                $table->timestamps();
                $table->softDeletes();
                $table->index(['account_id', 'customer_number', 'created_at']);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('portal_customers');
    }
};
