<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class User extends Model
{
    public static function actualizarusuario($cedula, $nombre, $apellidos, $contra, $direccion, $telefono, $correo, $foto)
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

    public static function creartitulo($cedula, $titulo, $institucion, $especialidad, $mes, $ano)
    {
        DB::table('tbl_titulo')->insert(['cedula' => $cedula, 'titulo' => $titulo, 'especialidad' => $especialidad, 'institucion' => $institucion, 'mes' => $mes, 'ano' => $ano]);
        session_start();
        $_SESSION['titulosuser'] = DB::table('tbl_titulo')->where('cedula',$cedula)->get();
        return 'exito';
    }

    public static function actualizartitulo($id,$cedula, $titulo, $institucion, $especialidad, $mes, $ano)
    {
        DB::table('tbl_titulo')->where('id',$id)->update([ 'titulo' => $titulo, 'especialidad' => $especialidad, 'institucion' => $institucion, 'mes' => $mes, 'ano' => $ano]);
        session_start();
        $_SESSION['titulosuser'] = DB::table('tbl_titulo')->where('cedula',$cedula)->get();
        return 'exito';
    }

    public static function crearexperiencia($cedula, $empresa, $puesto, $responsabilidades, $fechaingreso, $fechasalida)
    {
        if($fechasalida==''){
            $fechasalida=null;
        }
        DB::table('tbl_experiencia')->insert(['cedula' => $cedula, 'empresa' => $empresa, 'puesto' => $puesto, 'desc_responsa' => $responsabilidades, 'fecha_ini' => $fechaingreso, 'fecha_fin' => $fechasalida]);
        session_start();
        $_SESSION['experienciasuser'] = DB::table('tbl_experiencia')->where('cedula',$cedula)->get();
        return 'exito';
    }
    public static function actualizarexperiencia($id,$cedula, $empresa, $puesto, $responsabilidades, $fechaingreso, $fechasalida)
    {
        if($fechasalida==''){
            $fechasalida=null;
        }
        DB::table('tbl_experiencia')->where('id',$id)->update(['empresa' => $empresa, 'puesto' => $puesto, 'desc_responsa' => $responsabilidades, 'fecha_ini' => $fechaingreso, 'fecha_fin' => $fechasalida]);
        session_start();
        $_SESSION['experienciasuser'] = DB::table('tbl_experiencia')->where('cedula',$cedula)->get();
        return 'exito';
    }

    public static function crearobservacion($cedula, $merito){
        DB::table('tbl_meritos')->insert(['cedula' =>$cedula, 'descripcion' =>$merito]);
        session_start();
        $_SESSION['meritosuser'] = DB::table('tbl_meritos')->where('cedula',$cedula)->get();
        return 'exito';
    }
    
    public static function editarobservacion($id,$cedula,$merito){
        DB::table('tbl_meritos')->where('id', $id)->update(['descripcion' => $merito]);
        session_start();
        $_SESSION['meritosuser'] = DB::table('tbl_meritos')->where('cedula',$cedula)->get();
        return 'exito';
    }


    public static function eliminartitulo($cedula,$id){
        DB::table('tbl_titulo')->where('id',$id)->delete();
        session_start();
        $_SESSION['titulosuser'] = DB::table('tbl_titulo')->where('cedula',$cedula)->get();
        return 'exito';
    }

    public static function eliminarobservacion($cedula,$id){
        DB::table('tbl_meritos')->where('id',$id)->delete();
        session_start();
        $_SESSION['meritosuser'] = DB::table('tbl_meritos')->where('cedula',$cedula)->get();
        return 'exito';
    }

    public static function eliminarexperiencia($cedula,$id){
        DB::table('tbl_experiencia')->where('id',$id)->delete();
        session_start();
        $_SESSION['experienciasuser'] = DB::table('tbl_experiencia')->where('cedula',$cedula)->get();
        return 'exito';
    }
}
