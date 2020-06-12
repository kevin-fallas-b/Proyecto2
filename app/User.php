<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Collection;


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
        $_SESSION['titulosuser'] = DB::table('tbl_titulo')->where('cedula', $cedula)->get();
        return 'exito';
    }

    public static function actualizartitulo($id, $cedula, $titulo, $institucion, $especialidad, $mes, $ano)
    {
        DB::table('tbl_titulo')->where('id', $id)->update(['titulo' => $titulo, 'especialidad' => $especialidad, 'institucion' => $institucion, 'mes' => $mes, 'ano' => $ano]);
        session_start();
        $_SESSION['titulosuser'] = DB::table('tbl_titulo')->where('cedula', $cedula)->get();
        return 'exito';
    }

    public static function crearexperiencia($cedula, $empresa, $puesto, $responsabilidades, $fechaingreso, $fechasalida)
    {
        if ($fechasalida == '') {
            $fechasalida = null;
        }
        DB::table('tbl_experiencia')->insert(['cedula' => $cedula, 'empresa' => $empresa, 'puesto' => $puesto, 'desc_responsa' => $responsabilidades, 'fecha_ini' => $fechaingreso, 'fecha_fin' => $fechasalida]);
        session_start();
        $_SESSION['experienciasuser'] = DB::table('tbl_experiencia')->where('cedula', $cedula)->get();
        return 'exito';
    }
    public static function actualizarexperiencia($id, $cedula, $empresa, $puesto, $responsabilidades, $fechaingreso, $fechasalida)
    {
        if ($fechasalida == '') {
            $fechasalida = null;
        }
        DB::table('tbl_experiencia')->where('id', $id)->update(['empresa' => $empresa, 'puesto' => $puesto, 'desc_responsa' => $responsabilidades, 'fecha_ini' => $fechaingreso, 'fecha_fin' => $fechasalida]);
        session_start();
        $_SESSION['experienciasuser'] = DB::table('tbl_experiencia')->where('cedula', $cedula)->get();
        return 'exito';
    }

    public static function crearobservacion($cedula, $merito)
    {
        DB::table('tbl_meritos')->insert(['cedula' => $cedula, 'descripcion' => $merito]);
        session_start();
        $_SESSION['meritosuser'] = DB::table('tbl_meritos')->where('cedula', $cedula)->get();
        return 'exito';
    }

    public static function editarobservacion($id, $cedula, $merito)
    {
        DB::table('tbl_meritos')->where('id', $id)->update(['descripcion' => $merito]);
        session_start();
        $_SESSION['meritosuser'] = DB::table('tbl_meritos')->where('cedula', $cedula)->get();
        return 'exito';
    }


    public static function eliminartitulo($cedula, $id)
    {
        DB::table('tbl_titulo')->where('id', $id)->delete();
        session_start();
        $_SESSION['titulosuser'] = DB::table('tbl_titulo')->where('cedula', $cedula)->get();
        return 'exito';
    }

    public static function eliminarobservacion($cedula, $id)
    {
        DB::table('tbl_meritos')->where('id', $id)->delete();
        session_start();
        $_SESSION['meritosuser'] = DB::table('tbl_meritos')->where('cedula', $cedula)->get();
        return 'exito';
    }

    public static function eliminarexperiencia($cedula, $id)
    {
        DB::table('tbl_experiencia')->where('id', $id)->delete();
        session_start();
        $_SESSION['experienciasuser'] = DB::table('tbl_experiencia')->where('cedula', $cedula)->get();
        return 'exito';
    }

    public static function crearcategoria($cedula, $nombre)
    {
        DB::table('tbl_categoria')->insert(['cedula' => $cedula, 'nombre' => $nombre]);
        session_start();
        $_SESSION['categoriasuser'] = DB::table('tbl_categoria')->where('cedula', $cedula)->get();
        return 'exito';
    }

    public static function eliminarcategoria($cedula, $id)
    {
        //verificar que esa categoria no este siendo usada, si lo esta, retornar que no se puede eliminar
        session_start();
        for ($i = 0; $i < sizeof($_SESSION['ofertasuser']); $i++) {
            for ($k = 0; $k < sizeof($_SESSION['ofertasuser'][$i]->categorias); $k++) {
                if ($id == $_SESSION['ofertasuser'][$i]->categorias[$k]->id) {
                    return 'No se puede eliminar la categoria ya que existen ofertas asignadas a dicha categoria.';
                }
            }
        }
        DB::table('tbl_categoria')->where('id', $id)->delete();
        $_SESSION['categoriasuser'] = DB::table('tbl_categoria')->where('cedula', $cedula)->get();
        return 'exito';
    }

    public static function eliminaroferta($cedula, $id)
    {
        DB::table('tbl_oferta')->where('id', $id)->delete();
        DB::table('tbl_requisito')->where('id_oferta', $id)->delete();
        DB::table('tbl_aplicacion')->where('idOferta', $id)->delete();
        DB::table('tbl_oftertascategoria')->where('idOferta', $id)->delete();

        //ya que eliminamos actualizar la informacion del usuario que existe en la session
        session_start();
        $ofertas = DB::table('tbl_oferta')->where('cedula', $cedula)->get();
                //para cada oferta buscar entre los requisitos
                for ($i = 0; $i < sizeof($ofertas); $i++) {
                    $id = $ofertas[$i]->id;
                    $ofertas[$i]->requisitos = DB::table('tbl_requisito')->where('id_oferta', $id)->get();
                    $ofertas[$i]->ofertascategoria = DB::table('tbl_oftertascategoria')->where('idOferta', $id)->get();
                    $ids = '';
                    for ($k = 0; $k < sizeof($ofertas[$i]->ofertascategoria); $k++) {
                        $ids = $ids . 'id=' . $ofertas[$i]->ofertascategoria[$k]->id;
                        if ($k == (sizeof($ofertas[$i]->ofertascategoria) - 1)) {
                            break;
                        } else {
                            $ids = $ids . ' || ';
                        }
                    }
                    if ($ids != '') {
                        $ofertas[$i]->categorias = DB::select(DB::raw('SELECT * FROM `tbl_categoria` WHERE ' . $ids));
                    }else{
                        $ofertas[$i]->categorias=new Collection();
                    }
                }
                $_SESSION['ofertasuser'] = $ofertas;
        return 'exito';
    }
}
