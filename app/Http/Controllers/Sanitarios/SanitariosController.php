<?php

namespace App\Http\Controllers\Sanitarios;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use App\Model\Sanitario;
use Illuminate\Support\Facades\Redirect;

class SanitariosController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
       // $listaUsuario = DB::table('sanitarios')
       //     ->select( $this->getAllSanitario());
        //dd($rows);
       // return Datatables::of($listaUsuario)->make(true);

       /* dd($rows);
        $sanitarios = $this->getAllSanitario();
        return view('sanitarios.list', ['tituloModulo' => 'UsuariosXXXXx', 'aSanitarios' => $sanitarios]);*/
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

      /*   foreach ($sanitarios as $sanitario) {
             echo $sanitario->id." - ".$sanitario->sNombre."<br/>";
         }*/
       // return json_encode($sanitarios);
        return $sanitarios;
       //  dd($sanitarios);

        // return view('sanitarios.lista', ['users' => $users]);
    }


    /**
     * Insertar un nuevo registro
     * @param Request $request
     * @return string
     */
    public function postSanitario(Request $request){
        $sanitario = new Sanitario();
        $sanitario->sDni = '28495114t';
        $sanitario->sNombre = 'Franc2';
        $sanitario->sApellidos = 'br vñ';
        $sanitario->cGenero = 'H';
        $sanitario->sEmail = 'email@email.com';
        $sanitario->sTelefono1 = '666666666';
        $sanitario->sTelefono2 = '655555555';
        $sanitario->sDireccion = 'direccion';
        $sanitario->sCodigoPostal = '12521';
        $sanitario->idA = Auth::user()->id;
        $sanitario->idU = Auth::user()->id;
        $sanitario->cActivo = 'Si';
        $sanitario->cBorrado = 'No';

        $sanitario->save();
        return "registro guardado correctamente";
    }

    /**
     * Borrar un nuevo, con el método SoftDelete
     * @param $id
     * @return string
     */
    public function deleteSoft($id){
        $sanitario = Sanitario::find($id);
        $sanitario->cBorrado = 'Si';
        $sanitario->save(); //actualizar el campo borrado
        $sanitario->delete(); //actualiza el timestamp de borrado

        echo  "registro ". $id. " borrado correctamente";
        return redirect('/sanitarios');
    }


    public function deleteHard($id){
        Sanitario::withTrashed()->where('id', $id)->forceDelete();
        echo "registros  borrado correctamente";

        return redirect('/sanitarios');


    }

    public function deleteAllHard(){
        $sanitarios = Sanitario::withTrashed()->whereNotNull('deleted_at');
        $sanitarios->each( function ($item){
           $item->forceDelete();
        });
        return redirect('/sanitarios');
    }

    /**
     * Actualizar un registro
     * @param $id
     */
    public function putSanitario($id, Request $request){
        $sanitario =  Sanitario::find($id);
        $sanitario->sDni = $request->sDni;
        $sanitario->sNombre = 'Franc2';
        $sanitario->sApellidos = 'br vñ';
        $sanitario->cGenero = 'H';
        $sanitario->sEmail = 'email@email.com';
        $sanitario->sTelefono1 = '666666666';
        $sanitario->sTelefono2 = '655555555';
        $sanitario->sDireccion = 'direccion';
        $sanitario->sCodigoPostal = '12521';
        $sanitario->idU = Auth::user()->id;
        $sanitario->cActivo = 'Si';
        $sanitario->cBorrado = 'No';

        $sanitario->save();
        return "registro actualizado";
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
