<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('client_id')->unsigned();
            $table->string('reporter_type');
            $table->BigInteger('reporter_id')->unsigned();
            $table->string('state');
            $table->date('date');
            $table->nestedSet();
            $table->enum('ticket_type', ['invoice', 'warranty', 'other']);
            $table->string('address');
            $table->integer('received_money');
            $table->string('recommended_path');
            $table->string('closing_note');
            $table->BigInteger('invoice_product_id')->nullable()->unsigned();
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
        Schema::dropIfExists('tickets');
    }
}
