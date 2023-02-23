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
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->index()->default(NULL)->nullable();
            $table->string('name')->default(NULL)->nullable()->comment('name');
            $table->string('slug')->default(NULL)->nullable()->comment('slug');
            $table->string('short_link')->default(NULL)->nullable()->comment('short_url should be unique');
            $table->string('mime_type')->default(NULL)->nullable()->comment('jpg,jpeg,pdf,exel');
            $table->text('description')->default(NULL)->nullable()->comment('description');
            $table->text('meta_description')->default(NULL)->nullable()->comment('meta_description');
            $table->string('thumbanail_link')->default(NULL)->nullable()->comment('thumbanil_link');
            $table->tinyInteger('status')->default(1)->nullable()->comment('1=active, 0=deactive');
            $table->unsignedBigInteger('account_id')->default(1)->comment('Reference of account');
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
        Schema::dropIfExists('media');
    }
};
