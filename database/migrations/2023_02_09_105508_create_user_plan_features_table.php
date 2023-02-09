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
        Schema::create('user_plan_features', function (Blueprint $table) {
            $table->id();
            $table->json('account_id')->comment('can be multiple account');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('plan_feature_id');
            // $table->string('setting_key')->default(NULL);
            // $table->char('access,50')->default(NULL)->nullable();
            // $table->string('access_value')->nullable()->default(NULL);
            $table->json('settings')->nullable()->default(null)->comment('user_id : {account: [{id:,plan_id:,permissions:{setting_key:access_value}}}]');
            $table->tinyInteger('status')->nullable()->default(1)->comment('0=active,1=inactive');
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
        Schema::dropIfExists('account_plan_features');
    }
};
