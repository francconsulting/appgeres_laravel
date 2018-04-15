<?php

namespace App\Http\Controllers\Sanitarios;



use App\Http\Models\Sanitario;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\Fileentry;
use App\Http\Requests;

use App\Http\Traits\Auditoria;
use App\Http\Traits\UtilDb;

class SanitariosController extends Controller
{
    use Auditoria;
    use UtilDb;

    /**
     * SanitariosController constructor.
     */
    public function __construct()
    {
        $this->middleware('is_check');
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('sanitarios.list', ['modulo' => 'Sanitarios']);             //muestra la vista
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->json(array('html' => view('sanitarios.profile')->render()));     //devuelve una vista como json
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response            Objeto Json con el estado, el mensaje y codigo de estado HTML
     */
    public function store(Request $request)
    {
        $contador = Sanitario::where('sDni', $request->sDNI)->count();          //numero de registros recuperados
        if ($contador == 0) {
            $sanitario = $this->postAllSanitario();
            $ultimo_id = $this->getLastId($sanitario);                                        //recupera el id del ultimo registro insertado

            if ($request->sAvatar == 'avatar_m1.jpg' || $request->sAvatar == 'avatar_h1.jpg') {
                $avatar = $request->sAvatar;
            } else {
                $avatar = ($ultimo_id + 1) . substr($request->sAvatar, -4);
            }
            try {
                $sanitario = new Sanitario();
                $sanitario->sDni = $request->sDNI;
                $sanitario->sNombre = $request->sNombre;
                $sanitario->sApellidos = $request->sApellidos;
                $sanitario->sAvatar = $avatar;
                $sanitario->cGenero = $request->cGenero;
                $sanitario->sEmail = $request->sEmail;
                $sanitario->sTelefono1 = $request->sTelefono1;
                $sanitario->sTelefono2 = $request->sTelefono2;
                $sanitario->sDireccion = $request->sDireccion;
                $sanitario->sCodigoPostal = $request->sCodigoPostal;
                $this->setInsertAuditoria($sanitario);                  //settear los datos de auditoria de la tabla

                $sanitario->save();

                return response()->json(['accion'         => 'exito',
                                         'mensaje'        => 'Datos guardados correctamente',
                                         'last_insert_id' => $sanitario->id
                ], 200);
            } catch (\Exception $e) {
                //echo $e->getMessage();
                return response()->json(['accion'  => 'error',
                                         'mensaje' => 'Ha ocurrido un error, salga y vuelva a intentarlo'
                ], 404);
            }
        } else {
            return response()->json(['accion' => 'error',
                                     'mensaje' => 'El DNI ya existe en otro registro'
                ], 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Http\Models\Sanitario $sanitario
     * @return \Illuminate\Http\Response
     */
    public function show(Sanitario $sanitario)
    {
        //TODO no se usa porque mostramos los datos desde JS sin accesso a datos
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Http\Models\Sanitario $sanitario
     * @return \Illuminate\Http\Response
     */
    public function edit(Sanitario $sanitario)
    {
        //TODO no se usa porque mostramos los datos desde JS sin accesso a datos
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Http\Models\Sanitario $sanitario
     * @return \Illuminate\Http\Response                    Objeto Json con el estado, el mensaje y codigo de estado HTML
     */
    public function update(Request $request, $id)
    {

        $contador = Sanitario::where('sDni', $request->sDNI)->where('id', '<>', $id)->count();  //número de registros recuperados
        if ($contador == 0) {

            if ($request->sAvatar == 'avatar_m1.jpg' || $request->sAvatar == 'avatar_h1.jpg') {
                $avatar = $request->sAvatar;
            } else {
                $avatar = $id . substr($request->sAvatar, -4);
            }
            try {
                $sanitario = Sanitario::find($id);
                $sanitario->sDni = $request->sDNI;
                $sanitario->sNombre = $request->sNombre;
                $sanitario->sApellidos = $request->sApellidos;
                $sanitario->sAvatar = $avatar;
                $sanitario->cGenero = $request->cGenero;
                $sanitario->sEmail = $request->sEmail;
                $sanitario->sTelefono1 = $request->sTelefono1;
                $sanitario->sTelefono2 = $request->sTelefono2;
                $sanitario->sDireccion = $request->sDireccion;
                $sanitario->sCodigoPostal = $request->sCodigoPostal;


                $sanitario->cActivo = 'Si';
                $sanitario->cBorrado = 'No';
                $this->setUpdateAuditoria($sanitario);

                $sanitario->save();
                return response()->json(['accion' => 'exito'], 200);
            } catch (\Exception $e) {
                //echo $e->getMessage();
                return response()->json(['accion' => 'error', 'mensaje' => 'No se ha podido actualizar el registro'],
                    404);
            }
        } else {
            return response()->json(['accion' => 'error', 'mensaje' => 'El DNI ya existe en otro registro'], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Http\Models\Sanitario $sanitario
     * @return \Illuminate\Http\Response
     *
     * Se hace uso del deleteSoft. No se borra definitivamente el
     * registro, tan solo no se muestra al usuario
     */
    public function destroy($id)
    {
        try {
            $sanitario = Sanitario::find($id);
            $sanitario->cBorrado = 'Si';
            $sanitario->save();                     //actualizar el campo borrado
            $sanitario->delete();                   //actualiza el timestamp de borrado

            return response()->json(['accion' => 'exito'], 200);

        } catch (\Exception $e) {
            //echo $e->getMessage();
            return response()->json(['accion' => 'error', 'mensaje' => 'No se ha podido eliminar el registro'], 422);
        }
    }

    /********************
     * Metodos adicionales a los que crea
     * artisan con el comando make:controller.
     * Estos métodos están creados manualmente.
     *********************/

    /**
     * Obtener todos los registros activos
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function postAllSanitario()
    {
        //   $sanitarios = Sanitario::all();
        /*  $sanitarios = Sanitario::select('*',
                          DB::raw('(select name from users where users.id = '.$tabla.'.idA) as idAnombre, (select name from users where users.id = '.$tabla.'.idU) as idUnombre')
              )
                  ->get();*/

        $auditoria = $this->getAuditoria("sanitarios");              //obtener la consulta de los datos de la auditoria
        $sanitarios = Sanitario::select('*', $auditoria)->get();   //ejecutar la consulta
        return $sanitarios;
    }

    /**
     * Upload de fichero con el avatar del usuario
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse        Objeto Json con el estado, el mensaje y codigo de estado HTML
     */
    public function putAvatar(Request $request)
    {
        $nombreArchivo = $request->file('fAvatar')->getClientOriginalName();
        $extension = $request->file('fAvatar')->getClientOriginalExtension();

        try {
            if ($request->file('fAvatar') === null) {
                $file = "";
            } else {
                $file = $request->file('fAvatar')->storeAs('/images/avatar', $request->idRegistro . "." . $extension);
            }
            return response()->json(['accion' => 'exito'], 200);
        } catch (\Exception $e) {
            echo $e->getMessage();
            return response()->json(['accion' => 'error', 'mensaje' => 'No se ha podido cargar el archivo'], 422);
        }
    }

    /**
     * Borrado definitivo del registro en la tabla
     * @param $id                                   id del registro a eliminar
     * @return \Illuminate\Http\JsonResponse        Objeto Json con el estado, el mensaje y codigo de estado HTML
     */
    public function deleteHard($id)
    {
        try {
            Sanitario::withTrashed()->where('id', $id)->forceDelete();
            return response()->json(['exito' => true,
                                     'mensaje' => 'Eliminado definitivamente el registro correctamente'
            ], 200);
        } catch (\Exception $e) {
            //echo $e->getMessage();
            return response()->json(['exito'   => false,
                                     'mensaje' => 'No se ha podido eliminar definitivamente el registro'
            ], 422);
        }
    }

}
