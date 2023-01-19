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
        Schema::create('inventory_adjustments', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->index()->default(NULL);
            $table->tinyInteger('mode_of_adjustment')->default(1)->comment('1=Quantity Adjustment,2=Value/Amount adjustment');
            $table->unsignedBigInteger('inventory_adjustmentable_id')->index();
            $table->string('inventory_adjustmentable_type')->index();
            $table->string('reference_number',255)->default(NULL)->nullable();
            $table->dateTime('adjustment_date')->default(now());
            $table->unsignedBigInteger('account')->default(0)->comment('ref transaction head table')->index();
            $table->unsignedBigInteger('reason_id')->default(0)->comment('ref qunatity adjustment table')->index();
            $table->unsignedBigInteger('warehouse_id')->default(0)->comment('ref qunatity adjustment table')->index();
            $table->text('description')->default(NULL)->nullable();
    
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
        Schema::dropIfExists('inventory_adjustments');
    }
};
