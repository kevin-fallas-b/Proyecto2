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

        return User::actualizar($_POST['cedula'], $_POST['nombre'], $apellidos, $contra, $_POST['direccion'], $_POST['telefono'], $_POST['correo'], $foto);
    }
}
