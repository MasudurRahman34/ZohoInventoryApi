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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('account_id',20)->comment('generate');
            $table->string('account_uri',100);
            $table->string('company_name');
            $table->string('slug');
            $table->string('compnay_logo')->nullable();
            $table->json('module_name')->nullable();
            $table->text('dashboard_blocks')->nullable();
            $table->string('language',25)->nullable();
            $table->string('ip_address_access')->nullable();
            $table->string('domain',100)->nullable();
            $table->string('host',100)->nullable();
            $table->string('database_name',100)->nullable();
            $table->string('database_user',100)->nullable();
            $table->string('database_password')->nullable();
            $table->unsignedBigInteger('account_super_admin')->nullable()->comment('user->id');
            $table->unsignedBigInteger('user_id')->default(1)->comment('user->id');
            $table->unsignedBigInteger('created_by')->default(0);
            $table->unsignedBigInteger('modified_by')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->index(['account_id','user_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
};
