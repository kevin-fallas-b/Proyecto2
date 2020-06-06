<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login</title>
        <link rel="stylesheet" type="text/css" href="{{ url('/css/login.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ url('/css/alertify.min.css') }}" />
        <script src="{{ url('/js/login.js')}}"></script>
        <script src="{{ url('/js/alertify.min.js')}}"></script>
        <link rel="icon" href="{{ url('/img/favicon.png') }}" type="image/x-icon">

    </head>
    <body>
    <?php 
        if(isset($_POST['mensaje'])){
            echo "<script> mensajeError('".$_POST['mensaje']."'); </script>"; 
        }
    ?>
    <div id="main">
            <label id='sirhena'>SIRHENA</label>
			<div id="login">
				<div id="form_container">
					<form method="POST">
                        {{csrf_field()}}
						<input type="text" name="txt_username" id="txt_username" placeholder="USUARIO" title="Usuario" class="cajatexto"/><br />
						<input type="password" name="txt_password" id="txt_password" placeholder="**********" title="Contraseña" class="cajatexto"/><br/>
						<input type="button" value="OK" name="btn_login" id="btn_login"/>
						<input type="submit" value="" name="btn_submit" id="btn_submit" hidden/>
                    </form>
                </div>
                <a href="registro" id="registrarme">Crear una cuenta</a>
			</div>
		</div>
</html>
