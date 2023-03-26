<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->date('invoice_Date')->nullable();
            $table->decimal('profit',19,2);
            $table->decimal('total',19,2);
            $table->decimal('amount_paid',19,2);
            $table->decimal('discount', 5,2);
            $table->unsignedInteger('account_id');
            $table->unsignedInteger('offer_id');
            $table->string('Status');
            $table->tinyInteger('Value_Status');
            $table->boolean('type')->default(0);
            $table->boolean('value_added')->default(0);
            $table->string('employee',100);
            $table->string('Created_by', 999);
            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
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
        Schema::dropIfExists('invoices');
    }
}
