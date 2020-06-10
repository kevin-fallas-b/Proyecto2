<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class User extends Model
{
    public static function actualizar($cedula, $nombre, $apellidos, $contra, $direccion, $telefono, $correo, $foto)
    {
        $nombrefoto = '';
        if ($foto != null) {
            //nos llego una foto, definir el directorio donde la vamos a guardar
            $dir =  $_SERVER['DOCUMENT_ROOT'] . '/img/users/';
            //sacar la extension del archivo
            $tipoarchivo = explode('.', $foto['name']);
            $extensionfoto = strtolower(end($tipoarchivo));
            //darle un nombre adecuado
            $nombrefoto = $_POST['cedula'] . '.' . $extensionfoto;
            $destino = $dir . $nombrefoto;
            //subirla
            move_uploaded_file($foto['tmp_name'], $destino);
        } else {
            $nombrefoto = DB::table('tbl_usuario')->where('cedula', $cedula)->first()->foto;
        }

        if (DB::table('tbl_usuario')->where('correo', $correo)->where('cedula', '<>', $cedula)->exists()) {
            return 'Correo ya se encuentra ocupado por otro usuario.';
        }
        if ($contra != null) {
            DB::table('tbl_usuario')->where('cedula', $cedula)->update(['nombre' => $nombre, 'apellido' => $apellidos, 'password' => Hash::make($contra), 'direccion' => $direccion, 'telefono' => $telefono, 'correo' => $correo, 'foto' => $nombrefoto]);
        } else {
            DB::table('tbl_usuario')->where('cedula', $cedula)->update(['nombre' => $nombre, 'apellido' => $apellidos, 'direccion' => $direccion, 'telefono' => $telefono, 'correo' => $correo, 'foto' => $nombrefoto]);
        }
        session_start();
        $_SESSION['user'] = DB::table('tbl_usuario')->where('cedula', $cedula)->first();
        return 'exito';
    }
}
