<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reportes - Sirhena</title>
    <link rel="stylesheet" type="text/css" href="{{ url('/css/style.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ url('/css/reportes.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ url('/css/alertify.min.css') }}" />

    <script src="{{ url('/js/alertify.min.js')}}"></script>
    <script src="{{ url('/js/axios.min.js')}}"></script>
    <script src="{{ url('/js/reportes.js')}}"></script>
    <script src="{{ url('/js/general.js')}}"></script>
    <link rel="icon" href="{{ url('/img/favicon.png') }}" type="image/x-icon">
</head>
<?php

use Illuminate\Support\Facades\URL;


?>

<body>


    <div id="barranavegacion" class="barranavegacion">
        <label id='sirhena'>SIRHENA</label>
        <img src="{{url('/img/sirhena.png')}}" alt="" class="imagensirhena" id="logosirhena">
        <div id="botonesbarra" class="botonesbarra">
            <?php
            session_start();
            if (isset($_SESSION['user'])) {
                echo '<label id="mensajebienvenida"> Bienvenido ' . $_SESSION['user']->nombre . '</label>';
                echo '<a href="' . URL::to('/miperfil') . '" class="textobotonbarra" >Mi Perfil</a>';
                if ($_SESSION['user']->tipo == 1) {
                    echo '<label id="lblcedulauser" hidden>' . $_SESSION['user']->cedula . '</label>';
                    echo '<a href="' . URL::to('/miperfil/curriculum') . '" class="textobotonbarra" >Mi Curriculum</a>';
                }
                if ($_SESSION['user']->tipo == 2) {
                    echo '<label id="lblcedulauser" hidden>' . $_SESSION['user']->cedula . '</label>';
                    echo '<a href="' . URL::to('/miperfil/ofertas') . '" class="textobotonbarra" >Mis Ofertas</a>';
                }
                echo '<a href="' . URL::to('/') . '" class="textobotonbarra" >Pagina Principal</a>';
                echo '<a href="' . URL::to('/logout') . '" class="textobotonbarra">Cerrar Session</a>';
            } else {
                echo '<label id="lblcedulauser" hidden>-1</label>';
                echo '<a href="' . URL::to('/login') . '" class="textobotonbarra" >Log In</a>';
                echo '<a href="' . URL::to('/registro') . '" class="textobotonbarra" >Registrarme</a>';
                header('Location: ' . URL::to('/nologeado'), true, 302);
                die();
            }
            ?>

        </div>
    </div>
    <div id="main">
        <div id="panelprincipal">

            <div class="contenedor" id="contenedorreportesbasicos">
                <div class="lblcontenedor">
                    <label>Reportes Basicos</label>
                </div>
                <div class="hijoshorizontal">
                    <div>
                        <form action="/reporte/categorias" id="categoria" name="categoria" method="POST" target="_blank" hidden>
                            {{csrf_field()}}
                        </form>
                        <label for="">Ofertas Por Categoria</label><br>
                        <input type="submit" value="Generar" class="btnconestilo" form="categoria">
                    </div>
                    <div>
                        <form action="/reporte/barras" id="barras" name="barras" method="POST" target="_blank" hidden>
                            {{csrf_field()}}
                        </form>
                        <label for="">Vacantes vs Empresas</label><br>
                        <input type="submit" value="Generar" class="btnconestilo" form="barras">
                    </div>

                    <?php
                    if ($_SESSION['user']->tipo == 1) {
                    ?>
                        <div>
                            <form action="/reporte/curriculum" id="curriculum" name="curriculum" method="POST" target="_blank" hidden>
                                {{csrf_field()}}
                                <input type="text" id="cedula" name="cedula" value="<?php echo $_SESSION['user']->cedula ?>">

                            </form>
                            <label for="">Mi Curriculum</label><br>
                            <input type="submit" value="Generar" class="btnconestilo" form="curriculum">
                        </div>
                        <div id="contenedorporcategoria">
                            <form action="/reporte/aplicaciones" id="aplicaciones" name="aplicaciones" method="POST" target="_blank" hidden>
                                {{csrf_field()}}
                                <input type="text" id="cedula" name="cedula" value="<?php echo $_SESSION['user']->cedula ?>">

                            </form>
                            <label for="">Mis Aplicaciones</label><br>
                            <input type="submit" value="Generar" class="btnconestilo" form="aplicaciones">
                        </div>
                    <?php
                    }
                    ?>
                </div>

            </div>
            <div class="contenedor" id="contenedorporempresa">
                <div class="lblcontenedor">
                    <label>Reportes por Empresa</label>
                </div>
                <div>
                    <input type="text" class="cajatexto" id='txtbuscar' placeholder="Nombre de la empresa">
                    <input type="button" class="btnconestilo" value="Buscar" id='btnbuscar'>
                </div>

                <div id="contenedorempresas">

                </div>
            </div>
        </div>
    </div>



</body>

</html>