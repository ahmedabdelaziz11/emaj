<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpareReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spare_receipts', function (Blueprint $table) {
            $table->increments('id');
            $table->date('receipt_date')->nullable();
            $table->decimal('total',19,2);
            $table->decimal('amount_paid',19,2);
            $table->unsignedBigInteger('supplier_id');
            $table->unsignedInteger('account_id');
            $table->string('Status');
            $table->tinyInteger('Value_Status');
            $table->boolean('type')->default(0);
            $table->boolean('value_added')->default(0);
            $table->string('Created_by', 999);
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
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
        Schema::dropIfExists('spare_receipts');
    }
}
