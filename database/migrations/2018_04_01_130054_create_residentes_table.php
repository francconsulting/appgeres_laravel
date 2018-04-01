<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResidentesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('residentes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sDni', 9);
            $table->string('sNombre', 45);
            $table->string('sApellidos', 90);
            $table->string('sAvatar');
            $table->char('cGenero', 1);
            $table->string('sNombreFamiliar',135);
            $table->string('sEmail');
            $table->string('sTelefono1', 12);
            $table->string('sTelefono2', 12)->nullable();
            $table->string('sDireccion')->nullable();
            $table->string('sCodigoPostal', 5)->nullable();
            $table->string('idA', 3);
            $table->string('idU', 3);
            $table->char('cActivo', 2)->default('Si');
            $table->char('cBorrado', 2)->default('No');
            $table->timestamp('dtA')->nullable();
            $table->timestamp('dtU')->nullable();
            //$table->timestamps();

            $table->index(array('sDni', 'sNombre', 'sApellidos'));

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('residentes');
    }
}
