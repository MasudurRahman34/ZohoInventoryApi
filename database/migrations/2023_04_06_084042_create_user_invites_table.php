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
        Schema::create('user_invites', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name')->default(NULL)->nullable();
            $table->string('role');
            $table->string('email')->unique()->index('email');
            $table->string('token')->unique();
            $table->timestamp('registared_at')->nullable();
            $table->enum('status', ['pending', 'accepted'])->default('pending')->nullable();
            $table->unsignedBigInteger('account_id')->default(1)->comment('Reference of account table.');
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
        Schema::dropIfExists('user_invites');
    }
};
