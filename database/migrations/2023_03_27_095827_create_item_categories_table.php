<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use SebastianBergmann\Type\NullType;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('slug', 100)->default(NULL)->nullable();
            $table->unsignedTinyInteger('parent_id')->default(0)->nullable();
            $table->text('description')->nullable()->default(NULL);
            $table->unsignedTinyInteger('sort')->default(0);
            $table->enum('default', ['yes', 'no'])->default('no');
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
        Schema::dropIfExists('item_categories');
    }
};
