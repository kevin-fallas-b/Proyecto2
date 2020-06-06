<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro</title>
    <link rel="stylesheet" type="text/css" href="{{ url('/css/style.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ url('/css/registro.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ url('/css/alertify.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ url('/css/materialize.min.css') }}" />
    <script src="{{ url('/js/registro.js')}}"></script>
    <script src="{{ url('/js/alertify.min.js')}}"></script>
    <script src="{{ url('/js/materialize.min.js')}}"></script>
    <link rel="icon" href="{{ url('/img/favicon.png') }}" type="image/x-icon">

</head>

<body>

    <div id="barranavegacion" class="barranavegacion">
        <img src="{{url('/img/sirhena.png')}}" alt="" class="imagensirhena">
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
                <br>
                <input type="radio" id="rbpersona" name="tipo" value="1" selected>Persona</label>
                <input type="radio" id="rbempresa" name="tipo" value="2">Empresa</label>
            </div>

            <div class="row">
                <form class="col s12">
                    <div class="row">

                        <div class="input-field col s6">
                            <input id="txtnombre" type="text" class="validate">
                            <label for="txtnombre">Nombre</label>
                        </div>

                        <div class="input-field col s6">
                            <input id="last_name" type="text" class="validate">
                            <label for="last_name">Apellidos</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s6">
                            <input id="contra" type="password" class="validate">
                            <label for="contra">Contraseña</label>
                        </div>
                        <div class="input-field col s6">
                            <input id="confirmarcontra" type="password" class="validate">
                            <label for="confirmarcontra">Confirmar Contraseña</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="direccion" type="text" class="validate">
                            <label for="direccion">Direccion</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s6">
                            <input id="telefono" type="text" class="validate">
                            <label for="telefono">Telefono</label>
                        </div>
                        <div class="input-field col s6">
                            <input id="correo" type="text" class="validate">
                            <label for="correo">Correo</label>
                        </div>
                    </div>
                </form>
            </div>




        </div>
    </div>
    </div>

</html>