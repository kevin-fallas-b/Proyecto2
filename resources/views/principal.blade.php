<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sirhena</title>
    <link rel="stylesheet" type="text/css" href="{{ url('/css/style.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ url('/css/alertify.min.css') }}" />

    <script src="{{ url('/js/alertify.min.js')}}"></script>
    <script src="{{ url('/js/principal.js')}}"></script>
    <link rel="icon" href="{{ url('/img/favicon.png') }}" type="image/x-icon">

</head>
<?php

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

    if(isset($_POST['mensaje'])){
        echo "<script> mensaje('" . $_POST['mensaje'] . ", ".$_POST['tipomensaje']."'); </script>";
    }
?>

<body>


    <div id="barranavegacion" class="barranavegacion">
        <img src="{{url('/img/sirhena.png')}}" alt="" class="imagensirhena">
        <div id="botonesbarra" class="botonesbarra">
            <?php
            if (Session::get('user')->nombre != null) {
                echo '<a href="'.URL::to('/login').'" class="textobotonbarra" >'.Session::get('user')->nombre.'</a>';
                echo '<a href="'.URL::to('/login').'" class="textobotonbarra" >Mi Perfil</a>';
                echo '<a href="'.URL::to('/logout').'" class="textobotonbarra">Cerrar Session</a>';
            } else {
                echo '<a href="'.URL::to('/login').'" class="textobotonbarra" >Log In</a>';
                echo '<a href="'.URL::to('/login').'" class="textobotonbarra" >Registrarme</a>';
            }
            ?>
            
        </div>
    </div>
    <div id="main">

    </div>

</html>