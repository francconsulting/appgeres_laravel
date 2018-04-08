<?php

namespace App\Http\Controllers\Actividades;

Use App\Http\Models\Actividad;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Traits\Auditoria;
use App\Http\Traits\UtilDb;

class ActividadesController extends Controller
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
        return view('actividades.list', ['modulo' => 'Actividades']);     //muestra la vista
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->json(array('html' => view('actividades.profile')->render()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $contador = Actividad::where('sNombreActividad', $request->sNombreActividad)->count();          //numero de registros recuperados
        if ($contador == 0) {
            $actividad = $this->postAllActividad();

            $ultimo_id =  $this->getLastId($actividad);
            //recupera el id del ultimo registro insertado

            try {
                $actividad = new Actividad();
                $actividad->sNombreActividad = $request->sNombreActividad;
                $actividad->sDescripcionActividad = $request->sDescripcionActividad;
                $actividad->sTipoActividad = $request->sAuxTipoActividad;
                $this->setInsertAuditoria($actividad);                  //settear los datos de auditoria de la tabla

                $actividad->save();

                return response()->json(['accion'         => 'exito',
                                         'mensaje'        => 'Datos guardados correctamente',
                                         'last_insert_id' => $actividad->id
                ], 200);
            } catch (\Exception $e) {
                //echo $e->getMessage();
                return response()->json(['accion'  => 'error',
                                         'mensaje' => 'Ha ocurrido un error, salga y vuelva a intentarlo'
                ], 404);
            }
        } else {
            return response()->json(['accion' => 'error',
                                     'mensaje' => 'La Actividad ya existe en otro registro'
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

        $contador = Actividad::where('sNombreActividad', $request->sNombreActividad)->where('id', '<>', $id)->count();  //número de registros recuperados;
        if ($contador == 0) {
            try {
                $actividad = Actividad::find($id);

                $actividad->sNombreActividad = $request->sNombreActividad;
                $actividad->sDescripcionActividad = $request->sDescripcionActividad;
                $actividad->sTipoActividad = $request->sAuxTipoActividad;

                $actividad->cActivo = 'Si';
                $actividad->cBorrado = 'No';
                $this->setUpdateAuditoria($actividad);

                $actividad->save();
                return response()->json(['accion' => 'exito'], 200);
            } catch (\Exception $e) {
                //echo $e->getMessage();
                return response()->json(['accion' => 'error', 'mensaje' => 'No se ha podido actualizar el registro'],
                    404);
            }
        } else {
            return response()->json(['accion' => 'error', 'mensaje' => 'La Actividad ya existe en otro registro'], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $actividad = Actividad::find($id);
            $actividad->cBorrado = 'Si';
            $actividad->save();                     //actualizar el campo borrado
            $actividad->delete();                   //actualiza el timestamp de borrado

            return response()->json(['accion' => 'exito'], 200);

        } catch (\Exception $e) {
            //echo $e->getMessage();
            return response()->json(['accion' => 'error', 'mensaje' => 'No se ha podido eliminar el registro'], 422);
        }
    }

    /**
     * Obtener todos los registros de actividades que no esten borrados
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */

    public function postAllActividad(){
        $auditoria = $this->getAuditoria( $this->getTabla('actividades') );
        $residentes =  Actividad::select('*', $auditoria)->get();
        return $residentes;
    }


}
