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
                $table->integer('union_id')->index();
                $table->string('street_address_value');
                $table->string('street_address_slug')->nullable()->default(NULL);
                $table->integer("sort")->default(0);
                $table->enum("status", ['active', 'inactive'])->default('inactive');
                $table->integer('approved_by')->nullable()->default(null)->comment('Id of super admin who approved this street address.');
                $table->dateTime('approved_at', 6)->nullable()->default(null)->comment('Date time when approved this street address.');

                $table->unsignedBigInteger('account_id')->default(1)->index();
                $table->unsignedBigInteger('created_by')->default(0);
                $table->unsignedBigInteger('modified_by')->default(0);
                $table->timestamps();
                $table->softDeletes();
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
