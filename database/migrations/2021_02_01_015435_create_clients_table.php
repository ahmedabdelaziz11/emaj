<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('client_name',999);
            $table->string('client_name_en',999)->nullable();
            $table->string('email')->unique();
            $table->string('sgel');
            $table->string('dreba');
            $table->string('address');
            $table->string('address_en')->nullable();
            $table->string('phone');
            $table->string('Commercial_Register');
            $table->string('Commercial_Register_en')->nullable();
            $table->decimal('debt',10,2);
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
        Schema::dropIfExists('clients');
    }
}
