<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sirhena</title>
    <link rel="stylesheet" type="text/css" href="{{ url('/css/style.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ url('/css/principal.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ url('/css/alertify.min.css') }}" />

    <script src="{{ url('/js/alertify.min.js')}}"></script>
    <script src="{{ url('/js/axios.min.js')}}"></script>
    <script src="{{ url('/js/principal.js')}}"></script>
    <script src="{{ url('/js/general.js')}}"></script>
    <link rel="icon" href="{{ url('/img/favicon.png') }}" type="image/x-icon">

</head>
<?php

use Illuminate\Support\Facades\URL;

session_start();

?>

<body>


    <div id="barranavegacion" class="barranavegacion">
        <label id='sirhena'>SIRHENA</label>
        <img src="{{url('/img/sirhena.png')}}" alt="" class="imagensirhena" id="logosirhena">
        <div id="botonesbarra" class="botonesbarra">
            <?php
            if (isset($_SESSION['user'])) {
                echo '<label id="mensajebienvenida"> Bienvenido ' . $_SESSION['user']->nombre . '</label>';
                echo '<a href="' . URL::to('/miperfil') . '" class="textobotonbarra" >Mi Perfil</a>';
                if ($_SESSION['user']->tipo == 1) {
                    echo '<label id="lblcedulauser" hidden>' . $_SESSION['user']->cedula . '</label>';
                    echo '<a href="' . URL::to('/miperfil/curriculum') . '" class="textobotonbarra" >Mi Curriculum</a>';
                } else {
                    echo '<label id="lblcedulauser" hidden>-1</label>';
                    echo '<a href="' . URL::to('/miperfil/ofertas') . '" class="textobotonbarra" >Mis Ofertas</a>';
                }
                echo '<a href="' . URL::to('/logout') . '" class="textobotonbarra">Cerrar Session</a>';
            } else {
                echo '<label id="lblcedulauser" hidden>-1</label>';
                echo '<a href="' . URL::to('/login') . '" class="textobotonbarra" >Log In</a>';
                echo '<a href="' . URL::to('/registro') . '" class="textobotonbarra" >Registrarme</a>';
            }
            ?>

        </div>
    </div>
    <div id="main">
        <!-- Parte de busqueda -->
        <div id="panelbusqueda">
            <div class="lblcontenedor">
                <label for="">Busqueda</label>
            </div>
            <br><label>Descripcion:</label><br>
            <input type="text" class="cajatexto" id="txtdescripcion" placeholder="Descripcion"><br>
            <label for="">Categoria:</label><br>
            <input type="text" class="cajatexto" id="txtcategoria" placeholder="Categoria"><br>
            <label for="">Empresa:</label><br>
            <input type="text" class="cajatexto" id="txtempresa" placeholder="Empresa"><br>
            <input type="button" class="btnconestilo" value="Buscar" id="btnbuscar">
        </div>

        <!--donde veo trabajos y demas-->
        <div id="panelprincipal">
            <div class="lblcontenedor">
                <label for="">Ofertas mas recientes</label>
            </div>
            <div id="contenedordetalles">
                <?php
                for ($i = 0; $i < sizeof($_ENV['ofertasmasnuevas']); $i++) {
                    echo '<div class="detallecontenedor">';
                    echo '<label>Descripcion: ' . $_ENV['ofertasmasnuevas'][$i]->descripcion . '</label><br>';
                    echo '<label>Empresa: ' . $_ENV['ofertasmasnuevas'][$i]->empresa[0] . '</label><br>';
                    echo '<label>Vacantes: ' . $_ENV['ofertasmasnuevas'][$i]->numero_vacantes . '</label><br>';
                    echo '<label>Fecha de publicacion: ' . $_ENV['ofertasmasnuevas'][$i]->fecha . '</label><br>';
                    echo '<input type="button" value="Ver listado" class="btnconestilo" onclick="verlistado(' . $_ENV['ofertasmasnuevas'][$i]->id . ')">';
                    echo '</div>';
                }
                ?>
            </div>
        </div>
    </div>


    <div class="bg-modal" id="modallistado">
        <div class="modal-contents">
            <input type="button" name="" id="" class="close" value="+" onclick="cerrarmodal()">
            <div class="contenedortitulomodal">
                <label id='lblregistrareditarexperiencia'>Listado</label>
            </div>
            <div class='contenedoropcionesmodal' id="contenedornombrecategoria">
                <label>Descripcion: </label><label id="lbldescripcion"> </label> <br>
                <label>Empresa: </label><label id="lblempresa"> </label> <br>
                <label>Vacantes: </label><label id="lblvacantes"> </label> <br>
                <label>Ubicacion: </label><label id="lblubicacion"> </label> <br>
                <label>Horario: </label><label id="lblhorario"> </label> <br>
                <label>Duracion contrato: </label><label id="lblcontrato"> </label> <br>
                <label>Salario: ‎₡</label><label id="lblsalario"> </label> <br>
                <label>Fecha de publicacion: ‎</label><label id="lblfecha"> </label> <br>
                <label for="">Requisitos:</label>
                <div id="contenedorrequisitos">

                </div>
                <label for="">Categorias:</label>
                <div id="contenedorcategorias">

                </div>
                <label for="">Numero de aplicantes: </label><label id="lblcantidadaplicantes"></label>
                <?php
                if (!(isset($_SESSION['user']) && $_SESSION['user']->tipo == 2)) {
                    echo '<input type="button" value="Aplicar" onclick="aplicaroferta()">';
                }
                ?>

            </div>

            <div class='contenedorbotonesmodal'>
                <input type="button" value="Cancelar" class="btnconestilo" id="btncancelarmodal" onclick="cerrarmodal()">
            </div>
        </div>
    </div>
</body>

</html>