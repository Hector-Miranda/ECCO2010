<?php # registro_carnet.php 
		# Hector Miranda

$page_title = ':: ECCO - Registro de carnets ::';
include ('comunes/encabezado.html');

// Verifica si la forma se ha enviado:
if (isset($_POST['submitted'])) {

	require_once ('mysqli_connect.php'); // Conexión a la BD
		
	$errores = array(); // Inicializa el arreglo de errores.
	
	// revisa el carnet:
	if (empty($_POST['clave_carnet'])) {
		$errores[] = 'Olvidaste introducir el carnet.';
	}else{                
		$v3 = $_POST['clave_carnet']; //valor de la clave del carnet
	  
		$v1 = "select * from carnet where clave_carnet='$v3'"; //coincidencias con el carnet
		
		$v2 = @mysqli_query($dbc, $v1); //resultados de la consulta de coincidencias
	  
		if (mysqli_num_rows($v2) != 0) { //si existe alguna coincidencia
			$errores[] = 'El n&uacute;mero de carnet ya est&aacute; registrado.';
		}else {
			$clave_carnet = mysqli_real_escape_string($dbc, trim($_POST['clave_carnet'])); 
		}
	}
	
	// revisa el nombre completo:
	if (empty($_POST['nombre'])) {
		$errores[] = 'Olvidaste introducir el nombre completo.';
	} else {
		$nombre = mysqli_real_escape_string($dbc, trim($_POST['nombre']));
	}
	
	// revisa el teléfono:
	if (empty($_POST['telefono'])) {
		$errores[] = 'Olvidaste introducir el tel&eacute;fono.';
	} else {
		$telefono = mysqli_real_escape_string($dbc, trim($_POST['telefono']));
	}
	
	// revisa el correo electrónico:
	if (empty($_POST['correo'])) {
		$errores[] = 'Olvidaste introducir el correo electr&oacute;nico.';
	} else {
		$correo = mysqli_real_escape_string($dbc, trim($_POST['correo']));
	}
	
	// revisa el correo electrónico:
	if (empty($_POST['escuela'])) {
		$errores[] = 'Olvidaste introducir la escuela.';
	} else {
		$escuela = mysqli_real_escape_string($dbc, trim($_POST['escuela']));
	}
	
	// La matrícula se envía en automático:
	//if (empty($_POST['matricula'])) {
		//$errores[] = 'Olvidaste introducir el correo electr&oacute;nico.';
	//} else {
		$matricula = mysqli_real_escape_string($dbc, trim($_POST['matricula']));
	//}
	
	if (empty($errores)) { // Si todo está bien...
	
		// Registra el carnet en la base de datos...
		
		// Realiza la consulta:
		$consulta = "INSERT INTO carnet (clave_carnet, nombre, telefono, correo, escuela, matricula) 
				VALUES ('$clave_carnet', '$nombre', '$telefono', '$correo', '$escuela', '$matricula')";
		$resultado = @mysqli_query ($dbc, $consulta); // Run the query.
		if ($resultado) { // If it ran OK.
		
			// Imprime un mensaje:
			echo '<h1>&iexcl;Registro exitoso!</h1>
					<p>Se registr&oacute; el carnet <b>#', $clave_carnet, '</b> con la siguiente informaci&oacute;n:</p>
		
					<p>Nombre completo: <b>', $nombre, '</b>', 
					'<br />Tel&eacute;fono: <b>', $telefono, '</b>', 
					'<br />Correo electr&oacute;nico: <b>', $correo, '</b>', 
					'<br />Escuela: <b>', $escuela, '</b>',
					'<br />Matr&iacute;cula <i>(opcional)</i>: <b>', $matricula,'</b></p>
					<p><br /></p>';
		
		} else { // Si no se ejecutó todo correctamente...
			
			// Publicar mensaje:
			echo '<h1>Error del sistema</h1>
			<p class="error">No se realiz&oacute; el registro debido a un error en el sistema. Disculpe las inconveniencias.</p>'; 
			
			// Debugging message:
			echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $consulta . '</p>';
						
		} // End of if ($r) IF.
		
		mysqli_close($dbc); // Cierra la conexión a la base de datos.

		// Incluye el pie de página y termina el código:
		include ('comunes/pie.html'); 
		exit();
		
	} else { // Reporta los errores.
	
		echo '<h1>&iexcl;Error!</h1>
		<p class="error">Han ocurrido los siguientes errores:<br />';
		foreach ($errores as $mensaje) { // Imprime cada error.
			echo " - $mensaje<br />\n";
		}
		echo '</p><p>Por favor, intente de nuevo.</p><p><br /></p>';
		
	} // End of if (empty($errors)) IF.
	
	mysqli_close($dbc); // Cierra la conexión a la base de datos.

} // Fin de la condición de envío principal.
?>
<h1>Registro de carnet</h1>
<form action="registro_carnet.php" method="post">
	<table>
		<tr>
			<td><p>Carnet:</p></td> 
	    	<td><p><input type="text" name="clave_carnet" size="4" maxlength="4" value="<?php if (isset($_POST['clave_carnet'])) echo $_POST['clave_carnet']; ?>" /></p></td>
		</tr>
		<tr>
			<td><p>Nombre completo:</p></td> 
			<td><p><input type="text" name="nombre" size="50" maxlength="100" value="<?php if (isset($_POST['nombre'])) echo $_POST['nombre']; ?>" /></p></td>
		</tr>
		<tr>
			<td><p>Tel&eacute;fono:</p></td> 
			<td><p><input type="text" name="telefono" size="10" maxlength="10" value="<?php if (isset($_POST['telefono'])) echo $_POST['telefono']; ?>"  /></p></td>
		</tr>
		<tr>		
			<td><p>Correo electr&oacute;nico:</p></td> 
			<td><p><input type="text" name="correo" size="50" maxlength="100" value="<?php if (isset($_POST['correo'])) echo $_POST['correo']; ?>"  /></p></td>
		</tr>
		<tr>
			<td><p>Escuela:</p></td> 
			<td><p><input type="text" name="escuela" size="50" maxlength="100" value="<?php if (isset($_POST['escuela'])) echo $_POST['escuela']; ?>"  /></p></td>
		</tr>	
			<td><p>Matr&iacute;cula <i>(opcional)</i>:</p></td> 
			<td><p><input type="text" name="matricula" size="9" maxlength="9" value="<?php if (isset($_POST['matricula'])) echo $_POST['matricula']; ?>"  /></p></td>
		</tr>
		<tr>
			<td><p><input type="submit" name="submit" value="Registrar" />
			<input type="hidden" name="submitted" value="TRUE" /></p>
			</td>
		</tr>
	</table>
</form>
<?php
include ('comunes/pie.html');
?>