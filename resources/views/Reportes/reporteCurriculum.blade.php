<!DOCTYPE html>

<html>

<head>
    <?php
    echo '<link rel="stylesheet" type="text/css" href="' . public_path() . '/css/reporte.css" >';
    ?>
</head>

<body>
    <?php
    echo '<img src="' . public_path() . '/img/sirhena.png" alt="Logo Sirhena" class="imagensirhena">';
    ?>
    <div id="contenedortitulos">
        <label id='titulo1'>Reporte Sirhena</label><br>
        <label id='titulo2'>Curriculum</label>

    </div>
    <div id="contenedorcandidato">
        <div id='candidato'>
            <label>Candidato</label><br>
        </div>

        <?php
        echo 'Nombre: <label>' . $_ENV['userreporte'][0]->nombre . ' ' . $_ENV['userreporte'][0]->apellido . '</label><br>';
        echo 'Cedula: <label>' . $_ENV['userreporte'][0]->cedula . '</label><br>';
        echo 'Telefono: <label>' . $_ENV['userreporte'][0]->telefono . '</label><br>';
        echo 'Correo: <label>' . $_ENV['userreporte'][0]->correo . '</label><br>';
        echo 'Direccion: <label>' . $_ENV['userreporte'][0]->direccion . '</label><br>';
        echo '<img src="' . public_path() . '/img/users/' . $_ENV['userreporte'][0]->foto . '" alt="Foto Candidato" class="fotocandidato">';
        ?>

        <div id='candidato' style="margin-top: 10px;">
            <label>Titulos</label><br>
        </div>
    </div>
    <?php
    //el valor que sigue despues de apps es la aplicacion, el numero despues de empresa siempre va a ser 0, y despues de 
    //requisitos o categorias es variable
    // para ver cosas de la empresa $_ENV['apps'][0]['empresa'][0]->nombre);
    // para ver cosas de requisitos $_ENV['apps'][0]['requisitos'][0]->Descripcion


    for ($i = 0; $i < sizeof($_ENV['titulosreporte']); $i++) {
        echo '<div class="detallecontenedor ">';
        echo '<label class="contador">' . ($i + 1) . '</label>';
        echo '<div class="contenedoroferta">';
        echo '<label>Titulo: </label><label>' . $_ENV['titulosreporte'][$i]->titulo . '</label><br>';
        echo '<label>especialidad: </label><label>' . $_ENV['titulosreporte'][$i]->especialidad . '</label><br>';
        echo '<label>Institucion: </label><label>' . $_ENV['titulosreporte'][$i]->institucion . '</label><br>';
        echo '<label>Obtencion: </label><label clas>' . $_ENV['titulosreporte'][$i]->mes . '/' . $_ENV['titulosreporte'][$i]->ano . '</label><br>';
        echo '</div><br>';
        echo '</div>';
    }
    ?>
    <div id='candidato' style="margin-top: 10px; border-bottom: 2px solid black; padding-bottom: 10px;">
        <label >Experiencias</label><br>
    </div>
    <?php
    for ($i = 0; $i < sizeof($_ENV['experienciasreporte']); $i++) {
        echo '<div class="detallecontenedor ">';
        echo '<label class="contador">' . ($i + 1) . '</label>';
        echo '<div class="contenedoroferta">';
        echo '<label>Empresa: </label><label>' . $_ENV['experienciasreporte'][$i]->empresa . '</label><br>';
        echo '<label>Puesto: </label><label>' . $_ENV['experienciasreporte'][$i]->puesto . '</label><br>';
        echo '<label>Fecha de inicio: </label><label>' . $_ENV['experienciasreporte'][$i]->fecha_ini . '</label><br>';
        echo '<label>Fecha de salida: </label><label>' . $_ENV['experienciasreporte'][$i]->fecha_fin . '</label><br>';
        echo '<label>Responsabilidades: </label><label clas>' . $_ENV['experienciasreporte'][$i]->desc_responsa . '</label><br>';
        echo '</div><br>';
        echo '</div>';
    }


    ?>
    <div id='candidato' style="margin-top: 10px; border-bottom: 2px solid black; padding-bottom: 10px;">
        <label >Meritos</label><br>
    </div>
    <?php
    for ($i = 0; $i < sizeof($_ENV['meritosreporte']); $i++) {
        echo '<div class="detallecontenedor ">';
        echo '<label class="contador">' . ($i + 1) . '</label>';
        echo '<div class="contenedoroferta">';
        echo '<label>Descripcion: </label><label>' . $_ENV['meritosreporte'][$i]->descripcion . '</label><br>';
        echo '</div><br>';
        echo '</div>';
    }
    ?>
</body>

</html>