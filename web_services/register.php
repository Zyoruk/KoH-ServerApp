<?php
require_once ("../connection.php");
// nos conectamos a la base da datos.
$db = Conexion::GetConexion ();
// ... acá seguirá algo más de la BD?

$username = $_POST ['username'];
$pwd = $_POST ['pwd'];
// y demas datos para crear un usuario nuevo.

// query para crear user en DB.
$query = "";
$stmt = $db->prepare($query);
$stmt->execute();
//cramos una variable que almacenará la respuesta del query
$result = $stmt->get_result();

//creamos la variable que almacena la respuesta final
$response= array();
?>