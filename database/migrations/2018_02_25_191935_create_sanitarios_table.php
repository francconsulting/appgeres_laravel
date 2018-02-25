<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSanitariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sanitarios', function (Blueprint $table) {
                $table->increments('id');
                $table->string('sDni', 9);
                $table->string('sNombre', 45);
                $table->string('sApellidos',90);
                $table->string('sPassword',25);
                $table->enum('aRol',['ADM', 'PER', 'SUP']);
                $table->char('cGenero',1);
                $table->string('sEmail');
                $table->string('sTelefono1',12);
                $table->string('sTelefono2',12)->nullable();
                $table->string('sDireccion')->nullable();
                $table->string('sCodigoPostal',5)->nullable();
                $table->timestamp('dtA')->nullable();
                $table->timestamp('dtU')->nullable();
                $table->string('idA',3);
                $table->string('idU',3);
                $table->char('cActivo',2)->default('Si');
                $table->char('cBorrado',2)->default('No');
                $table->timestamps();

                $table->primary('id');
                $table->index(array('sDni', 'sNombre', 'sApellidos'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sanitarios');
    }
}
