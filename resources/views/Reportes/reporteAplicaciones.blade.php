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
		<label id='titulo2'>Mis Aplicaciones</label>

	</div>
	<div id="contenedorcandidato">
		<div id='candidato'>
			<label>Candidato</label><br>
		</div>
		<?php
		session_start();
		echo 'Nombre: <label>' . $_SESSION['user']->nombre . ' '.$_SESSION['user']->apellido.'</label><br>';
		echo 'Cedula: <label>' . $_SESSION['user']->cedula . '</label><br>';
		echo 'Telefono: <label>' . $_SESSION['user']->telefono . '</label><br>';
		echo 'Correo: <label>' . $_SESSION['user']->correo . '</label>';
		?>
	</div>
	<?php
	//el valor que sigue despues de apps es la aplicacion, el numero despues de empresa siempre va a ser 0, y despues de 
	//requisitos o categorias es variable
	// para ver cosas de la empresa $_ENV['apps'][0]['empresa'][0]->nombre);
	// para ver cosas de requisitos $_ENV['apps'][0]['requisitos'][0]->Descripcion
	for ($i = 0; $i < sizeof($_ENV['apps']); $i++) {
		echo '<div class="detallecontenedor hijoshorizontal ">';
		echo '<label class="contador">' . ($i + 1) . '</label>';
		echo '<div class="contenedoroferta">';
		echo '<div class="lblcontenedordetalle">';
		echo '<label>Puesto</label>';
		echo '</div>';
		echo '<label>Descripcion: </label><label class="descripcionoferta">' . $_ENV['apps'][$i][0]->descripcion . '</label><br>';
		echo '<label>Empresa: </label><label class="descripcionoferta">' . $_ENV['apps'][0]['empresa'][0]->nombre . '</label><br>';
		echo '<label>Vacantes: </label><label class="vacantesoferta">' . $_ENV['apps'][$i][0]->numero_vacantes . '</label><br>';
		echo '<label>Ubicacion: </label><label class="ubicacionoferta">' . $_ENV['apps'][$i][0]->ubicacion . '</label><br>';
		echo '<label>Salario: </label><label class="salariooferta">' . number_format($_ENV['apps'][$i][0]->salario, 2, '.', ',') . '</label><br>';
		echo '<label>Horario: </label><label class="horariooferta">' . $_ENV['apps'][$i][0]->horario . '</label><br>';
		echo '<label>Duracion: </label><label class="duracionoferta">' . $_ENV['apps'][$i][0]->duracion . '</label><br>';
		echo '<label>Fecha de publicacion: </label><label class="fechaoferta">' . $_ENV['apps'][$i][0]->fecha . '</label><br>';
		echo '</div><br>';
		echo '<div class="contenedorrequisitos" >';
		//aqui van requisitos
		echo '<div class="lblcontenedordetalle">';
		echo '<label>Requisitos</label>';
		echo '</div>';
		for ($k = 0; $k < sizeof($_ENV['apps'][$i]['requisitos']); $k++) {
			echo '<label class="requisito">' . $_ENV['apps'][$i]['requisitos'][$k]->Descripcion . '</label><br>';
		}
		echo '</div><br>';
		echo '<div class="contenedorcategorias">';
		//aqui van categorias
		echo '<div class="lblcontenedordetalle">';
		echo '<label>Categorias</label>';
		echo '</div>';
		for ($k = 0; $k < sizeof($_ENV['apps'][$i]['categorias']); $k++) {
			echo '<label name="' . $_ENV['apps'][$i]['categorias'][$k]->id . '" class="cate">' . $_ENV['apps'][$i]['categorias'][$k]->nombre . '</label><br>';
		}
		echo '</div>';
		echo '</div>';
	}
	?>
</body>

</html>