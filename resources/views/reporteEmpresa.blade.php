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
		<label id='titulo2'>Empresa</label>

	</div>
	<div id="contenedorcandidato">
		<div id='candidato'>
			<label>Empresa</label><br>
        </div>
        
        <?php
		echo 'Nombre: <label>' . $_ENV['empresareporte'][0]->nombre .'</label><br>';
		echo 'Cedula Juridica: <label>' . $_ENV['empresareporte'][0]->cedula . '</label><br>';
		echo 'Telefono: <label>' . $_ENV['empresareporte'][0]->telefono . '</label><br>';
		echo 'Correo: <label>' . $_ENV['empresareporte'][0]->correo . '</label><br>';
		echo 'Ubicacion: <label>' . $_ENV['empresareporte'][0]->direccion . '</label>';
        ?>
        
        <div id='candidato' style="margin-top: 10px;">
			<label>Ofertas de la Empresa</label><br>
        </div>
	</div>
	<?php
	//el valor que sigue despues de apps es la aplicacion, el numero despues de empresa siempre va a ser 0, y despues de 
	//requisitos o categorias es variable
	// para ver cosas de la empresa $_ENV['apps'][0]['empresa'][0]->nombre);
	// para ver cosas de requisitos $_ENV['apps'][0]['requisitos'][0]->Descripcion
    
    
    for ($i = 0; $i < sizeof($_ENV['ofertasreporte']); $i++) {
		echo '<div class="detallecontenedor hijoshorizontal ">';
		echo '<label class="contador">' . ($i + 1) . '</label>';
		echo '<div class="contenedoroferta">';
		echo '<div class="lblcontenedordetalle">';
		echo '<label>Puesto</label>';
		echo '</div>';
		echo '<label>Descripcion: </label><label class="descripcionoferta">' . $_ENV['ofertasreporte'][$i]->descripcion . '</label><br>';
		echo '<label>Vacantes: </label><label class="vacantesoferta">' . $_ENV['ofertasreporte'][$i]->numero_vacantes . '</label><br>';
		echo '<label>Ubicacion: </label><label class="ubicacionoferta">' . $_ENV['ofertasreporte'][$i]->ubicacion . '</label><br>';
		echo '<label>Salario: </label><label class="salariooferta">' . number_format($_ENV['ofertasreporte'][$i]->salario, 2, '.', ',') . '</label><br>';
		echo '<label>Horario: </label><label class="horariooferta">' . $_ENV['ofertasreporte'][$i]->horario . '</label><br>';
		echo '<label>Duracion: </label><label class="duracionoferta">' . $_ENV['ofertasreporte'][$i]->duracion . '</label><br>';
		echo '<label>Fecha de publicacion: </label><label class="fechaoferta">' . $_ENV['ofertasreporte'][$i]->fecha . '</label><br>';
		echo '</div><br>';
		echo '<div class="contenedorrequisitos" >';
		//aqui van requisitos
		echo '<div class="lblcontenedordetalle">';
		echo '<label>Requisitos</label>';
		echo '</div>';
		for ($k = 0; $k < sizeof($_ENV['ofertasreporte'][$i]->requisitos); $k++) {
			echo '<label class="requisito">' . $_ENV['ofertasreporte'][$i]->requisitos[$k]->Descripcion . '</label><br>';
		}
		echo '</div><br>';
		echo '<div class="contenedorcategorias">';
		//aqui van categorias
		echo '<div class="lblcontenedordetalle">';
		echo '<label>Categorias</label>';
		echo '</div>';
		for ($k = 0; $k < sizeof($_ENV['ofertasreporte'][$i]->categorias); $k++) {
			echo '<label>' . $_ENV['ofertasreporte'][$i]->categorias[$k]->nombre . '</label><br>';
		}
		echo '</div>';
		echo '</div>';
	}
	?>
</body>

</html>