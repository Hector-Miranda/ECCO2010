<?php # edit_carnet.php

// This page is for editing a carnet record.
// This page is accessed through lista_carnet.php.

$page_title = ':: ECCO - Edici&oacute;n de carnets';
include ('comunes/encabezado.html');

echo '<h1>Editar datos de registro</h1>';

// Check for a valid user ID, through GET or POST:
if ( (isset($_GET['clave_carnet'])) && (is_numeric($_GET['clave_carnet'])) ) {
	$clave_carnet = $_GET['clave_carnet'];
} elseif ( (isset($_POST['clave_carnet'])) && (is_numeric($_POST['clave_carnet'])) ) { // Form submission.
	$clave_carnet = $_POST['clave_carnet'];
} else { // No valid ID, kill the script.
	echo '<p class="error">No hay datos en ese carnet.</p>';
	include ('comunes/pie.html'); 
	exit();
}

require_once ('mysqli_connect.php'); 

// Check if the form has been submitted:
if (isset($_POST['submitted'])) {

	$errors = array();
	
	// revisa el nombre completo:
	if (empty($_POST['nombre'])) {
		$errors[] = 'Olvidaste introducir el nombre completo.';
	} else {
		$nombre = mysqli_real_escape_string($dbc, trim($_POST['nombre']));
	}
	
	// revisa el tel�fono:
	if (empty($_POST['telefono'])) {
		$errors[] = 'Olvidaste introducir el tel&eacute;fono.';
	} else {
		$telefono = mysqli_real_escape_string($dbc, trim($_POST['telefono']));
	}
	
	// revisa el correo electr�nico:
	if (empty($_POST['correo'])) {
		$errors[] = 'Olvidaste introducir el correo electr&oacute;nico.';
	} else {
		$correo = mysqli_real_escape_string($dbc, trim($_POST['correo']));
	}
	
	// revisa el correo electr�nico:
	if (empty($_POST['escuela'])) {
		$errors[] = 'Olvidaste introducir la escuela.';
	} else {
		$escuela = mysqli_real_escape_string($dbc, trim($_POST['escuela']));
	}
	
	// La matr�cula se env�a en autom�tico:
	//if (empty($_POST['matricula'])) {
		//$errores[] = 'Olvidaste introducir el correo electr&oacute;nico.';
	//} else {
		$matricula = mysqli_real_escape_string($dbc, trim($_POST['matricula']));
	//}
	
	if (empty($errors)) { // If everything's OK.
		// Make the query:
		$q = "UPDATE carnet SET nombre='$nombre', telefono='$telefono', correo='$correo', escuela='$escuela', matricula='$matricula' 
			WHERE clave_carnet=$clave_carnet LIMIT 1";

		$r = @mysqli_query ($dbc, $q);

		if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.
		
			// Print a message:
			echo '<p><b>Se han editado los datos.</b></p>';	
						
		} else { // If it did not run OK.
			echo '<p class="error">No se pudieron actualizar los datos debido a un error.</p>'; // Public message.
			echo '<p class="error">Aseg&uacute;rese de no estar introduciendo los mismos datos.</p>'; // Public message.
			echo '<p>' . mysqli_error($dbc) . '<br />Query: ' . $q . '</p>'; // Debugging message.
		}		
	} else { // Report the errors.
		echo '<p class="error">Ocurrieron los siguientes errores:<br />';
		foreach ($errors as $msg) { // Print each error.
			echo " - $msg<br />\n";
		}

		echo '</p><p>Int&eacute;ntelo de nuevo.</p>';
	} // End of if (empty($errors)) IF.
} // End of submit conditional.

// Always show the form...

// Retrieve the user's information:
$q = "SELECT * FROM carnet WHERE clave_carnet=$clave_carnet";
$r = @mysqli_query ($dbc, $q);

if ((int)mysqli_num_rows($r) == 1) { // Valid ID, show the form.
	// Get the user's information:
	$row = mysqli_fetch_array ($r, MYSQLI_NUM);
	
	// Create the form:

	echo '<form action="editar_carnet.php" method="post">
		<table>
			<tr>
				<td><p>Carnet:</p></td> 
				<td><p><input type="text" name="clave_carnet" size="4" maxlength="4" value="'. $row[0] .'" /></p></td>
			</tr>
			<tr>
				<td><p>Nombre completo:</p></td> 
				<td><p><input type="text" name="nombre" size="50" maxlength="100" value="'. $row[1] .'" /></p></td>
			</tr>
			<tr>
				<td><p>Tel&eacute;fono:</p></td> 
				<td><p><input type="text" name="telefono" size="10" maxlength="10" value="'. $row[2] .'"  /></p></td>
			</tr>
			<tr>		
				<td><p>Correo electr&oacute;nico:</p></td> 
				<td><p><input type="text" name="correo" size="50" maxlength="100" value="'. $row[3] .'"  /></p></td>
			</tr>
			<tr>
				<td><p>Escuela:</p></td> 
				<td><p><input type="text" name="escuela" size="50" maxlength="100" value="'. $row[4] .'"  /></p></td>
			</tr>	
				<td><p>Matr&iacute;cula <i>(opcional)</i>:</p></td> 
				<td><p><input type="text" name="matricula" size="9" maxlength="9" value="'. $row[5] .'"  /></p></td>
			</tr>
			<tr>
				<td><p><input type="submit" name="submit" value="Actualizar" />
				<input type="hidden" name="submitted" value="TRUE" /></p>
				</td>
			</tr>
		</table>
	</form>';

} else { // Not a valid ID.
	echo '<p class="error">No se encontraron datos del carnet.</p>';
	echo $q, ' xxx ', $r;
}

mysqli_close($dbc);
		
include ('comunes/pie.html');
?>