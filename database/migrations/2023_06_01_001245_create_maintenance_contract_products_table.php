<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenanceContractProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance_contract_products', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('maintenance_contract_id')->nullable()->unsigned();
            $table->foreign('maintenance_contract_id')->references('id')->on('maintenance_contracts')->onDelete('cascade');
            $table->Integer('product_id')->unsigned();
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
        Schema::dropIfExists('maintenance_contract_products');
    }
}
