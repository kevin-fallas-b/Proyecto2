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
    <script src="{{ url('/js/axios.min.js')}}"></script>

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
                <input type="button" name="" id="btnbuscarimagen" class="btnconestilo" value="Buscar imagen" hidden>
                <input type="file" name="txt_file" size="20" class="btn btn-info" id="escogerimagen" hidden accept="image/jpeg,image/gif,image/png" >
                <?php
                if ($_SESSION['user']->tipo == 1) {
                    echo ' <label for="" id="lbltipodecuenta">Tipo de cuenta: Personal</label>';
                } else {
                    echo ' <label for="" id="lbltipodecuenta">Tipo de cuenta: Empresarial</label>';
                }
                ?>
            </div>
            <!--este contenedor pasa oculto, solo se muestra cuando el usuario le da click a editar informacion personal -->
            <div id="contenedoreditar" class="ocultar" hidden>
                <label for="" id="lblinfopersonal">Informacion Personal:</label>
                <div id="columna1" class="columna">
                    <?php
                    if ($_SESSION['user']->tipo == 1) {
                        echo "<label id='cedula'>Cedula: " . $_SESSION['user']->cedula . "</label> <br>";
                    } else {
                        echo "<label id='cedula'>Cedula Juridica: " . $_SESSION['user']->cedula . "</label> <br>";
                    }

                    echo '<label> Nombre: </label><input type="text" placeholder="Nombre" class="cajatexto" id="campoeditarnombre"><br>';
                    if ($_SESSION['user']->tipo == 1) {
                        echo ' <label> Apellidos: </label> <input type="text" placeholder="Apellidos" class="cajatexto" value="" id="campoeditarapellidos">';
                    }

                    echo '<br><label> Contraseña: </label><input type="password" placeholder="Contraseña" class="cajatexto" id="campoeditarcontra"><br>';

                    ?>
                    
                </div>
                <div id="columna2editando" class="columna">
                    <label>Telefono: </label><input type="text" placeholder="Telefono" class="cajatexto" id="campoeditartelefono" onkeypress="return isNumber(event)"><br>
                    <label>Correo:</label><input type="text" placeholder="Correo" class="cajatexto" value="" id="campoeditarcorreo"><br>
                    <label>Direccion: </label><input type="text" placeholder="Direccion" class="cajatexto" value="" id="campoeditardireccion"><br>
                    <label> Confirmar Contraseña: </label><input type="password" placeholder="Confirmar Contraseña" class="cajatexto" id="campoeditarconfircontra"><br>
                </div>
                <input type="button" value="cancelar" id="btncancelar" class="btnconestilo">
                <input type="button" value="Guardar" id="btnguardar" class="btnconestilo">

            </div>

            <!-- este div solo tiene labels con la informacion del usuario -->
            <div id="informacionpersonal">
                <label for="" id="lblinfopersonal">Informacion Personal:</label>
                <div id="columna1" class="columna">
                    <?php
                    if ($_SESSION['user']->tipo == 1) {
                        echo ' <label id="tipouser" hidden>1</label>'; 
                        echo "<label id='cedula'>Cedula: <label id='cedulauser'>" . $_SESSION['user']->cedula . "</label> <br><br>";
                    } else {
                        echo ' <label id="tipouser" hidden>2</label>';
                        echo "<label id='cedula'>Cedula Juridica:  <label id='cedulauser'>" . $_SESSION['user']->cedula . "</label> <br><br>";
                    }
                    echo "<label id='cedula'>Nombre:  <label id='nombreuser'>" . $_SESSION['user']->nombre . "</label> <br><br>";
                    if ($_SESSION['user']->tipo == 1) {
                        echo "<label id='cedula'>Apellidos:  <label id='apellidosuser'>" . $_SESSION['user']->apellido . "</label><br><br>";
                    }
                    ?>
                </div>
                <div id="columna2" class="columna">
                    <?php
                    echo "<label>Telefono: </label> <label id='telefonouser'>" . $_SESSION['user']->telefono . "</label><br><br>";
                    echo "<label>Correo: <label id='correouser'>" . $_SESSION['user']->correo . "</label><br><br>";
                    echo "<label>Direccion: <label id='direccionuser'>" . $_SESSION['user']->direccion . "</label><br><br>";
                    ?>
                </div>
                <input type="button" value="Editar" id="btneditar" class="btnconestilo" >
            </div>

            <!-- DIV que esta debajo de informacion personal, si es persona muestra los titulos registrados, si es empresa muestra ofertas publicadas -->
            <div id="tituloofertas">
                <?php
                if ($_SESSION['user']->tipo == 1) {
                    echo '<label for="" id="lbltituloofertas">Mi Curriculum:</label>';
                } else {
                    echo '<label for="" id="lbltituloofertas">Mis Ofertas:</label>';
                }
                echo '<div id="contenedorbloques">';

                if ($_SESSION['user']->tipo == 1) {
                    //llenar con informacion de titulo o experiencia
                    if (sizeof($_SESSION['titulosuser']) > 2) {
                        //3 bloques con titulos
                        for ($i = 0; $i < 3; $i++) {
                            echo ' <div class="bloque" id="bloque' . ($i + 1) . '"> ';
                            echo '<br><label for="">Titulo: ' . $_SESSION['titulosuser'][$i]->titulo . '</label><br><br>';
                            echo '<label for="" >Especialidad: ' . $_SESSION['titulosuser'][$i]->especialidad . '</label><br><br>';
                            echo '<label for="" >Institucion: ' . $_SESSION['titulosuser'][$i]->institucion . '</label><br><br>';
                            echo '<label for="">Obetenido: ' . $_SESSION['titulosuser'][$i]->mes . '/' . $_SESSION['titulosuser'][$i]->ano . '</label><br>';
                            echo '</div> ';
                        }
                    } else {
                        //no tenemos 3 titulos, mostrar los que hayan y si es posible, meter una experiencia
                        for ($i = 0; $i < sizeof($_SESSION['titulosuser']); $i++) {
                            echo ' <div class="bloque" id="bloque' . ($i + 1) . '"> ';
                            echo '<br><label for="" class="titulotitulo">Titulo: ' . $_SESSION['titulosuser'][$i]->titulo . '</label><br><br>';
                            echo '<label for="">Especialidad: ' . $_SESSION['titulosuser'][$i]->especialidad . '</label><br><br>';
                            echo '<label for="">Institucion: ' . $_SESSION['titulosuser'][$i]->institucion . '</label><br><br>';
                            echo '<label for="">Obetenido: ' . $_SESSION['titulosuser'][$i]->mes . '/' . $_SESSION['titulosuser'][$i]->ano . '</label><br>';
                            echo '</div> ';
                        }
                        for ($i = 0; $i < (3 - sizeof($_SESSION['titulosuser'])); $i++) {
                            if ($_SESSION['experienciasuser'][$i] != null) {
                                echo '<div class="bloque" id="bloque3">';
                                echo  '<br><label for="" >Empresa: ' . $_SESSION['experienciasuser'][$i]->empresa . '</label><br><br>';
                                echo '<label for="" >Puesto: ' . $_SESSION['experienciasuser'][$i]->puesto . '</label><br><br>';
                                echo '<label for="" >Fecha de ingreso: ' . $_SESSION['experienciasuser'][$i]->fecha_ini . '</label><br>';
                                echo '<label for="" >Fecha de salida: ' . $_SESSION['experienciasuser'][$i]->fecha_fin . '</label><br><br>';
                                echo  '<label for="" >Responsabilidades: ' . $_SESSION['experienciasuser'][$i]->desc_responsa . '</label><br>';
                                echo '</div>';
                            }
                        }
                    }
                } else {
                    for ($i = 0; $i < sizeof($_SESSION['ofertasuser']); $i++) {
                        //mostrar ofertas, pero maximo 3
                        if ($i == 2) {
                            break;
                        }
                    }
                }

                ?>
            </div>

        </div>
    </div>
</body>

</html>