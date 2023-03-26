<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturnedInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('returned_invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->date('invoice_Date')->nullable();
            $table->decimal('total',12,2);
            $table->decimal('profit',12,2);
            $table->decimal('total_afterdebt',9,2);
            $table->string('employee',100);
            $table->string('Created_by', 999);
            $table->string('Status');
            $table->tinyInteger('Value_Status');
            $table->boolean('type')->default(0);
            $table->unsignedBigInteger('client_id');
            $table->unsignedInteger('account_id');
            $table->unsignedInteger('invoice_id');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
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
        Schema::dropIfExists('returned_invoices');
    }
}
