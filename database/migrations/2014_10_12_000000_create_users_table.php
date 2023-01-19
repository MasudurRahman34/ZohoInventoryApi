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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('user_number', 50)->nullable()->comment('generate');
            $table->string('first_name', 100);
            $table->string('last_name', 100)->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('user_role', 100)->default('web-user');
            $table->integer('mobile')->unique()->nullable()->default(NULL);
            $table->string('mobile_country_code',20)->nullable()->default(NULL);

            $table->date('date_of_birth')->nullable()->default(NULL);
            $table->string('gender',20)->nullable()->default(NULL);
            $table->string('image')->nullable()->default(NULL);
            $table->string('language', 100)->nullable()->default(NULL);
            $table->string('interests')->nullable()->default(NULL);
            $table->string('occupation', 50)->nullable()->default(NULL);
            $table->string('about')->nullable()->default(NULL);
            $table->integer('country')->nullable()->default(NULL);
            $table->tinyInteger('notify_new_user')->nullable()->comment('0 = New User Notification sent; 1 = New User Notification will sent');
            $table->rememberToken();
            $table->tinyInteger('status')->default(0)->comment('0 = Inactive; 1 = Active; 2 = Partially Active; 3 = On hold;');
            $table->unsignedBigInteger('created_by')->default(0);
            $table->unsignedBigInteger('modified_by')->default(0);
            $table->unsignedBigInteger('account_id')->default(1)->comment('1 = Treeoverflow | Public');
            $table->unsignedBigInteger('branch_id')->nullable();

            $table->timestamp('email_verified_at')->nullable();

            $table->timestamps();
            $table->softDeletes();
            $table->index(['user_number', 'email','account_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
