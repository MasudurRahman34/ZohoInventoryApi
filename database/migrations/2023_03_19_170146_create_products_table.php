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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->index()->default(NULL);
            $table->unsignedBigInteger("group_id")->default(0)->nullable();
            $table->unsignedBigInteger("item_category")->default(0)->nullable();
            $table->unsignedBigInteger("item_subcategory")->default(0)->nullable();
            $table->unsignedBigInteger("item_company")->default(0)->nullable();
            $table->unsignedBigInteger("brand")->default(0)->nullable();
            $table->unsignedBigInteger("model")->default(0)->nullable();
            $table->string("item_name");
            $table->string("item_slug")->default(NULL)->nullable()->comment('unique');
            $table->string("sku")->default(NULL)->nullable()->comment('Unique');
            $table->string("model_name")->default(NULL)->nullable();
            $table->string("measurment")->default(NULL)->nullable();
            $table->string("unit")->default(NULL)->nullable();
            $table->float("length")->default(0)->nullable();
            $table->float("width")->default(0)->nullable();
            $table->float("height")->default(0)->nullable();
            $table->float("weight")->default(0)->nullable();
            $table->string("weight_unit", 10)->default(NULL)->nullable();
            $table->string("manufacturer", 10)->default(NULL)->nullable();
            $table->string("universal_product_barcode", 50)->default(NULL)->nullable()->comment('unique');
            $table->string("mpn", 50)->default(NULL)->nullable()->comment('unique');
            $table->string("isbn", 50)->default(NULL)->nullable()->comment('unique');
            $table->string("ean", 50)->default(NULL)->nullable()->comment('unique');
            $table->integer('reorder_point')->default(0)->nullable();
            $table->integer('sort')->default(0)->nullable();
            $table->enum("is_serialized", [0, 1])->default(0)->nullable();
            $table->enum("is_returnable", ['Yes', 'No'])->default('Yes')->nullable();
            $table->enum("type", [0, 1])->default(1)->nullable();
            $table->unsignedBigInteger('account_id')->default(1)->comment('Reference of user account')->index();
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
        Schema::dropIfExists('products');
    }
};
