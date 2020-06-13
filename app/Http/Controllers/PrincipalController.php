<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Principal;


class PrincipalController extends Controller
{
    public function index()
    {
        Principal::getofertasmasnuevas();
        return view('principal');
    }

    public function buscar(){
        return Principal::buscar($_POST['descripcion'],$_POST['categoria'],$_POST['empresa']);
    }

    public function verlistado(){
       return Principal::verlistado($_POST['id']);
    }
    public function aplicar(){
        return Principal::aplicar($_POST['idoferta'],$_POST['cedula']);
     }
}