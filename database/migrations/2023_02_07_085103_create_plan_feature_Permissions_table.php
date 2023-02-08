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
        Schema::create('plan_feature_permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('plan_id');
            $table->unsignedBigInteger('feature_id');
            $table->char('access', 50)->default('yes')->nullable()->comment('Yes, No, Limit -if Access Value Present then Limit otherwise Yes or No');
            $table->string('access_value')->default(NULL)->nullable()->comment("Limit then access value otherwise 0 or null");
            // $table->string('unique_key')->default(NULL)->nullable();
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
        Schema::dropIfExists('plan_features');
    }
};
