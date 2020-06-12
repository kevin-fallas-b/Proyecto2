<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mis Ofertas - Sirhena</title>
    <link rel="stylesheet" type="text/css" href="{{ url('/css/style.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ url('/css/ofertas.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ url('/css/alertify.min.css') }}" />

    <script src="{{ url('/js/alertify.min.js')}}"></script>
    <script src="{{ url('/js/general.js')}}"></script>
    <script src="{{ url('/js/ofertas.js')}}"></script>
    <script src="{{ url('/js/axios.min.js')}}"></script>

    <link rel="icon" href="{{ url('/img/favicon.png') }}" type="image/x-icon">

</head>


<body>
    <div id="barranavegacion" class="barranavegacion">
        <label id='sirhena'>MIS OFERTAS</label>
        <img src="{{url('/img/sirhena.png')}}" alt="" class="imagensirhena" id="logosirhena">
        <div id="botonesbarra" class="botonesbarra">
            <?php

            use Illuminate\Support\Facades\URL;

            session_start();
            if (isset($_SESSION['user'])) {
                if ($_SESSION['user']->tipo == 1) {
                    //es un perfil de un empleado, nada tiene que estar haciendo aqui
                    header('Location: ' . URL::to('/sinpermisos'), true, 302);
                }
                echo '<label id="mensajebienvenida"> Bienvenido ' . $_SESSION['user']->nombre . '</label>';
                echo '<a href="' . URL::to('/miperfil') . '" class="textobotonbarra" >Mi Perfil</a>';
                echo '<a href="' . URL::to('/') . '" class="textobotonbarra" >Pagina Principal</a>';
                echo '<a href="' . URL::to('/logout') . '" class="textobotonbarra">Cerrar Session</a>';
                echo '<label hidden id="cedulauser">' . $_SESSION['user']->cedula . '</label>';
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
        <div id="contenedorcategorias" class="contenedor">
            <div class="lblcontenedor">
                <label>Mis Categorias</label>
            </div>
            <input type="button" name="" class="btnconestilo agregar" value="Agregar" id="btnagregarcategoria">
            <?php
            for ($i = 0; $i < sizeof($_SESSION['categoriasuser']); $i++) {
                echo '<div class="detallecontenedor " id="' . $_SESSION['categoriasuser'][$i]->id . '">';
                echo '<label class="nombrecategoria">' . $_SESSION['categoriasuser'][$i]->nombre . '</label><br>';
                echo '<input type="button" name=""  class="btnconestilo eliminar" value="Eliminar" onclick="eliminarcategoria(' . $_SESSION['categoriasuser'][$i]->id . ')">';
                echo '</div>';
            }

            ?>

        </div>
        <div id="contenedorofertas" class="contenedor">
            <div class="lblcontenedor">
                <label>Ofertas Laborales</label>
            </div>
            <input type="button" name="" class="btnconestilo agregar" value="Agregar" id="btnagregaroferta">
            <?php
            for ($i = 0; $i < sizeof($_SESSION['ofertasuser']); $i++) {
                echo '<div class="detallecontenedor hijoshorizontal " id="' . $_SESSION['ofertasuser'][$i]->id . '">';
                echo '<div class="contenedoroferta">';
                echo '<div class="lblcontenedordetalle">';
                echo '<label>Puesto</label>';
                echo '</div>';
                echo '<label>Descripcion: </label><label class="descripcionoferta">' . $_SESSION['ofertasuser'][$i]->descripcion . '</label><br>';
                echo '<label>Vacantes: </label><label class="vacantesoferta">' . $_SESSION['ofertasuser'][$i]->numero_vacantes . '</label><br>';
                echo '<label>Ubicacion: </label><label class="ubicacionoferta">' . $_SESSION['ofertasuser'][$i]->ubicacion . '</label><br>';
                echo '<label>Salario: ‎₡</label><label class="salariooferta">' . $_SESSION['ofertasuser'][$i]->salario . '</label><br>';
                echo '<label>Horario: </label><label class="horariooferta">' . $_SESSION['ofertasuser'][$i]->horario . '</label><br>';
                echo '<label>Duracion: </label><label class="duracionoferta">' . $_SESSION['ofertasuser'][$i]->duracion . '</label><br>';
                echo '<label>Fecha: </label><label class="fechaoferta">' . $_SESSION['ofertasuser'][$i]->fecha . '</label><br>';
                echo '</div>';
                echo '<div class="contenedorrequisitos">';
                //aqui van requisitos
                echo '<div class="lblcontenedordetalle">';
                echo '<label>Requisitos</label>';
                echo '</div>';
                for ($k = 0; $k < sizeof($_SESSION['ofertasuser'][$i]->requisitos); $k++) {
                    echo '<label>' . $_SESSION['ofertasuser'][$i]->requisitos[$k]->Descripcion . '</label><label> : ' . $_SESSION['ofertasuser'][$i]->requisitos[$k]->tipo . '<br>';
                }
                echo '</div>';
                echo '<div class="contenedorcategorias">';
                //aqui van categorias
                echo '<div class="lblcontenedordetalle">';
                echo '<label>Categorias</label>';
                echo '</div>';
                for ($k = 0; $k < sizeof($_SESSION['ofertasuser'][$i]->categorias); $k++) {
                    echo '<label>' . $_SESSION['ofertasuser'][$i]->categorias[$k]->nombre . '</label><br>';
                }
                echo '</div>';
                echo '<input type="button" name=""  class="btnconestilo aplicantes" value="Ver Aplicantes" onclick="veraplicantes(' . $_SESSION['categoriasuser'][$i]->id . ')">';
                echo '<input type="button" name=""  class="btnconestilo editar" value="Editar" onclick="editarcategoria(' . $_SESSION['categoriasuser'][$i]->id . ')">';
                echo '<input type="button" name=""  class="btnconestilo eliminar" value="Eliminar" onclick="eliminarcategoria(' . $_SESSION['categoriasuser'][$i]->id . ')">';
                echo '</div>';
            }

            ?>
        </div>

    </div>





    <!-- Modal Section -->

    <div class="bg-modal" id="modalofertanueva">
        <div class="modal-contents" id="ofertanuevagrande">
            <input type="button" name="" id="" class="close" value="+" onclick="cerrar('modalofertanueva')">
            <div class="contenedortitulomodal">
                <label id='lblregistrareditarexperiencia'>Registrar Oferta</label>
            </div>
            <div class='contenedoropcionesmodal'>
                <label for="">Descripcion: </label><input type="text" name="" id="txtdescripcionoferta" placeholder="Descripcion" class="cajatexto">
                <label for="">Vacantes: </label><input type="text" name="" id="txtvacantesoferta" placeholder="Cantidad de vacantes" class="cajatexto" onkeypress="return isNumber(event)"><br>
                <label for="">Ubicacion: </label><input type="text" name="" id="txtubicacionoferta" placeholder="Ubicacion" class="cajatexto">
                <label for="">Horario: </label><input type="text" name="" id="txthorariooferta" placeholder="Horario" class="cajatexto"><br>
                <label for="">Duracion del contrato: </label><input type="text" name="" id="txtduracionoferta" placeholder="Duracion" class="cajatexto">
                <label for="">Salario: </label><input type="text" name="" id="txtsalariooferta" placeholder="Salario" class="cajatexto" onkeypress="return isNumber(event)"><br>
                <div id="contenedortagsoferta">
                    <label for="">Requisitos: </label><input type="text" name="" id="txtrequisitosoferta" placeholder="Requisitos" class="cajatexto"><br>
                </div>
            </div>

            <div class='contenedorbotonesmodal' id="botonesofertanueva">
                <input type="button" value="Cancelar" class="btnconestilo" id="btncancelarmodal" onclick="cerrar('modalofertanueva')">
                <input type="button" value="Guardar" class="btnconestilo" id="btnguardarcategoriamodal">
            </div>
        </div>
    </div>


    <div class="bg-modal" id="modalcategorianueva">
        <div class="modal-contents">
            <input type="button" name="" id="" class="close" value="+" onclick="cerrar('modalcategorianueva')">
            <div class="contenedortitulomodal">
                <label id='lblregistrareditarexperiencia'>Registrar Categoria</label>
            </div>
            <div class='contenedoropcionesmodal' id="contenedornombrecategoria">
                <label for="">Nombre: </label><input type="text" name="" id="txtnombrecategoria" placeholder="Nombre" class="cajatexto"><br>
            </div>

            <div class='contenedorbotonesmodal'>
                <input type="button" value="Cancelar" class="btnconestilo" id="btncancelarmodal" onclick="cerrar('modalcategorianueva')">
                <input type="button" value="Guardar" class="btnconestilo" id="btnguardarcategoriamodal">
            </div>
        </div>
    </div>



    <!-- Modal General para la eliminacion si o que -->
    <div class="bg-modal" id="modaleliminar">
        <div class="modal-contents">
            <input type="button" name="" id="" class="close" value="+" onclick="cerrar('modaleliminar')">
            <div class="contenedortitulomodal">
                <label id='lbleliminar'>Elimar Elemento</label>
            </div>
            <div class='contenedoropcionesmodal'>
                <br><br><br><label id="estaseguro"></label><br>

            </div>

            <div class='contenedorbotonesmodal'>
                <input type="button" value="Cancelar" class="btnconestilo" id="btncancelarmodal" onclick="cerrar('modaleliminar')">
                <input type="button" value="Eliminar" class="btnconestilo" id="btneliminarmodal">
            </div>
        </div>
    </div>
</body>

</html>