<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Auth extends Model
{
    public static function autenticar($usuario,$contra){
         return DB::table('tbl_usuario')->where('user', $usuario)->where('password',$contra)->exists();;
    }
}
