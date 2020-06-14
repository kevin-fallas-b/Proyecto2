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
        <label id='titulo2'>Ofertas por categoria</label>

    </div>
    <div id='candidato' style="margin-top: 10px; border-bottom: 2px solid black; padding-bottom: 10px;">
        <label>Categorias</label><br>
    </div>

    <?php

    for ($i = 0; $i < sizeof($_ENV['categoriasreporte']); $i++) {
        echo '<div class="detallecontenedor ">';
        echo '<label class="contador">' . ($i + 1) . '</label>';
        echo '<div class="contenedoroferta">';
        echo '<label>Categoria: </label><label>' . $_ENV['categoriasreporte'][$i]->nombre . '</label><br>';
    ?>
        <div id='candidato' style="margin-top: 10px; border-bottom: 2px solid black; padding-bottom: 10px;">
            <label>Ofertas</label><br>
        </div>
    <?php
        for ($k = 0; $k < sizeof($_ENV['categoriasreporte'][$i]->ofertas); $k++) {
            echo '<div class="contenedoroferta" style="border-bottom: 2px dotted black; padding-bottom:10px">';
            echo '<div class="lblcontenedordetalle">';
            echo '<label>Puesto</label>';
            echo '</div>';
            echo '<label>Descripcion: </label><label class="descripcionoferta">' . $_ENV['categoriasreporte'][$i]->ofertas[$k][0]->descripcion . '</label><br>';
            echo '<label>Vacantes: </label><label class="vacantesoferta">' . $_ENV['categoriasreporte'][$i]->ofertas[$k][0]->numero_vacantes . '</label><br>';
            echo '<label>Ubicacion: </label><label class="ubicacionoferta">' . $_ENV['categoriasreporte'][$i]->ofertas[$k][0]->ubicacion . '</label><br>';
            echo '<label>Salario: </label><label class="salariooferta">' . number_format($_ENV['categoriasreporte'][$i]->ofertas[$k][0]->salario, 2, '.', ',') . '</label><br>';
            echo '<label>Horario: </label><label class="horariooferta">' . $_ENV['categoriasreporte'][$i]->ofertas[$k][0]->horario . '</label><br>';
            echo '<label>Duracion: </label><label class="duracionoferta">' . $_ENV['categoriasreporte'][$i]->ofertas[$k][0]->duracion . '</label><br>';
            echo '<label>Fecha de publicacion: </label><label class="fechaoferta">' . $_ENV['categoriasreporte'][$i]->ofertas[$k][0]->fecha . '</label><br>';

            echo '<div class="contenedorrequisitos" >';
            //aqui van requisitos
            echo '<div class="lblcontenedordetalle">';
            echo '<br><label>Requisitos</label>';
            echo '</div>';
            for ($x = 0; $x < sizeof($_ENV['categoriasreporte'][$i]->ofertas[$k]['requisitos']); $x++) {
                echo '<label class="requisito">' . $_ENV['categoriasreporte'][$i]->ofertas[$k]['requisitos'][$x]->Descripcion . '</label><br>';
            }
            echo '</div><br>';
            echo '<div class="contenedorcategorias">';
            //aqui van categorias
            echo '<div class="lblcontenedordetalle">';
            echo '<label>Categorias</label>';
            echo '</div>';
            for ($n = 0; $n < sizeof($_ENV['categoriasreporte'][$i]->ofertas[$k]['categorias']); $n++) {
                echo '<label>' .$_ENV['categoriasreporte'][$i]->ofertas[$k]['categorias'][$n]->nombre . '</label><br>';
            }
            echo '</div>';
            echo '</div><br>';
            
        }
        echo '</div><br>';
        echo '</div>';
    }


    ?>

    <?php
    /*
    for ($i = 0; $i < sizeof($_ENV['meritosreporte']); $i++) {
        echo '<div class="detallecontenedor ">';
        echo '<label class="contador">' . ($i + 1) . '</label>';
        echo '<div class="contenedoroferta">';
        echo '<label>Descripcion: </label><label>' . $_ENV['meritosreporte'][$i]->descripcion . '</label><br>';
        echo '</div><br>';
        echo '</div>';
    }*/
    ?>
</body>

</html>