<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableTicketProductsAddDetailsColum extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ticket_products', function (Blueprint $table) {
            $table->string('details')->after('estimated_time')->nullable();
            $table->string('product_id')->nullable()->change();
            $table->integer('quantity')->nullable()->change();
            $table->integer('price')->nullable()->change();
            $table->string('estimated_time')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ticket_products', function (Blueprint $table) {
            //
        });
    }
}
