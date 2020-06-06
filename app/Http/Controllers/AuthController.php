<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Auth;

class AuthController extends Controller
{
    
    public function index(){
        return view('Auth/login');
    }

    public function ingresar(){
        if(Auth::autenticar($_POST['txt_username'],$_POST['txt_password'])){
            echo 'nombre real';
        }else{
            $_POST['mensaje'] ='Nombre de usuario o contraseña incorrecta por favor intente de nuevo.';
            return view("Auth/login");
        }
    }

    public function registro(){
        return view('Auth/registro');
    }
}
