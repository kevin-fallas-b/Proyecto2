<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mi Curriculum - Sirhena</title>
    <link rel="stylesheet" type="text/css" href="{{ url('/css/style.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ url('/css/curriculum.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ url('/css/alertify.min.css') }}" />

    <script src="{{ url('/js/alertify.min.js')}}"></script>
    <script src="{{ url('/js/general.js')}}"></script>
    <script src="{{ url('/js/axios.min.js')}}"></script>
    <script src="{{ url('/js/curriculum.js')}}"></script>

    <link rel="icon" href="{{ url('/img/favicon.png') }}" type="image/x-icon">

</head>


<body>
    <div id="barranavegacion" class="barranavegacion">
        <label id='sirhena'>MI CURRICULUM</label>
        <img src="{{url('/img/sirhena.png')}}" alt="" class="imagensirhena" id="logosirhena">
        <div id="botonesbarra" class="botonesbarra">
            <?php

            use Illuminate\Support\Facades\URL;

            session_start();
            if (isset($_SESSION['user'])) {
                if ($_SESSION['user']->tipo == 2) {
                    //es un perfil de una empresa, nada tiene que estar haciendo aqui
                    header('Location: ' . URL::to('/sinpermisos'), true, 302);
                }
                echo '<label id="mensajebienvenida"> Bienvenido ' . $_SESSION['user']->nombre . '</label>';
                echo '<a href="' . URL::to('/miperfil') . '" class="textobotonbarra" >Mi Perfil</a>';
                echo '<a href="' . URL::to('/aplicaciones') . '" class="textobotonbarra" >Mis Aplicaciones</a>';
                echo '<a href="' . URL::to('/reportes') . '" class="textobotonbarra" >Reportes</a>';
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
        <form id="generarreporte" action="/reporte/curriculum" method="POST" target="_blank" hidden>
            {{csrf_field()}}
            <input type="text" id="cedula" name="cedula" value="<?php echo $_SESSION['user']->cedula ?>">
        </form>
        <input type="submit" form="generarreporte" value="Generar Reporte" class="btnconestilo" id="btngenerarreporte">
        <div id="contenedortitulos" class="contenedor">
            <div class="lblcontenedor">
                <label>Titulos</label>
            </div>
            <input type="button" name="" class="btnconestilo agregar" value="Agregar" id="btnagregartitulo">


            <?php
            for ($i = 0; $i < sizeof($_SESSION['titulosuser']); $i++) {
                echo '<div class="detallecontenedor titulo" id="' . $_SESSION['titulosuser'][$i]->id . '">';
                echo '<label style="font-weight:bold">Titulo: </label><label class="lbltitulo">' . $_SESSION['titulosuser'][$i]->titulo . '</label><br>';
                echo '<label style="font-weight:bold">Especialidad: </label><label class="lblespecialidad">' . $_SESSION['titulosuser'][$i]->especialidad . '</label><br>';
                echo '<label style="font-weight:bold">Institucion: </label><label class="lblinstitucion">' . $_SESSION['titulosuser'][$i]->institucion . '</label><br>';
                echo '<label style="font-weight:bold">Obtencion: </label><label class="lblobtencion">' . $_SESSION['titulosuser'][$i]->mes . '/' . $_SESSION['titulosuser'][$i]->ano . '</label>';
                echo '<br><input type="button" name=""  class="btnconestilo" value="Editar" onclick="editartitulo(' . $_SESSION['titulosuser'][$i]->id . ')">';
                echo '<input type="button" name=""  class="btnconestilo eliminar" value="Eliminar" onclick="eliminartitulo(' . $_SESSION['titulosuser'][$i]->id . ')">';
                echo '</div>';
            }

            ?>


        </div>
        <div id="contenedorexperiencias" class="contenedor">
            <div class="lblcontenedor">
                <label>Experiencias Profesionales</label>

            </div>
            <input type="button" name="" class="btnconestilo agregar" value="Agregar" id="btnagregarexperiencia">
            <?php
            for ($i = 0; $i < sizeof($_SESSION['experienciasuser']); $i++) {
                echo '<div class="detallecontenedor experiencia" id="' . $_SESSION['experienciasuser'][$i]->id . '">';
                echo '<label style="font-weight:bold">Empresa: </label><label class="lblempresa">' . $_SESSION['experienciasuser'][$i]->empresa . '</label><br>';
                echo '<label style="font-weight:bold">Puesto: </label><label class="lblpuesto">' . $_SESSION['experienciasuser'][$i]->puesto . '</label><br>';
                echo '<label style="font-weight:bold">Fecha de inicio: </label><label class="lblfechainicio">' . $_SESSION['experienciasuser'][$i]->fecha_ini . '</label><br>';
                echo '<label style="font-weight:bold">Fecha de salida: </label><label class="lblfechafin">' . $_SESSION['experienciasuser'][$i]->fecha_fin . '</label><br>';
                echo '<label style="font-weight:bold">Responsabilidades: </label><label class="lblresponsabilidades">' . $_SESSION['experienciasuser'][$i]->desc_responsa . '</label>';
                echo '<br><input type="button" name=""  class="btnconestilo" value="Editar" onclick="editarexperiencia(' . $_SESSION['experienciasuser'][$i]->id . ')">';
                echo '<input type="button" name=""  class="btnconestilo eliminar" value="Eliminar" onclick="eliminarexperiencia(' . $_SESSION['experienciasuser'][$i]->id . ')">';
                echo '</div>';
            }

            ?>
        </div>
        <div id="contenedormeritos" class="contenedor">
            <div class="lblcontenedor">
                <label>Meritos u observaciones</label>
            </div>
            <input type="button" name="" class="btnconestilo agregar" value="Agregar" id="btnagregarobservacion">
            <?php
            for ($i = 0; $i < sizeof($_SESSION['meritosuser']); $i++) {
                echo '<div class="detallecontenedor merito" id="' . $_SESSION['meritosuser'][$i]->id . '">';
                echo '<label class="descmerito">' . $_SESSION['meritosuser'][$i]->descripcion . '</label><br>';
                echo '<br><input type="button" name=""  class="btnconestilo" value="Editar" onclick="editarobservacion(' . $_SESSION['meritosuser'][$i]->id . ')">';
                echo '<input type="button" name=""  class="btnconestilo eliminar" value="Eliminar" onclick="eliminarobservacion(' . $_SESSION['meritosuser'][$i]->id . ')">';
                echo '</div>';
            }

            ?>
        </div>

    </div>





    <!-- Modal Section -->

    <div class="bg-modal" id="modaltitulonuevo">
        <div class="modal-contents">
            <input type="button" name="" id="" class="close" value="+" onclick="cerrar('modaltitulonuevo')">
            <div class="contenedortitulomodal">
                <label id='lblregistrareditartitulo'>Registrar Titulo</label>
            </div>
            <div class='contenedoropcionesmodal'>
                <label for="">Titulo: </label><input type="text" name="" id="txttitulo" placeholder="Titulo" class="cajatexto"><br>
                <label for="">Especialidad: </label><input type="text" name="" id="txtespecialidad" placeholder="Especialidad" class="cajatexto"><br>
                <label for="">Institucion: </label><input type="text" name="" id="txtinsitucion" placeholder="institucion" class="cajatexto"><br>
                <label for="">Obtencion: </label><select name="mesobtencion" id="mesobtencion">
                    <option value="-mes-">- Mes -</option>
                    <option value="01">Enero</option>
                    <option value="02">Febrero</option>
                    <option value="03">Marzo</option>
                    <option value="04">Abril</option>
                    <option value="05">Mayo</option>
                    <option value="06">Junio</option>
                    <option value="07">Julio</option>
                    <option value="08">Agosto</option>
                    <option value="09">Septiembre</option>
                    <option value="010">Octubre</option>
                    <option value="011">Noviembre</option>
                    <option value="012">Diciembre</option>
                </select>
                </select><select name="anoobtencion" id="anoobtencion">
                    <option value="-Ano-">- Año -</option>
                    <option value="2021">2021</option>
                    <option value="2020">2020</option>
                    <option value="2019">2019</option>
                    <option value="2018">2018</option>
                    <option value="2017">2017</option>
                    <option value="2016">2016</option>
                    <option value="2015">2015</option>
                    <option value="2014">2014</option>
                    <option value="2013">2013</option>
                    <option value="2012">2012</option>
                    <option value="2011">2011</option>
                    <option value="2010">2010</option>
                    <option value="2009">2009</option>
                    <option value="2008">2008</option>
                    <option value="2007">2007</option>
                    <option value="2006">2006</option>
                    <option value="2005">2005</option>
                    <option value="2004">2004</option>
                    <option value="2003">2003</option>
                    <option value="2002">2002</option>
                    <option value="2001">2001</option>
                    <option value="2000">2000</option>
                    <option value="1999">1999</option>
                    <option value="1998">1998</option>
                    <option value="1997">1997</option>
                    <option value="1996">1996</option>
                    <option value="1995">1995</option>
                    <option value="1994">1994</option>
                    <option value="1993">1993</option>
                    <option value="1992">1992</option>
                    <option value="1991">1991</option>
                    <option value="1990">1990</option>
                    <option value="1989">1989</option>
                    <option value="1988">1988</option>
                    <option value="1987">1987</option>
                    <option value="1986">1986</option>
                    <option value="1985">1985</option>
                    <option value="1984">1984</option>
                    <option value="1983">1983</option>
                    <option value="1982">1982</option>
                    <option value="1981">1981</option>
                    <option value="1980">1980</option>
                    <option value="1979">1979</option>
                    <option value="1978">1978</option>
                    <option value="1977">1977</option>
                    <option value="1976">1976</option>
                    <option value="1975">1975</option>
                    <option value="1974">1974</option>
                    <option value="1973">1973</option>
                    <option value="1972">1972</option>
                    <option value="1971">1971</option>
                    <option value="1970">1970</option>
                    <option value="1969">1969</option>
                    <option value="1968">1968</option>
                    <option value="1967">1967</option>
                    <option value="1966">1966</option>
                    <option value="1965">1965</option>
                    <option value="1964">1964</option>
                    <option value="1963">1963</option>
                    <option value="1962">1962</option>
                    <option value="1961">1961</option>
                    <option value="1960">1960</option>
                    <option value="1959">1959</option>
                    <option value="1958">1958</option>
                    <option value="1957">1957</option>
                    <option value="1956">1956</option>
                    <option value="1955">1955</option>
                    <option value="1954">1954</option>
                    <option value="1953">1953</option>
                    <option value="1952">1952</option>
                    <option value="1951">1951</option>
                    <option value="1950">1950</option>
                </select>
            </div>

            <div class='contenedorbotonesmodal'>
                <input type="button" value="Cancelar" class="btnconestilo" id="btncancelarmodal" onclick="cerrar('modaltitulonuevo')">
                <input type="button" value="Guardar" class="btnconestilo" id="btnguardartitulomodal">
            </div>
        </div>
    </div>

    <div class="bg-modal" id="modalexperiencianuevo">
        <div class="modal-contents">
            <input type="button" name="" id="" class="close" value="+" onclick="cerrar('modalexperiencianuevo')">
            <div class="contenedortitulomodal">
                <label id='lblregistrareditarexperiencia'>Registrar Experiencia</label>
            </div>
            <div class='contenedoropcionesmodal'>
                <label for="">Empresa: </label><input type="text" name="" id="txtempresa" placeholder="Empresa" class="cajatexto"><br>
                <label for="">Puesto: </label><input type="text" name="" id="txtpuesto" placeholder="Puesto" class="cajatexto"><br>
                <label for="">Fecha de ingreso: </label><input type="date" name="" id="fechaingreso"> <br>
                <label for="">Fecha de salida: </label><input type="date" name="" id="fechasalida"><br>
                <label for="">Responsabilidades: </label><br>
                <textarea class="cajatexto" name="" id="txtresponsabilidades" cols="150" rows="3" style="width: 487px; height: 40px;"></textarea>

            </div>

            <div class='contenedorbotonesmodal'>
                <input type="button" value="Cancelar" class="btnconestilo" id="btncancelarmodal" onclick="cerrar('modalexperiencianuevo')">
                <input type="button" value="Guardar" class="btnconestilo" id="btnguardarexperienciamodal">
            </div>
        </div>
    </div>

    <div class="bg-modal" id="modalobservacionnuevo">
        <div class="modal-contents">
            <input type="button" name="" id="" class="close" value="+" onclick="cerrar('modalobservacionnuevo')">
            <div class="contenedortitulomodal">
                <label id='lblregistrareditarmerito'>Registrar Merito u observacion</label>
            </div>
            <div class='contenedoropcionesmodal'>
                <label for="">Merito U Observacion: </label><br>
                <textarea class="cajatexto" name="" id="txtmerito" cols="150" rows="10"></textarea>
            </div>

            <div class='contenedorbotonesmodal'>
                <input type="button" value="Cancelar" class="btnconestilo" id="btncancelarmodal" onclick="cerrar('modalobservacionnuevo')">
                <input type="button" value="Guardar" class="btnconestilo" id="btnguardarobservacionmodal">
            </div>
        </div>
    </div>



    <!-- Modal General para la eliminacion si o que -->
    <div class="bg-modal" id="modaleliminar">
        <div class="modal-contents">
            <input type="button" name="" id="" class="close" value="+" onclick="cerrar('modaleliminar')">
            <div class="contenedortitulomodal">
                <label id='lbleliminar'>Eliminar Elemento</label>
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