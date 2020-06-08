<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class Auth extends Model
{
    public static function autenticar($usuario, $contra)
    {
        $user = DB::table('tbl_usuario')->where('user', $usuario)->first();
        if ($user != null && Hash::check($contra, $user->password)) {
            Session::put('user',$user);
            return true;
        } else {
            return false;
        }
    }

    public static function registrar($cedula, $nombre, $apellidos, $usuario, $contra, $direccion, $tipo, $telefono, $correo)
    {
        if (DB::table('tbl_usuario')->where('cedula', $cedula)->exists()) {
            return 'Cedula ya se encuentra registrada.';
        }
        if (DB::table('tbl_usuario')->where('user', $usuario)->exists()) {
            return 'Nombre de usuario ocupado.';
        }
        if (DB::table('tbl_usuario')->where('correo', $correo)->exists()) {
            return 'Correo ya se encuentra registrado.';
        }
        DB::table('tbl_usuario')->insert(['cedula' => $cedula, 'nombre' => $nombre, 'apellido' => $apellidos, 'user' => $usuario, 'password' => Hash::make($contra), 'direccion' => $direccion, 'tipo' => $tipo, 'telefono' => $telefono, 'correo' => $correo]);
        return 'exito';
    }
}
