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


        //buscar la informacion respectiva de cada oferta
        for ($i = 0; $i < sizeof($ofertasMasNuevas); $i++) {
            $id = $ofertasMasNuevas[$i]->id;
            $ofertasMasNuevas[$i]->requisitos = DB::table('tbl_requisito')->where('id_oferta', $id)->get();
            $ofertasMasNuevas[$i]->ofertascategoria = DB::table('tbl_oftertascategoria')->where('idOferta', $id)->get();
            $ids = '';
            for ($k = 0; $k < sizeof($ofertasMasNuevas[$i]->ofertascategoria); $k++) {
                $ids = $ids . 'id=' . $ofertasMasNuevas[$i]->ofertascategoria[$k]->idCategoria;
                if ($k == (sizeof($ofertasMasNuevas[$i]->ofertascategoria) - 1)) {
                    break;
                } else {
                    $ids = $ids . ' || ';
                }
            }
            if ($ids != '') {
                $ofertasMasNuevas[$i]->categorias = DB::select(DB::raw('SELECT * FROM `tbl_categoria` WHERE ' . $ids));
            } else {
                $ofertasMasNuevas[$i]->categorias = new Collection();
            }

            //buscar duenno de cada oferta
            $ofertasMasNuevas[$i]->empresa = DB::table('tbl_usuario')->where('cedula',$ofertasMasNuevas[$i]->cedula)->pluck('nombre');
        }
        $_ENV['ofertasmasnuevas']=$ofertasMasNuevas;
    }

    public static function buscar($descripcion, $categoria, $empresa){
        return DB::table('tbl_oferta')
                ->select(['tbl_oferta.*','tbl_usuario.nombre as empresa'])
                ->join('tbl_oftertascategoria','tbl_oferta.id','=','tbl_oftertascategoria.idOferta')
                ->join('tbl_categoria','tbl_oftertascategoria.idCategoria','=','tbl_categoria.id')
                ->join('tbl_usuario','tbl_oferta.cedula','=','tbl_usuario.cedula')
                ->where('tbl_oferta.descripcion','LIKE','%'.$descripcion.'%')
                ->where('tbl_categoria.nombre','LIKE','%'.$categoria.'%')
                ->where('tbl_usuario.nombre','LIKE','%'.$empresa.'%')
                ->distinct()
                ->get();
    }
}
