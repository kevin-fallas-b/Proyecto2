<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro</title>
    <link rel="stylesheet" type="text/css" href="{{ url('/css/style.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ url('/css/registro.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ url('/css/alertify.min.css') }}" />
    <script src="{{ url('/js/registro.js')}}"></script>
    <script src="{{ url('/js/axios.min.js')}}"></script>
    <script src="{{ url('/js/alertify.min.js')}}"></script>
    <script src="{{ url('/js/general.js')}}"></script>
    <link rel="icon" href="{{ url('/img/favicon.png') }}" type="image/x-icon">

</head>

<body>

    <div id="barranavegacion" class="barranavegacion">
        <img src="{{url('/img/sirhena.png')}}" alt="" class="imagensirhena"  id="logosirhena">
        <div id="botonesbarra" class="botonesbarra">
            <a href="login" class="textobotonbarra">Log in</a>
            <a href="{{url('')}}" class="textobotonbarra">Pagina Principal</a>
        </div>
    </div>
    <div id="main">

        <label id='sirhena'>REGISTRO SIRHENA</label>
        <div id="contenedorgeneral">
            <div id="contenedortipo">
                <label for="">Quiero registrarme como una:</label>
                <input type="radio" id="rbpersona" name="tipo" value="1" checked>Persona</label>
                <input type="radio" id="rbempresa" name="tipo" value="2">Empresa</label>

            </div>

            <div id="contenedorcampos">
                <input type="text" name="txt_cedula" id="txt_cedula" placeholder="Cedula" title="Cedula" class="cajatexto" autocomplete="off" onkeypress="return isNumber(event)">
                <div>
                    <input type="text" name="txt_nombre" id="txt_nombre" placeholder="Nombre" title="Nombre" class="cajatexto" autocomplete="off">
                    <input type="text" name="txt_apellidos" id="txt_apellidos" placeholder="Apellidos" title="Apellidos" class="cajatexto" autocomplete="off">
                </div>

                <div>
                    <input type="text" name="txt_user" id="txt_user" placeholder="Nombre de usuario" title="Nombre de usuario" class="cajatexto" autocomplete="false">
                    <input type="text" name="txt_correo" id="txt_correo" placeholder="Correo" title="Correo" class="cajatexto" autocomplete="off">
                </div>

                <div>
                    <input type="password" name="txt_contra" id="txt_contra" placeholder="Contraseña" title="Contraseña" class="cajatexto" onkeyup="seguridadcontra()">
                    <input type="password" name="txt_confirmarcontra" id="txt_confirmarcontra" placeholder="Confirmar Contraseña" title="Confirmar Contraseña" class="cajatexto" onkeyup="contraconciden()">
                    <br>
                    <label for="" id="tipopass" hidden>No Aceptable</label>
                    <progress id='seguridadcontra' max='100' value="0" title='Seguridad de tu contraseña. Una contraseña segura contiene minisculas, mayusculas, numeros y signos especiales.'></progress>
                    <label id='contraconciden' hidden>Las contraseñas no coinciden.</label>
                </div>

                <div>
                    <input type="text" name="txt_direccion" id="txt_direccion" placeholder="Direccion" title="Direccion" class="cajatexto" autocomplete="off">
                    <input type="text" name="txt_telefono" id="txt_telefono" placeholder="Telefono" title="Telefono" class="cajatexto" autocomplete="off" onkeypress="return isNumber(event)">
                </div>

            </div>

            <div id="contenedorbotones">
                <input type="button" name="" id="btnlimpiar" class='boton' value="Limpiar Campos">
                <input type="button" name="" id="btnguardar" class='boton' value="Guardar">
            </div>
        </div>
    </div>
    </div>

</html>