<?php # Script 8.2 - mysqli_connect.php
/*This file contains the database access information.
This file also establishes a connection to MySQL 
and selects the database.*/

// 2010~ configuration, just for old reference's sake now
// // Set the database access information as constants:
// DEFINE ('DB_USER', 'root');
// DEFINE ('DB_PASSWORD', '');
// DEFINE ('DB_HOST', 'localhost');
// DEFINE ('DB_NAME', 'ECCO');

$array_ini = parse_ini_file("config.ini");

DEFINE ('DB_USER', $array_ini["DB_USER"]);
DEFINE ('DB_PASSWORD', $array_ini["DB_PASSWORD"]);
DEFINE ('DB_HOST', $array_ini["DB_HOST"]);
DEFINE ('DB_NAME', $array_ini["DB_NAME"]);

// Make the connection:
$dbc = @mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die ('Ha ocurrido un error... no se pudo conectar: ' . mysqli_connect_error() );
?>