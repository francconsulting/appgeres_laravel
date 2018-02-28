<?php

namespace App\Http\Controllers\Sanitarios;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use App\Model\Sanitario;

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
        $sanitario = Sanitario::find($id);
        if(!is_null($sanitario)) {
            return "sanitario " . $sanitario;
        }else{
            return "no hay resultados";
        }
    }

    /**
     * Obtener todos los registros
     */
   /* public function getAllSanitario (){
        $sanitarios =   DB::table('sanitarios')->get();
        $num_reg = DB::table('sanitarios')->count();
        echo "numero de registros: ". $num_reg;
        foreach ($sanitarios as $sanitario) {
            echo $sanitario->sNombre;
        }
       // return view('sanitarios.lista', ['users' => $users]);
    }*/
    public function getAllSanitario (){
        $sanitarios =   Sanitario::all();

         foreach ($sanitarios as $sanitario) {
             echo $sanitario->id." - ".$sanitario->sNombre."<br/>";
         }
        echo json_encode($sanitarios);
         dd($sanitarios);

        // return view('sanitarios.lista', ['users' => $users]);
    }


    public function todos(){
        $sanitario = new Sanitario();
        $sanitario->todos();
    }

    public function nuevo(){
        $sanitario = new Sanitario();
        $sanitario->id = '4';
        $sanitario->sDni = '28495114T';
        $sanitario->sNombre = 'Franc2';
        $sanitario->sApellidos = 'br vñ';
        $sanitario->cGenero = 'H';
        $sanitario->sEmail = 'email@email.com';
        $sanitario->sTelefono1 = '666666666';
        $sanitario->sTelefono2 = '655555555';
        $sanitario->sDireccion = 'direccion';
        $sanitario->sCodigoPostal = '12521';
        $sanitario->idA = '1';
        $sanitario->idU = '1';
        $sanitario->cActivo = 'Si';
        $sanitario->cBorrado = 'No';

        $sanitario->save();
        return "registro guardado correctamente";
    }

    public function borrar($id){
        $sanitario = Sanitario::find($id);
        $sanitario->cBorrado = 'Si';
        $sanitario->save(); //actualizar el campo borrado
        $sanitario->delete(); //actualiza el timestamp de borrado

        return "registro ". $id. " borrado correctamente";
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
