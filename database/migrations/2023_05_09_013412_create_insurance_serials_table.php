 <?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsuranceSerialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insurance_serials', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('insurance_id')->unsigned();
            $table->string('serial');
            $table->string('model_number');
            $table->foreign('insurance_id')->references('id')->on('insurances')->onDelete('cascade');
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
        Schema::dropIfExists('insurance_serials');
    }
}
