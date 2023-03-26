<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSinvoiceProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sinvoice_products', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('invoice_id');
            $table->unsignedInteger('product_id');
            $table->integer('product_quantity');
            $table->decimal('product_Purchasing_price',10,2);
            $table->decimal('product_selling_price',10,2);
            $table->foreign('invoice_id')->references('id')->on('spare_invoices')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('spares')->onDelete('cascade');
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
        Schema::dropIfExists('sinvoice_products');
    }
}
