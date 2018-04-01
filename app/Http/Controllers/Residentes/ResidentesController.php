<?php

namespace App\Http\Controllers\Residentes;

Use App\Http\Models\Residente;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Traits\Auditoria;
use App\Http\Traits\UtilDb;

class ResidentesController extends Controller
{
    use Auditoria;
    use UtilDb;
    /**
     * ResidentesController constructor.
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
        return view('residentes.list', ['modulo' => 'Residentes']);     //muestra la vista
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->json(array('html' => view('residentes.profile')->render()));     //devuelve una vista como json
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $contador = Residente::where('sDni', $request->sDNI)->count();          //numero de registros recuperados
        if ($contador == 0) {
            $residente = $this->postAllResidente();

            $ultimo_id =  $this->getLastId($residente);
            //recupera el id del ultimo registro insertado

            if ($request->sAvatar == 'avatar_m1.jpg' || $request->sAvatar == 'avatar_h1.jpg') {
                $avatar = $request->sAvatar;
            } else {
                $avatar = $request->sDNI  . substr($request->sAvatar, -4);
            }
            try {
                $residente = new Residente();
                $residente->sDni = $request->sDNI;
                $residente->sNombre = $request->sNombre;
                $residente->sApellidos = $request->sApellidos;
                $residente->sAvatar = $avatar;
                $residente->cGenero = $request->cGenero;
                $residente->sNombreFamiliar = $request->sFamiliar;
                $residente->sEmail = $request->sEmail;
                $residente->sTelefono1 = $request->sTelefono1;
                $residente->sTelefono2 = $request->sTelefono2;
                $residente->sDireccion = $request->sDireccion;
                $residente->sCodigoPostal = $request->sCodigoPostal;
                $this->setInsertAuditoria($residente);                  //settear los datos de auditoria de la tabla

                $residente->save();

                return response()->json(['accion'         => 'exito',
                                         'mensaje'        => 'Datos guardados correctamente',
                                         'last_insert_id' => $residente->id
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //TODO no se usa porque mostramos los datos desde JS sin accesso a datos
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //TODO no se usa porque mostramos los datos desde JS sin accesso a datos
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $contador = Residente::where('sDni', $request->sDNI)->where('id', '<>', $id)->count();  //número de registros recuperados
        if ($contador == 0) {

            if ($request->sAvatar == 'avatar_m1.jpg' || $request->sAvatar == 'avatar_h1.jpg') {
                $avatar = $request->sAvatar;
            } else {
                $avatar = $request->sDNI . substr($request->sAvatar, -4);
            }
            try {
                $residente = Residente::find($id);
                $residente->sDni = $request->sDNI;
                $residente->sNombre = $request->sNombre;
                $residente->sApellidos = $request->sApellidos;
                $residente->sAvatar = $avatar;
                $residente->cGenero = $request->cGenero;
                $residente->sNombreFamiliar = $request->sFamiliar;
                $residente->sEmail = $request->sEmail;
                $residente->sTelefono1 = $request->sTelefono1;
                $residente->sTelefono2 = $request->sTelefono2;
                $residente->sDireccion = $request->sDireccion;
                $residente->sCodigoPostal = $request->sCodigoPostal;


                $residente->cActivo = 'Si';
                $residente->cBorrado = 'No';
                $this->setUpdateAuditoria($residente);

                $residente->save();
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     * Se hace uso del deleteSoft. No se borra definitivamente el
     * registro, tan solo no se muestra al usuario
     */
    public function destroy($id)
    {
        try {
            $residente = Residente::find($id);
            $residente->cBorrado = 'Si';
            $residente->save();                     //actualizar el campo borrado
            $residente->delete();                   //actualiza el timestamp de borrado

            return response()->json(['accion' => 'exito'], 200);

        } catch (\Exception $e) {
            //echo $e->getMessage();
            return response()->json(['accion' => 'error', 'mensaje' => 'No se ha podido eliminar el registro'], 422);
        }
    }

    /**
     * Obtener todos los registros de residentes que no esten borrados
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */

    public function postAllResidente(){
        $auditoria = $this->getAuditoria( $this->getTabla() );
        $residentes =  Residente::select('*', $auditoria)->get();
        return $residentes;
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
                $file = $request->file('fAvatar')->storeAs('/images/avatar', $request->sDNI . "." . $extension);
            }
            return response()->json(['accion' => 'exito', 'mensaje' => 'archivo cargado correctamente'], 200);
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
            Residente::withTrashed()->where('id', $id)->forceDelete();
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
