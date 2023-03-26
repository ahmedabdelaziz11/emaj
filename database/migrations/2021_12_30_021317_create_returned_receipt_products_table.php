<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturnedReceiptProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('returned_receipt_products', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('receipts_id');
            $table->unsignedInteger('product_id');
            $table->integer('product_quantity');
            $table->decimal('product_Purchasing_price',10,2);
            $table->decimal('product_selling_price',10,2);
            $table->foreign('receipts_id')->references('id')->on('returned_receipts')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
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
        Schema::dropIfExists('returned_receipt_products');
    }
}
