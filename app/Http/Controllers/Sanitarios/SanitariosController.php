<?php

namespace App\Http\Controllers\Sanitarios;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use App\Http\Models\Sanitario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

use App\Fileentry;
use App\Http\Requests;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;

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
        //return view('sanitarios.profile');
        return response()->json(array('html' =>view('sanitarios.profile')->render()));
    }

    public function getAllSanitario()
    {

        return view('sanitarios.list');
        //$sanitarios = Sanitario::all();
        //return view('sanitarios.list', ['sanitarios' => $sanitarios]);

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
        $sanitario = $this->postAllSanitario();
        $ultimo_id =$sanitario->last()->id;

        if ($request->sAvatar == 'avatar_m1.svg' || $request->sAvatar == 'avatar_h1.svg'){
            $avatar = $request->sAvatar;
        }else{
            $avatar = ($ultimo_id + 1).substr($request->sAvatar,-4);
         }
        try {
            $sanitario = new Sanitario();
            $sanitario->sDni = '28495114t';
            $sanitario->sNombre = $request->sNombre;
            $sanitario->sApellidos = $request->sApellidos;
            $sanitario->sAvatar = $avatar;
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

            return response()->json(['exito' => true, 'last_insert_id' => $sanitario->id], 200);
        } catch (\Exception $e) {
            //echo $e->getMessage();
            return response()->json(['exitos' => false], 404);
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
try{
        $sanitario = Sanitario::find($id);
        $sanitario->sDni = '28495114t';
        $sanitario->sNombre = $request->sNombre;
        $sanitario->sApellidos = $request->sApellidos;
        $sanitario->sAvatar = $request->id.substr($request->sAvatar, -4);
        $sanitario->cGenero = $request->cGenero;
        $sanitario->sEmail = $request->sEmail;
        $sanitario->sTelefono1 = $request->sTelefono1;
        $sanitario->sTelefono2 = $request->sTelefono2;
        $sanitario->sDireccion = $request->sDireccion;
        $sanitario->sCodigoPostal = $request->sCodigoPostal;
        $sanitario->idU = Auth::user()->id;
        $sanitario->dtU = date('Y-m-d H:i:s');
        $sanitario->cActivo = 'Si';
        $sanitario->cBorrado = 'No';


        $sanitario->save();
        return response()->json(['exito' => true], 200);
    } catch (\Exception $e) {
    echo $e->getMessage();
return response()->json(['exito' => false], 404);
}
    }

    public function putAvatar(Request $request){
        //dd($request->allFiles());

        $nombreArchivo = $request->file('fAvatar')->getClientOriginalName();
        $extension =  $request->file('fAvatar')->getClientOriginalExtension();
        try {
            if ($request->file('fAvatar') === null) {
                $file = "";
            } else {
                $file = $request->file('fAvatar')->storeAs('/images/avatar', $request->idRegistro.".".$extension);
            }
            return response()->json(['exito' => true], 200);
        }catch(\Exception $e){
            echo $e->getMessage();
            return response()->json(['exito' => false], 404);
        }
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
