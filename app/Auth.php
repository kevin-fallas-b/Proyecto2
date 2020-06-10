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
            //usuario autenticado
            session_start();
            $_SESSION['user'] = $user;
            //si es cuenta personal, buscar titulos y experiencias, si es empresa, buscar categorias y ofertas
            if ($user->tipo == 1) {
                $titulos = DB::table('tbl_titulo')->where('cedula', $user->cedula)->get();
                $experiencias = DB::table('tbl_experiencia')->where('cedula', $user->cedula)->get();
                $_SESSION['titulosuser'] = $titulos;
                $_SESSION['experienciasuser'] = $experiencias;
            }else{
                $categorias = DB::table('tbl_categoria')->where('cedula', $user->cedula)->get();
                $ofertas = DB::table('tbl_oferta')->where('cedula', $user->cedula)->get();
                $_SESSION['categoriasuser'] = $categorias;
                $_SESSION['ofertasuser'] = $ofertas;
            }

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
