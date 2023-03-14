<?php

use App\Enums\V1\TransactionHeadEnum;
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
        Schema::create('transaction_heads', function (Blueprint $table) {
            $table->id();
            $table->string('head_name')->comment('name of the trasactions');
            $table->enum('type', [1, 2])->comment('1=debit, 2=credit');
            $table->tinyInteger('sort')->default(0)->nullable();
            $table->text('description')->default(NULL)->nullable();
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
        Schema::dropIfExists('transaction_heads');
    }
};
