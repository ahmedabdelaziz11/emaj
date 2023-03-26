<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSparesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spares', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('name_en')->nullable();
            $table->longText('description');
            $table->longText('description_en')->nullable();
            $table->decimal('Purchasing_price',10,2);
            $table->decimal('selling_price',10,2);
            $table->integer('quantity');
            $table->unsignedBigInteger('section_id');
            $table->foreign('section_id')->references('id')->on('spare_sections')->onDelete('cascade');
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
        Schema::dropIfExists('spares');
    }
}
