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
        Schema::create('business_types', function (Blueprint $table) {
            $table->id();
            $table->string('type_name');
            $table->string('category_type')->nullable()->default(NULL);
            $table->unsignedBigInteger('parent_id')->index()->default(1)->comment("defaut parent id=inserted id,otherhand selected id, recursive, used as a foreign key of other table");
            $table->tinyInteger('status')->default(1)->comment('1=active, 2=inactive');
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
        Schema::dropIfExists('business_types');
    }
};
