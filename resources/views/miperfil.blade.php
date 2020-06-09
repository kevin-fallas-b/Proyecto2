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
            }
            ?>

        </div>
    </div>
    <div id="main">

        <!--donde veo trabajos y demas-->
        <div id="panelprincipal">

        </div>
    </div>

</html>