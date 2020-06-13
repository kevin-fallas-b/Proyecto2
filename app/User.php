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
                $ids = $ids . 'id=' . $ofertas[$i]->ofertascategoria[$k]->idCategoria;
                if ($k == (sizeof($ofertas[$i]->ofertascategoria) - 1)) {
                    break;
                } else {
                    $ids = $ids . ' || ';
                }
            }
            if ($ids != '') {
                $ofertas[$i]->categorias = DB::select(DB::raw('SELECT * FROM `tbl_categoria` WHERE ' . $ids));
            } else {
                $ofertas[$i]->categorias = new Collection();
            }
        }
        $_SESSION['ofertasuser'] = $ofertas;
        return 'exito';
    }

    public static function crearoferta($cedula, $descripcion, $vacantes, $ubicacion, $horario, $contrato, $salario, $requisitosJSON, $categoriasJSON)
    {
        $fecha = date("Y-m-d");
        $idoferta = DB::table('tbl_oferta')->insertGetId(['cedula' => $cedula, 'descripcion' => $descripcion, 'numero_vacantes' => $vacantes, 'fecha' => $fecha, 'ubicacion' => $ubicacion, 'horario' => $horario, 'salario' => $salario, 'duracion' => $contrato]);
        $requisitos = json_decode($requisitosJSON);
        for ($i = 0; $i < sizeof($requisitos); $i++) {
            DB::table('tbl_requisito')->insert(['id_oferta' => $idoferta, 'Descripcion' => $requisitos[$i]]);
        }
        $categorias = json_decode($categoriasJSON);
        for ($i = 0; $i < sizeof($categorias); $i++) {
            DB::table('tbl_oftertascategoria')->insert(['idOferta' => $idoferta, 'idCategoria' => $categorias[$i]]);
        }


        session_start();
        $ofertas = DB::table('tbl_oferta')->where('cedula', $cedula)->get();
        //para cada oferta buscar entre los requisitos
        for ($i = 0; $i < sizeof($ofertas); $i++) {
            $id = $ofertas[$i]->id;
            $ofertas[$i]->requisitos = DB::table('tbl_requisito')->where('id_oferta', $id)->get();
            $ofertas[$i]->ofertascategoria = DB::table('tbl_oftertascategoria')->where('idOferta', $id)->get();
            $ids = '';
            for ($k = 0; $k < sizeof($ofertas[$i]->ofertascategoria); $k++) {
                $ids = $ids . 'id=' . $ofertas[$i]->ofertascategoria[$k]->idCategoria;
                if ($k == (sizeof($ofertas[$i]->ofertascategoria) - 1)) {
                    break;
                } else {
                    $ids = $ids . ' || ';
                }
            }
            if ($ids != '') {
                $ofertas[$i]->categorias = DB::select(DB::raw('SELECT * FROM `tbl_categoria` WHERE ' . $ids));
            } else {
                $ofertas[$i]->categorias = new Collection();
            }
        }
        $_SESSION['ofertasuser'] = $ofertas;
        return 'exito';
    }

    public static function actualizaroferta($id, $cedula, $descripcion, $vacantes, $ubicacion, $horario, $contrato, $salario, $requisitosJSON, $categoriasJSON)
    {
        //hora de inicio 6:19pm, pienso que esto va a ser un dolor de huevos inmenso
        //primero que todo actualizar el objeto oferta, no deberia ser dificil, fecha no la actualizamos porque es fecha en que se posteo el anuncio
        DB::table('tbl_oferta')->where('id', $id)->update(['descripcion' => $descripcion, 'numero_vacantes' => $vacantes, 'ubicacion' => $ubicacion, 'horario' => $horario, 'salario' => $salario, 'duracion' => $contrato]);

        //ya actualizamos el objeto oferta, ahora actualizar requisitos.
        //como requisitos hay muchos para 1 oferta, debemos tener cuidado de no repetir, y ver cuales hay que eliminar, primero vemos cuales ya existen
        $requisitosExistentes = DB::table('tbl_requisito')->where('id_oferta', $id)->get();

        //ahora pasamos los que el usuario guardo en esta edicion de fucking awesome JSON a un array php
        $requisitos = json_decode($requisitosJSON, true);
        //ahora, removemos todos los requisitos existentes de ese array que acabamos de crear, los que queden en existente toca borrarlos, los que queden en requisitos toca guardarlos
        $enAmbos = [];
        $aEliminar = [];
        for ($i = 0; $i < sizeof($requisitosExistentes); $i++) {
            if (in_array($requisitosExistentes[$i]->Descripcion, $requisitos)) {
                array_push($enAmbos, $requisitosExistentes[$i]);
            } else {
                array_push($aEliminar, $requisitosExistentes[$i]);
            }
        }

        $aCrear = [];
        for ($i = 0; $i < sizeof($requisitos); $i++) {
            $contenido = false; //es una bandera
            for ($k = 0; $k < sizeof($enAmbos); $k++) {
                if ($requisitos[$i] == $enAmbos[$k]->Descripcion) {
                    $contenido = true;
                    break;
                }
            }
            if (!$contenido) {
                array_push($aCrear, $requisitos[$i]);
            }
        }
        for ($i = 0; $i < sizeof($aEliminar); $i++) {
            DB::table('tbl_requisito')->where('id', $aEliminar[$i]->id)->delete();
        }

        for ($i = 0; $i < sizeof($aCrear); $i++) {
            DB::table('tbl_requisito')->insert(['id_oferta' => $id, 'Descripcion' => $aCrear[$i]]);
        }
        //vamos con categorias
        $categoriasExistentes = DB::table('tbl_oftertascategoria')->where('idOferta', $id)->get();
        $categorias = json_decode($categoriasJSON, true);
        $enAmbosCate = [];
        $aEliminarCate = [];
        for ($i = 0; $i < sizeof($categoriasExistentes); $i++) {
            if (in_array($categoriasExistentes[$i]->idCategoria, $categorias)) {
                array_push($enAmbosCate, $categoriasExistentes[$i]);
            } else {
                array_push($aEliminarCate, $categoriasExistentes[$i]);
            }
        }

        $aCrearCate = [];
        for ($i = 0; $i < sizeof($categorias); $i++) {
            $contenido = false; //es una bandera
            for ($k = 0; $k < sizeof($enAmbosCate); $k++) {
                if ($categorias[$i] == $enAmbosCate[$k]->idCategoria) {
                    $contenido = true;
                    break;
                }
            }
            if (!$contenido) {
                array_push($aCrearCate, $categorias[$i]);
            }
        }
        for ($i = 0; $i < sizeof($aEliminarCate); $i++) {
            DB::table('tbl_oftertascategoria')->where('id', $aEliminarCate[$i]->id)->delete();
        }

        for ($i = 0; $i < sizeof($aCrearCate); $i++) {
            DB::table('tbl_oftertascategoria')->insert(['idOferta' => $id, 'idCategoria' => $aCrearCate[$i]]);
        }


        //por ultimo refrescamos informacion de session
        session_start();
        $ofertas = DB::table('tbl_oferta')->where('cedula', $cedula)->get();
        //para cada oferta buscar entre los requisitos
        for ($i = 0; $i < sizeof($ofertas); $i++) {
            $id = $ofertas[$i]->id;
            $ofertas[$i]->requisitos = DB::table('tbl_requisito')->where('id_oferta', $id)->get();
            $ofertas[$i]->ofertascategoria = DB::table('tbl_oftertascategoria')->where('idOferta', $id)->get();
            $ids = '';
            for ($k = 0; $k < sizeof($ofertas[$i]->ofertascategoria); $k++) {
                $ids = $ids . 'id=' . $ofertas[$i]->ofertascategoria[$k]->idCategoria;
                if ($k == (sizeof($ofertas[$i]->ofertascategoria) - 1)) {
                    break;
                } else {
                    $ids = $ids . ' || ';
                }
            }
            if ($ids != '') {
                $ofertas[$i]->categorias = DB::select(DB::raw('SELECT * FROM `tbl_categoria` WHERE ' . $ids));
            } else {
                $ofertas[$i]->categorias = new Collection();
            }
        }
        $_SESSION['ofertasuser'] = $ofertas;
        return 'exito';
        //listo, no fue facil pero tampoco tan dolor de cabeza. hora de finalizacion 8:12pm
        //se que hay mucho campo para optimizar el codigo, pero no hay tiempo jaja
    }

    public static function misaplicaciones()
    {
        session_start();
        $_SESSION['misaplicaciones']=[];
        $aplicaciones = DB::table('tbl_aplicacion')->where('cedula', $_SESSION['user']->cedula)->get();
        $ids = '';
        for ($i = 0; $i < sizeof($aplicaciones); $i++) {
            $ids = $ids . 'tbl_oferta.id=' . $aplicaciones[$i]->idOferta;
            if ($i == (sizeof($aplicaciones) - 1)) {
                break;
            } else {
                $ids = $ids . ' || ';
            }
        }
        if ($ids != '') {
            $_SESSION['misaplicaciones'] = DB::select(DB::raw('SELECT tbl_oferta.* , tbl_usuario.nombre as empresa FROM `tbl_oferta` JOIN `tbl_usuario` on tbl_oferta.cedula = tbl_usuario.cedula WHERE ' . $ids . ' order by tbl_oferta.id DESC'));
        }
    }
}
