<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\url;


class UserController extends Controller
{

    public function index()
    {
        return view('miperfil');
    }

    public function actualizar()
    {
        $foto = null;
        if (isset($_FILES['foto'])) {
            $foto = $_FILES['foto'];
        }
        if (isset($_POST['apellidos'])) {
            $apellidos = $_POST['apellidos'];
        } else {
            $apellidos = '';
        }

        if (isset($_POST['contra'])) {
            $contra = $_POST['contra'];
        } else {
            $contra = null;
        }

        return User::actualizarusuario($_POST['cedula'], $_POST['nombre'], $apellidos, $contra, $_POST['direccion'], $_POST['telefono'], $_POST['correo'], $foto);
    }

    public function vercurriculum()
    {
        return view('curriculum');
    }

    public function guardartitulo()
    {
        if (isset($_POST['id'])) {
            //estamos editando perro
            return User::actualizartitulo($_POST['id'], $_POST['cedula'], $_POST['titulo'], $_POST['institucion'], $_POST['especialidad'], $_POST['mes'], $_POST['ano']);
        } else {
            //estamos creando un titulo bien mamalon
            return User::creartitulo($_POST['cedula'], $_POST['titulo'], $_POST['institucion'], $_POST['especialidad'], $_POST['mes'], $_POST['ano']);
        }
    }

    public function guardarexperiencia()
    {
        if (isset($_POST['id'])) {
            //estamos editando perro
            return User::actualizarexperiencia($_POST['id'], $_POST['empresa'], $_POST['puesto'], $_POST['responsabilidades'], $_POST['fechaingreso'], $_POST['fechasalida']);
        } else {
            //estamos creando un titulo bien mamalon
            return User::crearexperiencia($_POST['cedula'], $_POST['empresa'], $_POST['puesto'], $_POST['responsabilidades'], $_POST['fechaingreso'], $_POST['fechasalida']);
        }
    }

    public function guardarobservacion()
    {
        if (isset($_POST['id'])) {
            //editar 
        } else {
            return User::crearobservacion($_POST['cedula'],$_POST['merito']);
        }
    }
}
