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
        Schema::create('unions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("thana_id")->index();
            $table->string("union_name", 150)->index();
            $table->string("union_slug", 150)->default(NULL)->nullable();
            $table->enum("status", ['active', 'inactive'])->default('inactive');
            $table->integer('approved_by')->nullable()->default(null)->comment('Id of super admin who approved this union.');
            $table->dateTime('approved_at', 6)->nullable()->default(null)->comment('Date time when approved this union.');

            $table->integer("sort")->default(0)->nullable();
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
        Schema::dropIfExists('unions');
    }
};
