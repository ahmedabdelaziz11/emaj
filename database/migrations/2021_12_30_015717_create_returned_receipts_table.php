<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturnedReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('returned_receipts', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date')->nullable();
            $table->decimal('total',12,2);
            $table->decimal('sub_total',12,2);
            $table->decimal('discount',9,2);
            $table->decimal('value_added',9,2);
            $table->string('Created_by', 999);
            $table->string('Status');
            $table->tinyInteger('Value_Status');
            $table->boolean('type')->default(0);
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('day_id');
            $table->unsignedBigInteger('stock_id');
            $table->unsignedInteger('receipt_id')->nullable();
            $table->foreign('client_id')->references('id')->on('all_accounts')->onDelete('cascade');
            $table->foreign('day_id')->references('id')->on('days')->onDelete('cascade');
            $table->foreign('receipt_id')->references('id')->on('receipts')->onDelete('cascade');
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
        Schema::dropIfExists('returned_receipts');
    }
}
