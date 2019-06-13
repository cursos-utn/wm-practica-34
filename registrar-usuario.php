<?php
    // Necesario para captcha
    session_start();
    include_once $_SERVER['DOCUMENT_ROOT'] . '/securimage/securimage.php';
    $securimage = new Securimage();
    // /Necesario para captcha
    if ($securimage->check($_POST['captcha_code']) == false) {
        echo "Captcha inválido";
        die();
    }
    
    require "config.php";
  
	$form_pass = $_POST['password'];
	$hash = password_hash($form_pass, PASSWORD_BCRYPT); 

	$conexion = mysqli_connect(DB_SERVIDOR, DB_USER, DB_PASSWORD, DB_BASE) or die("No me pude conectar con la base de datos");

    

	$buscarUsuario = "SELECT * FROM usuario WHERE usuario = '$_POST[username]' ";	
	$result = mysqli_query($conexion, $buscarUsuario);	
	$count = mysqli_num_rows($result);

	if ($count == 1) {
		echo "<br />". "El Nombre de Usuario ya a sido tomado." . "<br />";
		echo "<a href='registrar-usuario.html'>Por favor escoga otro Nombre</a>";
	}
	else{
		$query = "INSERT INTO usuario (usuario, password)
		VALUES ('$_POST[username]', '$hash')";

		if (mysqli_query($conexion, $query) === TRUE) {
			echo "<br />" . "<h2>" . "Usuario Creado Exitosamente!" . "</h2>";
			echo "<h4>" . "Bienvenido: " . $_POST['username'] . "</h4>" . "\n\n";
			echo "<h5>" . "Hacer Login: " . "<a href='login.html'>Login</a>" . "</h5>";
		}
 		else {
			echo "Error al crear el usuario." . $query . "<br>" . $conexion->error; 
		}
 	}

	mysqli_close($conexion);
