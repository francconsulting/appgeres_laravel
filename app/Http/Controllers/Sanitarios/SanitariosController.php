<?php

namespace App\Http\Controllers\Sanitarios;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use App\Model\Sanitario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;


class SanitariosController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('is_check');
        $this->middleware('auth');
    }

    public function index()
    {
        // $listaUsuario = DB::table('sanitarios')
        //     ->select( $this->getAllSanitario());
        //dd($rows);
        // return Datatables::of($listaUsuario)->make(true);

        $sanitarios = $this->postAllSanitario();
        return view('sanitarios.list', ['tituloModulo' => 'UsuariosXXXXx', 'sanitarios' => $sanitarios]);
    }

    /**
     * Obtener un registro
     * @param $id
     */
    public function getSanitario($id)
    {
        $sanitario = Sanitario::find($id);
        if (!is_null($sanitario)) {
            return "sanitario " . $sanitario;
        } else {
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
    public function nuevoSanitario()
    {
        return view('sanitarios.profile');
    }

    public function getAllSanitario()
    {
        $sanitarios = Sanitario::all();
        //dd(json_encode($sanitarios));
        /*   foreach ($sanitarios as $sanitario) {
               echo $sanitario->id." - ".$sanitario->sNombre."<br/>";
           }*/
        // return json_encode($sanitarios);
        return view('sanitarios.list', ['sanitarios' => $sanitarios]);


        // return view('sanitarios.list');
        //return $sanitarios;

        //  dd($sanitarios);

        // return view('sanitarios.lista', ['users' => $users]);
    }

    public function postAllSanitario()
    {
        $sanitarios = Sanitario::all();
        return $sanitarios;
    }

    /**
     * Insertar un nuevo registro
     * @param Request $request
     * @return string
     */
    public function postSanitario(Request $request)
    {
        try {
            $sanitario = new Sanitario();
            $sanitario->sDni = '28495114t';
            $sanitario->sNombre = $request->sNombre;
            $sanitario->sApellidos = $request->sApellidos;
            $sanitario->sAvatar = $request->sAvatar;
            $sanitario->cGenero = $request->cGenero;
            $sanitario->sEmail = $request->sEmail;
            $sanitario->sTelefono1 = $request->sTelefono1;
            $sanitario->sTelefono2 = $request->sTelefono2;
            $sanitario->sDireccion = $request->sDireccion;
            $sanitario->sCodigoPostal = $request->sCodigoPostal;
            $sanitario->idA = Auth::user()->id;
            $sanitario->idU = Auth::user()->id;
            $sanitario->cActivo = 'Si';
            $sanitario->cBorrado = 'No';

            $sanitario->save();

            return response()->json(['exito' => true], 200);
        } catch (\Exception $e) {
            //echo $e->getMessage();
            return response()->json(['exito' => false], 404);
        }

    }

    /**
     * Borrar un nuevo, con el método SoftDelete
     * @param $id
     * @return string
     */
    public function deleteSoft($id)
    {
        try {
            $sanitario = Sanitario::find($id);
            $sanitario->cBorrado = 'Si';
            $sanitario->save(); //actualizar el campo borrado
            $sanitario->delete(); //actualiza el timestamp de borrado

            return response()->json(['exito' => true], 200);
        } catch (\Exception $e) {
            //echo $e->getMessage();
            return response()->json(['exito' => false], 404);
        }
    }


    public function deleteHard($id)
    {
        try {
            Sanitario::withTrashed()->where('id', $id)->forceDelete();
            return response()->json(['exito' => true], 200);
        } catch (\Exception $e) {
            //echo $e->getMessage();
            return response()->json(['exito' => false], 404);
        }


    }

    public function deleteAllHard()
    {
        $sanitarios = Sanitario::withTrashed()->whereNotNull('deleted_at');
        $sanitarios->each(function ($item) {
            $item->forceDelete();
        });
        return redirect('/sanitarios');
    }

    /**
     * Actualizar un registro
     * @param $id
     */
    public function putSanitario($id, Request $request)
    {
        $sanitario = Sanitario::find($id);
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
    public function putDelSanitario($id)
    {

    }

    /**
     * Eliminar por completo el registro
     * @param $id
     */
    public function putDelete($id)
    {

    }
}
