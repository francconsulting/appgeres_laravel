<?php

namespace App\Http\Controllers\Sanitarios;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SanitariosController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getPrueba(){
        return "pruebasss";
    }

    /**
     * Obtener un registro
     * @param $id
     */
    public function getSanitario($id){
        return "sanitario ".$id;
    }

    /**
     * Obtener todos los registros
     */
    public function getAllSanitario (){

    }

    /**
     * Insertar un nuevo registro
     */
    public function postSanitario(){

    }

    /**
     * Actualizar un registro
     * @param $id
     */
    public function putSanitario($id){

    }

    /**
     * Actualizar el campo borrado del registro
     * poniendo a borrado True
     * @param $id
     */
    public function putDelSanitario($id){

    }

    /**
     * Eliminar por completo el registro
     * @param $id
     */
    public function putDelete($id){

    }
}
