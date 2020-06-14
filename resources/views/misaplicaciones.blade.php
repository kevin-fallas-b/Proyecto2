<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mis Aplicaciones - Sirhena</title>
    <link rel="stylesheet" type="text/css" href="{{ url('/css/style.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ url('/css/aplicaciones.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ url('/css/alertify.min.css') }}" />

    <script src="{{ url('/js/alertify.min.js')}}"></script>
    <script src="{{ url('/js/axios.min.js')}}"></script>
    <script src="{{ url('/js/aplicaciones.js')}}"></script>
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
            if (isset($_SESSION['user'])) {
                echo '<label id="mensajebienvenida"> Bienvenido ' . $_SESSION['user']->nombre . '</label>';
                echo '<a href="' . URL::to('/miperfil') . '" class="textobotonbarra" >Mi Perfil</a>';
                if ($_SESSION['user']->tipo == 1) {
                    echo '<label id="lblcedulauser" hidden>' . $_SESSION['user']->cedula . '</label>';
                    echo '<a href="' . URL::to('/miperfil/curriculum') . '" class="textobotonbarra" >Mi Curriculum</a>';
                }
                if ($_SESSION['user']->tipo == 2) {
                    //es un perfil de una empresa, nada tiene que estar haciendo aqui
                    header('Location: ' . URL::to('/sinpermisos'), true, 302);
                }
                echo '<a href="' . URL::to('/reportes') . '" class="textobotonbarra" >Reportes</a>';
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
        <!--donde veo trabajos y demas-->
        <form id="reporte" action="/reporte/aplicaciones" method="POST" target="_blank" hidden>
            {{csrf_field()}}
            <input type="text" id="cedula" name="cedula" value="<?php echo $_SESSION['user']->cedula ?>">
        </form>
        <div id="panelprincipal">
            <div class="lblcontenedor">
                <label id="lblofertasbusqueda">Ofertas a las que he aplicado</label>
                <input type="submit" form="reporte" value="Generar Reporte" id="btnreporteaplicaciones" class="btnconestilo">
            </div>
            <div id="contenedordetalles">
                <?php
                for ($i = 0; $i < sizeof($_SESSION['misaplicaciones']); $i++) {
                    echo '<div class="detallecontenedor">';
                    echo '<label>Descripcion: ' . $_SESSION['misaplicaciones'][$i]->descripcion . '</label><br>';
                    echo '<label>Empresa: ' . $_SESSION['misaplicaciones'][$i]->empresa . '</label><br>';
                    echo '<label>Vacantes: ' . $_SESSION['misaplicaciones'][$i]->numero_vacantes . '</label><br>';
                    echo '<label>Fecha de publicacion: ' . $_SESSION['misaplicaciones'][$i]->fecha . '</label><br>';
                    echo '<form id="' . $i . '"action="/reporte/empresa" method="POST" target="_blank" hidden>';
                ?>
                    {{csrf_field()}}
                <?php
                    echo '<input type="text" id="empresa" name="empresa" hidden value="' . $_SESSION['misaplicaciones'][$i]->empresacedula . '">';
                    echo '</form>';
                    echo '<input type="submit" form="' . $i . '" value="Ver reporte de empresa" class="btnconestilo btnverreporteempresa">';
                    echo '<input type="button" value="Ver listado" class="btnconestilo" onclick="verlistado(' . $_SESSION['misaplicaciones'][$i]->id . ')">';
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
            <div class='contenedoropcionesmodal'>
                <div id="contenedorinfobasica">
                    <div id="columna1">
                        <label style="font-weight: bold;">Descripcion: </label><label id="lbldescripcion"> </label> <br>
                        <label style="font-weight: bold;">Empresa: </label><label id="lblempresa"> </label> <br>
                        <label style="font-weight: bold;">Vacantes: </label><label id="lblvacantes"> </label> <br>
                        <label style="font-weight: bold;">Fecha de publicacion: ‎</label><label id="lblfecha"> </label> <br>

                    </div>
                    <div id="columna2">
                        <label style="font-weight: bold;">Ubicacion: </label><label id="lblubicacion"> </label> <br>
                        <label style="font-weight: bold;">Horario: </label><label id="lblhorario"> </label> <br>
                        <label style="font-weight: bold;">Duracion contrato: </label><label id="lblcontrato"> </label> <br>
                        <label style="font-weight: bold;">Salario: ‎₡</label><label id="lblsalario"> </label> <br>
                    </div>
                </div>
                <div id="contenedorrequisitos">
                    <label for="">Requisitos:</label>
                </div>
                <div id="contenedorcategorias">
                    <label for="">Categorias:</label>

                </div>


            </div>
            <div id="contenedorcantaplicantes">
                <label for="">Numero de aplicantes: </label><label id="lblcantidadaplicantes"></label>
            </div>
            <div class='contenedorbotonesmodal'>
                <input type="button" value="Cerrar" class="btnconestilo" id="btncancelarmodal" onclick="cerrarmodal()">
                <input type="button" value="Remover aplicacion" class="btnconestilo" id="btnremoveraplicacion" onclick="removeraplicacion()">
            </div>
        </div>
    </div>
</body>

</html>