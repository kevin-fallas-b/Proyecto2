<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sirhena</title>
    <link rel="stylesheet" type="text/css" href="{{ url('/css/style.css') }}" />

    <link rel="icon" href="{{ url('/img/favicon.png') }}" type="image/x-icon">

</head>

<body>


    <div id="barranavegacion" class="barranavegacion">
        <label id='sirhena'>SIRHENA</label>
        <img src="{{url('/img/sirhena.png')}}" alt="" class="imagensirhena" id="logosirhena">

    </div>
    <div id="main">
        <h1 id="nologeado"> Usted no se encuentra autenticado en el sitio.</h1>
        <h2 id="cerrosession2"> Espere y pronto sera redireccionado.</h2>
    </div>
    <?php

    use Illuminate\Support\Facades\URL;

    echo '<a href="' . URL::to('/login') . '" id="sinadasucede">Si nada sucede presione aqui.</a>';
    header('Refresh: 3; URL=' . URL::to('/login'));
    ?>
</body>

</html>