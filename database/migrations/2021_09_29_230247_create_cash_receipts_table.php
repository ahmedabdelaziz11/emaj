<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_receipts', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date')->nullable();
            $table->integer('amount')->nullable();
            $table->unsignedInteger('person_id');
            $table->unsignedInteger('account_id');
            $table->unsignedInteger('account_details_id');
            $table->string('type');
            $table->longText('details')->nullable();
            $table->binary('Value_Status');
            $table->string('created_by', 999);
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->foreign('account_details_id')->references('id')->on('account_details')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cash_receipts');
    }
}
