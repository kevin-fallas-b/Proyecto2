<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\url;


class UserController extends Controller
{

    public function index()
    {
        return view('miperfil');
    }

    public function actualizar(){
        return Auth::registrar($_POST['cedula'], $_POST['nombre'], $_POST['apellidos'], $_POST['usuario'], $_POST['contra'], $_POST['direccion'], $_POST['tipo'], $_POST['telefono'], $_POST['correo']);
    }
}
