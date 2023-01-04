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
        if (!Schema::hasTable('street_addresses')) {
            Schema::create('street_addresses', function (Blueprint $table) {
                $table->id();
                $table->integer('union_id');
                $table->string('street_address_value');
                $table->string('street_address_slug')->nullable();

                $table->tinyInteger('status')->default(1);
                $table->integer("sort")->default(0);
                $table->unsignedBigInteger('account_id')->default(1);
                $table->unsignedBigInteger('created_by')->default(0);
                $table->unsignedBigInteger('modified_by')->default(0);
                $table->timestamps();
                $table->softDeletes();
                $table->index(['union_id', 'account_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('street_addresses');
    }
};
