<?php
/**
 * Created by PhpStorm.
 * User: fmbv
 * Date: 31/03/2018
 * Time: 10:55
 */
namespace App\Http\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

trait Auditoria {


    /**
     * Estableder los parametros de la auditoria
     * cuando se inserta un registro
     * @param $model    Modelo donde se va a actualizar
     */
    public function setInsertAuditoria($model){
        $model->idA = Auth::user()->id;
        $model->idU = Auth::user()->id;
        $model->dtA = date('Y-m-d H:i:s');
        $model->dtU = date('Y-m-d H:i:s');
        $model->cActivo = 'Si';
        $model->cBorrado = 'No';
    }

    /**
     * Establecer los parametros de auditoria
     * cuando se actualiza un registro
     * @param $model    Modelo donde se va a actualizar
     */
    public function setUpdateAuditoria($model){
          $model->idU = Auth::user()->id ;
          $model->dtU = date('Y-m-d H:i:s');

    }


    /**
     * Obtener los datos del usuario que ha realizado la
     * insercion o actualizadion del registro.
     * @param $tabla    Modelo donde buscar los datos
     * @return mixed    Objeto de tipo Builder
     */
    public function getAuditoria($tabla){
        return DB::raw('(select name from users where users.id = '.$tabla.'.idA) as idAnombre, '.
            '(select name from users where users.id = '.$tabla.'.idU) as idUnombre');
    }

    /**
     * Establecer el estado del registro a activo = 'Si'
     * o a desactivo = 'No'
     * @param $model    Modelo donde se va a actualizar
     * @param string $activo    'Si' o 'No'
     */
    public function setActivo($model, $activo = 'No'){
        $model->cActivo =  $activo;
    }

}
