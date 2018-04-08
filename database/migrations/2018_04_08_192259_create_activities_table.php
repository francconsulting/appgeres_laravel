<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sNombreActividad', 255);
            $table->longText('sDescripcionActividad');
            $table->timestamp('dtA')->nullable();
            $table->timestamp('dtU')->nullable();
            $table->string('idA', 3);
            $table->string('idU', 3);
            $table->char('cActivo', 2)->default('Si');
            $table->char('cBorrado', 2)->default('No');

            $table->primary('id');

            $table->index(array('sNombreActividad'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activities');
    }
}
