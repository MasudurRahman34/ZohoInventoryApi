<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use SebastianBergmann\Type\NullType;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('supplier_id')->comment('supplier table id')->index();
            $table->unsignedBigInteger('purchase_id')->comment('purchase table id')->index();
            $table->string('display_name')->default(NULL)->nullable();
            $table->string('company_name')->default(NULL)->nullable();
            $table->string('attension')->default(NULL)->nullable();
            $table->json('billing_address')->default(NULL)->nullable();
            $table->json('shipping_address')->default(NULL)->nullable();
            $table->unsignedBigInteger('account_id')->default(1)->index();
            $table->unsignedBigInteger('created_by')->default(0)->index();
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
        Schema::dropIfExists('purchase_addresses');
    }
};
