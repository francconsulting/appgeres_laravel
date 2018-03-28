<?php

namespace App\Http\Controllers\Sanitarios;

use App\Http\Models\Sanitario;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use App\Fileentry;
use App\Http\Requests;

class SanitariosController extends Controller
{
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
        return view('sanitarios.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->json(array('html' =>view('sanitarios.profile')->render()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
     * Display the specified resource.
     *
     * @param  \App\Http\Models\Sanitario  $sanitario
     * @return \Illuminate\Http\Response
     */
    public function show(Sanitario $sanitario)
    {
        //TODO no se usa porque mostramos los datos desde JS sin accesso a datos
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Http\Models\Sanitario  $sanitario
     * @return \Illuminate\Http\Response
     */
    public function edit(Sanitario $sanitario)
    {
        //TODO no se usa porque mostramos los datos desde JS sin accesso a datos
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Http\Models\Sanitario  $sanitario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Http\Models\Sanitario  $sanitario
     * @return \Illuminate\Http\Response
     *
     * Se hace uso del deleteSoft
     */
    public function destroy($id)
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

    /**
     * Obtener todos los registros activos
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function postAllSanitario()
    {
        $sanitarios = Sanitario::all();
        return $sanitarios;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postAvatar(Request $request){
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
            return response()->json(['exito' => false], 422);
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

}
