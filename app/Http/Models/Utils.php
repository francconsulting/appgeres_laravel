<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Utils extends Model
{
    //

    public static function current_page($pagina){
        return basename($_SERVER['PHP_SELF']) == $pagina;
    }
}
