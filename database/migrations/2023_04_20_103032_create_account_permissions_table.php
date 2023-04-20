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
        Schema::create('account_permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('permission_id')->comment('get permission name');
            $table->string('title');
            $table->text('description')->nullable()->default(NULL);
            $table->enum('status', ['active', 'inactive'])->default('inactive');
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
        Schema::dropIfExists('account_permissions');
    }
};
