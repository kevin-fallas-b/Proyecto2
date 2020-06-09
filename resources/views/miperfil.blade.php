<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mi Perfil - Sirhena</title>
    <link rel="stylesheet" type="text/css" href="{{ url('/css/style.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ url('/css/user.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ url('/css/alertify.min.css') }}" />

    <script src="{{ url('/js/alertify.min.js')}}"></script>
    <script src="{{ url('/js/user.js')}}"></script>
    <script src="{{ url('/js/general.js')}}"></script>
    <link rel="icon" href="{{ url('/img/favicon.png') }}" type="image/x-icon">

</head>


<body>
    <div id="barranavegacion" class="barranavegacion">
        <label id='sirhena'>MI PERFIL</label>
        <img src="{{url('/img/sirhena.png')}}" alt="" class="imagensirhena" id="logosirhena">
        <div id="botonesbarra" class="botonesbarra">
            <?php

            use Illuminate\Support\Facades\URL;

            session_start();
            if (isset($_SESSION['user'])) {
                echo '<label id="mensajebienvenida"> Bienvenido ' . $_SESSION['user']->nombre . '</label>';
                echo '<a href="' . URL::to('/') . '" class="textobotonbarra" >Pagina Principal</a>';
                echo '<a href="' . URL::to('/logout') . '" class="textobotonbarra">Cerrar Session</a>';
            } else {
                echo '<a href="' . URL::to('/login') . '" class="textobotonbarra" >Log In</a>';
                echo '<a href="' . URL::to('/registro') . '" class="textobotonbarra" >Registrarme</a>';

                header('Location: ' . URL::to('/nologeado'), true, 302);
                die();
            }
            ?>

        </div>
    </div>
    <div id="main">

        <!--donde veo trabajos y demas-->
        <div id="panelprincipal">
            <div id="contenedorfoto">
                <img src="{{ url('/img/users/')}}<?php echo '/' . $_SESSION['user']->foto ?>" alt="Foto de usuario" id="fotousuario">
                <label for="" id="lblnombreusuario">Nombre de usuario: <?php echo  $_SESSION['user']->user ?> </label>
                <?php 
                    if($_SESSION['user']->tipo == 1){
                        echo ' <label for="" id="lbltipodecuenta">Tipo de cuenta: Personal</label>';
                    }else{
                        echo ' <label for="" id="lbltipodecuenta">Tipo de cuenta: Empresarial</label>';
                    }
                ?>
            </div>
            <div id="informacionpersonal">
                <label for="" id="lblinfopersonal">Informacion Personal:</label>
                <div id="columna1" class="columna">
                    <?php
                    if ($_SESSION['user']->tipo == 1) {
                        echo "<label id='cedula'>Cedula: " . $_SESSION['user']->cedula . "</label> <br><br>";
                    }else{
                    echo "<label id='cedula'>Cedula Juridica: " . $_SESSION['user']->cedula . "</label> <br><br>";
                    }
                    echo "<label id='cedula'>Nombre: " . $_SESSION['user']->nombre . "</label> <br><br>";
                    if ($_SESSION['user']->tipo == 1) {
                        echo "<label id='cedula'>Apellidos: " . $_SESSION['user']->apellido . "</label><br><br>";
                    }
                    ?>
                </div>
                <div id="columna2" class="columna">
                    <?php
                    echo "<label id='cedula'>Telefono: " . $_SESSION['user']->telefono . "</label><br><br>";
                    echo "<label id='cedula'>Correo: " . $_SESSION['user']->correo . "</label><br><br>";
                    echo "<label id='cedula'>Direccion: " . $_SESSION['user']->direccion . "</label><br><br>";
                    ?>
                </div>
                <input type="button" value="Editar" id="btneditar">
            </div>
        </div>
    </div>

</html>