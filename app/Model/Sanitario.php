<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sanitario extends Model
{
    use SoftDeletes;    //activar el borrado logico

    const CREATED_AT =  'dtA';
    const UPDATED_AT =  'dtU';


    protected $table = 'sanitarios';  //tabla asociada al modelo
    protected $guarded = 'id';          //proteger que no se pueda setear la porpiedad id con algún valor
    protected $dates = ['deleted_at']; //campo para el borrado logico


    public function  todos(){
        $todos = $this->all();
        var_dump($todos[0]);
        var_dump($this);
    }
}
