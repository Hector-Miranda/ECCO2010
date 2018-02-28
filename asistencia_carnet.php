<?php # asistencia_carnet.php 
		# Hector Miranda
		
require_once ('mysqli_connect.php');
$page_title = ':: ECCO - Toma de asistencia ::';
include ('comunes/encabezado.html');

if (isset($_POST['submitted'])) { // Handle the form.
	
	// Validate the incoming data...
	$errors = array();	
	
	if (empty($_POST['print_carnet'])) {
		$errors[] = 'Falta proporcionar el n&uacute;mero de carnet.';
	}else{                
		$v3 = $_POST['print_carnet'];

		$v1 = "select * from carnet where clave_carnet='$v3'";
		
		$v2 = @mysqli_query($dbc, $v1);
		
		if (mysqli_num_rows($v2) == 0) {
			$errors[] = 'El carnet no est&aacute; registrado.';
		}else {
			$pn = mysqli_real_escape_string($dbc, trim($_POST['print_carnet'])); 
		}
	}

	if ( isset($_POST['carnet']) && ($_POST['carnet'] == 'existing') && ($_POST['existing'] > 0) ) { // Existing carnet.
		$a = (int) $_POST['existing'];

	} else { // No carnet selected.
		$errors[] = 'Olvidaste seleccionar la conferencia.';
	}
	
	$consulta = "select (now()) as numero";
	$resultado = @mysqli_query ($dbc, $consulta);
	$resultarr = mysqli_fetch_assoc($resultado);
	$total = $resultarr["numero"];	
		
	if (empty($errors)) { // If everything's OK.
		// Add the print to the database:
		$q= 'INSERT INTO carnet_con_conferencia (carnet, conferencia, tiempo) VALUES (?, ?, ?)';		
		
		$stmt = mysqli_prepare($dbc, $q);						
		mysqli_stmt_bind_param($stmt, 'iis', $pn, $a, $total);
		mysqli_stmt_execute($stmt);
		
		// Check the results...
		if (mysqli_stmt_affected_rows($stmt) == 1) {
			$carnet= $pn;
			$conferencia = $a;
			// Print a message:
				echo '<h1>&iexcl;Asistencia registrada!</h1>
					<p>Se registr&oacute; la asistencia del carnet <b>#', $carnet, '</b> para la conferencia "<b>', $conferencia, '</b>".</p>
					';

			// Clear $_POST:
			$_POST = array();
			
		} else { // Error!
			echo '<p class="error">No se pudo registrar la asistencia.<br />';
			echo '</p><p>Aseg&uacute;rese que no hay asistencia para ese n&uacute;mero de carnet.</p><p><br /></p>';
		}
		
		mysqli_stmt_close($stmt);
		
	} // End of $errors IF.	
} // End of the submission IF.

// Check for any errors and print them:
if ( !empty($errors) && is_array($errors) ) {
	echo '<h1>&iexcl;Error!</h1>
	<p class="error">Han ocurrido los siguientes errores:<br />';
	foreach ($errors as $msg) {
		echo " - $msg<br />\n";
	}
	echo '</p><p>Por favor, intente de nuevo.</p><p><br /></p>';
}

// Display the form...
?>
<h1>Asistencia con carnet</h1>
<form enctype="multipart/form-data" action="asistencia_carnet.php" method="post">
	<table>
		<tr>
			<td><p>Carnet:</p></td> 
			<td><p><input type="text" name="print_carnet" size="4" maxlength="4" value="<?php if (isset($_POST['print_carnet'])) echo htmlspecialchars($_POST['print_carnet']); ?>" /></p></td>
		</tr>
		<tr>
			<td><p>Conferencia:</p></td>
	 		<td><p><input type="hidden" name="carnet" value="existing" <?php if (isset($_POST['carnet']) && ($_POST['carnet'] == 'existing') ) echo ' checked="checked"'; ?>/>
				<select name="existing"><option>Seleccione la conferencia...</option>
				<?php // Retrieve all the carnets and add to the pull-down menu.
					$q = "SELECT * FROM conferencia ORDER BY clave_conferencia ASC";		
					$r = mysqli_query ($dbc, $q);
					if (mysqli_num_rows($r) > 0) {
						while ($row = mysqli_fetch_array ($r, MYSQLI_NUM)) {
							echo "<option value=\"$row[0]\"";
							// Check for stickyness:
							if (isset($_POST['existing']) && ($_POST['existing'] == $row[0]) ) echo ' selected="selected"';
								echo ">$row[0]) $row[1], con $row[2]</option>\n";
						}
					} else {
						echo '<option>No hay conferencias registradas.</option>';
					}
					mysqli_close($dbc); // Close the database connection.
				?>
				</select></p>
			</td>	
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