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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('supplier_number',50)->nullable()->comment('generate');
            $table->string('contactId',50)->nullable();
            $table->tinyInteger('supplier_type')->comment('1=individual, 2=business');
            $table->string('display_name',100);
            $table->string('company_name')->nullable();
            $table->string('website')->nullable();
            $table->integer('tax_rate')->nullable();
            $table->integer('currency')->nullable();
            $table->string('image')->nullable();
            $table->unsignedBigInteger('payment_terms')->nullable()->comment('payment_terms->id');
            $table->unsignedBigInteger('account_id')->default(1)->comment('user->account_id');
            $table->unsignedBigInteger('created_by')->default(0);
            $table->unsignedBigInteger('modified_by')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->index(['account_id','supplier_number', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('suppliers');
    }
};
