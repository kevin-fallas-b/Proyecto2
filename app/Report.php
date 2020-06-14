<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Report extends Model
{
    public static function reporteaplicaciones($cedula)
    {
        $aplicaciones = DB::table('tbl_aplicacion')->where('cedula', $cedula)->get();
        $oferta = [];
        for ($i = 0; $i < sizeof($aplicaciones); $i++) {
            $listado = DB::table('tbl_oferta')->where('id', $aplicaciones[$i]->idOferta)->get()->toArray();
            $listado['requisitos'] = DB::table('tbl_requisito')->where('id_oferta', $aplicaciones[$i]->idOferta)->get();
            $listado['ofertascategoria'] = DB::table('tbl_oftertascategoria')->where('idOferta', $aplicaciones[$i]->idOferta)->get();
            $ids = '';
            for ($k = 0; $k < sizeof($listado['ofertascategoria']); $k++) {
                $ids = $ids . 'id=' . $listado['ofertascategoria'][$k]->idCategoria;
                if ($k == (sizeof($listado['ofertascategoria']) - 1)) {
                    break;
                } else {
                    $ids = $ids . ' || ';
                }
            }
            if ($ids != '') {
                $listado['categorias'] = DB::select(DB::raw('SELECT * FROM `tbl_categoria` WHERE ' . $ids));
            }
            $listado['aplicantes'] = DB::table('tbl_aplicacion')->where('idOferta', $aplicaciones[$i]->idOferta)->get();
            $listado['empresa'] = DB::table('tbl_usuario')->where('cedula', $listado[0]->cedula)->get();
            array_push($oferta, $listado);
        }

        $_ENV['apps'] = $oferta;
    }

    public static function reporteempresa($cedula)
    {
        $empresa = DB::table('tbl_usuario')->where('cedula', $cedula)->get();
        $ofertas = DB::table('tbl_oferta')->where('cedula', $cedula)->get();
        //para cada oferta buscar sus requisitos y categorias
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
            }
        }
        $_ENV['empresareporte'] = $empresa;
        $_ENV['ofertasreporte'] = $ofertas;
    }

    public static function reportecurriculum($cedula)
    {
        $user = DB::table('tbl_usuario')->where('cedula', $cedula)->get();
        $titulos = DB::table('tbl_titulo')->where('cedula', $cedula)->get();
        $experiencias = DB::table('tbl_experiencia')->where('cedula', $cedula)->get();
        $meritos = DB::table('tbl_meritos')->where('cedula', $cedula)->get();

        $_ENV['userreporte'] = $user;
        $_ENV['titulosreporte'] = $titulos;
        $_ENV['experienciasreporte'] = $experiencias;
        $_ENV['meritosreporte'] = $meritos;
    }

    public static function reporteporcategoria()
    {
        $categorias = DB::table('tbl_categoria')->get()->toArray();
        
        for ($i = 0; $i < sizeof($categorias); $i++) {
            $ofertas = [];
            
            $ofertasids = DB::table('tbl_oftertascategoria')->where('idCategoria', $categorias[$i]->id)->get();
            for ($k = 0; $k < sizeof($ofertasids); $k++) {
                array_push($ofertas, DB::table('tbl_oferta')->where('id', $ofertasids[$k]->idOferta)->get());
            }
            
            for ($k = 0; $k < sizeof($ofertas); $k++) {
                $ofertas[$k]['requisitos'] = DB::table('tbl_requisito')->where('id_oferta', $ofertas[$k][0]->id)->get();
                $ofertas[$k]['ofertascategoria'] = DB::table('tbl_oftertascategoria')->where('idOferta', $ofertas[$k][0]->id)->get();
                $ids = '';
                for ($x = 0; $x < sizeof($ofertas[$k]['ofertascategoria']); $x++) {
                    $ids = $ids . 'id=' . $ofertas[$k]['ofertascategoria'][$x]->idCategoria;
                    if ($x == (sizeof($ofertas[$k]['ofertascategoria']) - 1)) {
                        break;
                    } else {
                        $ids = $ids . ' || ';
                    }
                }
                if ($ids != '') {
                    $ofertas[$k]['categorias'] = DB::select(DB::raw('SELECT * FROM `tbl_categoria` WHERE ' . $ids));
                }
            }
            $categorias[$i]->ofertas = $ofertas;
        }
        $_ENV['categoriasreporte'] = $categorias;
    }

    public static function buscarempresas($empresa){
        return DB::table('tbl_usuario')->where('tipo',2)->where('nombre','LIKE','%'.$empresa.'%')->get();
    }
}
