<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\url;


class AuthController extends Controller
{

    public function index()
    {
        return view('Auth/login');
    }

    public function ingresar()
    {
        if (Auth::autenticar($_POST['txt_username'], $_POST['txt_password'])) {
            header('Location: ' . URL::to('/'), true, 301);
            die();
            //para obtener cualquier informacion del usuario logeado se usa Session('user') y eso le devuelve un array con toda la info del usuario  
            //entonces obtener nombre seria  Session::get('user')->nombre;
        } else {
            $_POST['mensaje'] = 'Nombre de usuario o contraseña incorrecta por favor intente de nuevo.';
            return view("Auth/login");
        }
    }

    public function registro()
    {
        return view('Auth/registro');
    }

    public function registrar()
    {
        return Auth::registrar($_POST['cedula'], $_POST['nombre'], $_POST['apellidos'], $_POST['usuario'], $_POST['contra'], $_POST['direccion'], $_POST['tipo'], $_POST['telefono'], $_POST['correo']);
    }

    public function cerrarsession()
    {
        Session::flush();
        $_POST['mensaje'] = 'Session cerrada correctamente.';
        $_POST['tipomensaje'] = 1;
        header('Location: ' . URL::to('/'), true, 301);
        die();
    }
}
