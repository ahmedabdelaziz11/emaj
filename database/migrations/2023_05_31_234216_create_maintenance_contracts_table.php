<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenanceContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance_contracts', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('address_id')->nullable()->unsigned();
            $table->BigInteger('client_id')->unsigned();
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('contract_amount',10,2);
            $table->integer('periodic_visits_count');
            $table->integer('emergency_visits_count');
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
        Schema::dropIfExists('maintenance_contracts');
    }
}
