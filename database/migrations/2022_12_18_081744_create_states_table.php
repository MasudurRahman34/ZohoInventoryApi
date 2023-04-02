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
        Schema::create('states', function (Blueprint $table) {
            $table->id();
            $table->char("country_iso2")->index();
            $table->char("country_iso3")->index();
            $table->string("state_name", 100)->index();
            $table->string("state_slug", 150)->default(null)->nullable();
            $table->enum("status", ['active', 'inactive'])->default('inactive');
            $table->integer('approved_by')->nullable()->default(null)->comment('Id of super admin who approved this state.');
            $table->dateTime('approved_at', 6)->nullable()->default(null)->comment('Date time when approved this state.');

            $table->unsignedBigInteger('account_id')->default(1)->index();
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
        Schema::dropIfExists('states');
    }
};
