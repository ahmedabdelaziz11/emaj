<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsurancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insurances', function (Blueprint $table) {
            $table->id();
            $table->integer('invoice_product_id')->unsigned();
            $table->BigInteger('address_id')->nullable()->unsigned();
            $table->BigInteger('client_id')->unsigned();
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('compensation');
            $table->foreign('client_id')->references('id')->on('all_accounts')->onDelete('cascade');
            $table->foreign('invoice_product_id')->references('id')->on('invoice_products')->onDelete('cascade');
            $table->foreign('address_id')->references('id')->on('addresses')->onDelete('cascade');
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
        Schema::dropIfExists('insurances');
    }
}
