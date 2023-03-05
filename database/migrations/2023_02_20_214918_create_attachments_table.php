<?php

use Egulias\EmailValidator\Parser\Comment;
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
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('media_id')->comment('ref media table');

            $table->morphs('attachmentable');
            $table->string('short_link', 512)->default(NUll)->nullable();
            $table->string('file_name')->default(NULL)->nullable();
            $table->string('description')->default(NULL)->nullable();
            $table->string('meta_data')->default(NULL)->nullable();
            $table->tinyInteger('status')->comment('0=public, 1=private')->default(0)->nullable();
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
        Schema::dropIfExists('attachments');
    }
};
