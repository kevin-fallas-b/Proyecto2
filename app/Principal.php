<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;



class Principal extends Model
{
    //metodo que busca las 10 ofertas mas nuevas para mostrar en pagina principal
    public static function getofertasmasnuevas()
    {
        $ofertasMasNuevas = DB::table('tbl_oferta')->orderByDesc('id')->limit(10)->get();

        for ($i = 0; $i < sizeof($ofertasMasNuevas); $i++) {
            //buscar duenno de cada oferta
            $ofertasMasNuevas[$i]->empresa = DB::table('tbl_usuario')->where('cedula', $ofertasMasNuevas[$i]->cedula)->pluck('nombre');
        }
        $_ENV['ofertasmasnuevas'] = $ofertasMasNuevas;
    }

    public static function buscar($descripcion, $categoria, $empresa)
    {
        return DB::table('tbl_oferta')
            ->select(['tbl_oferta.*', 'tbl_usuario.nombre as empresa'])
            ->join('tbl_oftertascategoria', 'tbl_oferta.id', '=', 'tbl_oftertascategoria.idOferta')
            ->join('tbl_categoria', 'tbl_oftertascategoria.idCategoria', '=', 'tbl_categoria.id')
            ->join('tbl_usuario', 'tbl_oferta.cedula', '=', 'tbl_usuario.cedula')
            ->where('tbl_oferta.descripcion', 'LIKE', '%' . $descripcion . '%')
            ->where('tbl_categoria.nombre', 'LIKE', '%' . $categoria . '%')
            ->where('tbl_usuario.nombre', 'LIKE', '%' . $empresa . '%')
            ->distinct()
            ->get();
    }

    public static function verlistado($id)
    {
        $listado = DB::table('tbl_oferta')->where('id', $id)->get()->toArray();
        $listado['requisitos'] = DB::table('tbl_requisito')->where('id_oferta', $id)->get();
        $listado['ofertascategoria'] = DB::table('tbl_oftertascategoria')->where('idOferta', $id)->get();
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
        $listado['aplicantes'] = DB::table('tbl_aplicacion')->where('idOferta', $id)->get();
        $listado['empresa'] = DB::table('tbl_usuario')->where('cedula', $listado[0]->cedula)->get();
        return $listado;
    }

    public static function aplicar($idoferta,$cedula){
        DB::table('tbl_aplicacion')->insert(['idOferta'=>$idoferta,'cedula'=>$cedula]);
        return 'exito';
    }

    public static function removerapp($idoferta,$cedula){
        DB::table('tbl_aplicacion')->where('idOferta',$idoferta)->where('cedula',$cedula)->delete();
        return 'exito';
    }
}
