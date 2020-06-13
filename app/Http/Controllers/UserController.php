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
            return User::actualizarexperiencia($_POST['id'], $_POST['cedula'], $_POST['empresa'], $_POST['puesto'], $_POST['responsabilidades'], $_POST['fechaingreso'], $_POST['fechasalida']);
        } else {
            //estamos creando un titulo bien mamalon
            return User::crearexperiencia($_POST['cedula'], $_POST['empresa'], $_POST['puesto'], $_POST['responsabilidades'], $_POST['fechaingreso'], $_POST['fechasalida']);
        }
    }

    public function guardarobservacion()
    {
        if (isset($_POST['id'])) {
            //editar 
            return User::editarobservacion($_POST['id'], $_POST['cedula'], $_POST['merito']);
        } else {
            return User::crearobservacion($_POST['cedula'], $_POST['merito']);
        }
    }

    public function eliminar()
    {
        switch ($_POST['tipo']) {
            case 1:
                return User::eliminartitulo($_POST['cedula'], $_POST['id']);
                break;
            case 2:
                return User::eliminarexperiencia($_POST['cedula'], $_POST['id']);
                break;
            case 3:
                return User::eliminarobservacion($_POST['cedula'], $_POST['id']);
                break;
            case 4:
                return User::eliminaroferta($_POST['cedula'], $_POST['id']);
                break;
            case 5:
                return User::eliminarcategoria($_POST['cedula'], $_POST['id']);
                break;
        }
    }

    public function verofertas()
    {
        return view('ofertas');
    }

    public function guardarcategoria()
    {
        return User::crearcategoria($_POST['cedula'], $_POST['categoria']);
    }

    public function guardaroferta()
    {
        if (isset($_POST['id'])) {
            return User::actualizaroferta($_POST['id'], $_POST['cedula'], $_POST['descripcion'], $_POST['vacantes'], $_POST['ubicacion'], $_POST['horario'], $_POST['contrato'], $_POST['salario'], $_POST['requisitos'], $_POST['categorias']);
        } else {
            return User::crearoferta($_POST['cedula'], $_POST['descripcion'], $_POST['vacantes'], $_POST['ubicacion'], $_POST['horario'], $_POST['contrato'], $_POST['salario'], $_POST['requisitos'], $_POST['categorias']);
        }
    }

    public function misaplicaciones(){
        User::misaplicaciones();
        return view('misaplicaciones');
    }
}
