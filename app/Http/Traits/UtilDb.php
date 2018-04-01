<?php
/**
 * Created by PhpStorm.
 * User: fmbv
 * Date: 01/04/2018
 * Time: 21:49
 */


namespace App\Http\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

trait UtilDb {

    /**
     * obtiene el id del últmo registro insertado
     * @param $obj  Colleccion de objetos donde buscar el ultimo id
     * @return int
     */
    public function  getLastId($obj){
        $ultimo_id =  ( sizeof($obj)>0 ) ? $obj->last()->id : 1;
        return $ultimo_id;
    }


    public function getModelo(){
        $finalString = (strpos(\Request::path(),"/")>1) ? strpos(\Request::path(),"/") : strlen(\Request::path());
        return ucfirst(substr(\Request::path(), 0, $finalString));
    }

    public function getTabla($tabla = null){
       $tabla = empty($tabla) ? $this->getModelo()."s" : $tabla;
        return $tabla;
    }

}