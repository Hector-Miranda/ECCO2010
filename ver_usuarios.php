<?php # Script 9.4 - #4

// This script retrieves all the records from the users table.
// This version paginates the query results.

$page_title = ':: ECCO - Lista de carnets ::';
include ('comunes/encabezado.html');
echo '<h1>Carnets registrados</h1>';

require_once ('mysqli_connect.php');

// Number of records to show per page:
$display = 10;

// Determine how many pages there are...
if (isset($_GET['p']) && is_numeric($_GET['p'])) { // Already been determined.

	$pages = $_GET['p'];

} else { // Need to determine.

 	// Count the number of records:
	$q = "SELECT COUNT(clave_carnet) FROM carnet";
	$r = @mysqli_query ($dbc, $q);
	$row = @mysqli_fetch_array ($r, MYSQLI_NUM);
	$records = $row[0];

	// Calculate the number of pages...
	if ($records > $display) { // More than 1 page.
		$pages = ceil ($records/$display);
	} else {
		$pages = 1;
	}
	
} // End of p IF.

// Determine where in the database to start returning results...
if (isset($_GET['s']) && is_numeric($_GET['s'])) {
	$start = $_GET['s'];
} else {
	$start = 0;
}
		
// Determine the sort...
$sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'z';

// Determine the sorting order:
switch ($sort) {
	case 'z':
		$order_by = 'clave_carnet ASC';
		break;
	case 'a':
		$order_by = 'nombre ASC';
		break;
	case 'b':
		$order_by = 'telefono ASC';
		break;
	case 'c':
		$order_by = 'correo ASC';
		break;
	case 'd':
		$order_by = 'escuela ASC';
		break;
        case 'e':
		$order_by = 'matricula ASC';
		break;
	default:
		$order_by = 'clave_carnet ASC';
		$sort = 'z';
		break;
}

// Make the query:
$q="select * from carnet order by clave_Carnet asc LIMIT $start, $display";
$r = @mysqli_query ($dbc, $q);

// Table header:
echo '<table align="center" cellspacing="5" cellpadding="5" width="100%">
<tr>
	<td align="left"><b>Editar</b></td>
	<td align="left"><b>Borrar</b></td>
	<td align="left"><b><a href="ver_usuarios.php?sort=z">Carnet</a></b></td>
	<td align="left"><b><a href="ver_usuarios.php?sort=a">Nombre</a></b></td>
	<td align="left"><b><a href="ver_usuarios.php?sort=b">Tel&eacute;fono</a></b></td>
	<td align="left"><b><a href="ver_usuarios.php?sort=c">Correo</a></b></td>
	<td align="left"><b><a href="ver_usuarios.php?sort=d">Escuela</a></b></td>
	<td align="left"><b><a href="ver_usuarios.php?sort=e">Matr&iacute;cula</a></b></td>	
</tr>
';

// Fetch and print all the records....

$bg = '#eeeeee'; // Set the initial background color.

while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {

	$bg = ($bg=='#eeeeee' ? '#ffffff' : '#eeeeee'); // Switch the background color.
	
	echo '<tr bgcolor="' . $bg . '">
		<td align="left"><a href="editar_carnet.php?id=' . $row['clave_carnet'] . '">Editar</a></td>
		<td align="left"><a href="borrar_carnet.php?id=' . $row['clave_carnet'] . '">Borrar</a></td>
		<td align="left">' . $row['clave_carnet'] . '</td>
		<td align="left">' . $row['nombre'] . '</td>
		<td align="left">' . $row['telefono'] . '</td>
		<td align="left">' . $row['correo'] . '</td>
		<td align="left">' . $row['escuela'] . '</td>
		<td align="left">' . $row['matricula'] . '</td>
	</tr>
	';
	
} // End of WHILE loop.

echo '</table>';
mysqli_free_result ($r);
mysqli_close($dbc);

// Make the links to other pages, if necessary.
if ($pages > 1) {
	
	// Add some spacing and start a paragraph:
	echo '<br /><p>';
	
	// Determine what page the script is on:	
	$current_page = ($start/$display) + 1;
	
	// If it's not the first page, make a Previous button:
	if ($current_page != 1) {
		echo '<a href="ver_usuarios.php?s=' . ($start - $display) . '&p=' . $pages . '&sort=' . $sort . '">Anterior</a> ';
	}
	
	// Make all the numbered pages:
	for ($i = 1; $i <= $pages; $i++) {
		if ($i != $current_page) {
			echo '<a href="ver_usuarios.php?s=' . (($display * ($i - 1))) . '&p=' . $pages . '&sort=' . $sort . '">' . $i . '</a> ';
		} else {
			echo $i . ' ';
		}
	} // End of FOR loop.
	
	// If it's not the last page, make a Next button:
	if ($current_page != $pages) {
		echo '<a href="ver_usuarios.php?s=' . ($start + $display) . '&p=' . $pages . '&sort=' . $sort . '">Siguiente</a>';
	}
	
	echo '</p>'; // Close the paragraph.
	
} // End of links section.
	
include ('comunes/pie.html');
?>