<?php
require_once("../connection.php");
//nos conectamos a la base da datos.
$db = Conexion::GetConexion();
//... acá seguirá algo más de la BD?

$username = $_POST ['username'];
$pwd = $_POST ['pwd'];

//Realizar un query para tomar los datos de usuario.
$query = "";
$stmt = $db->prepare($query);
$stmt->execute();
//cramos una variable que almacenará la respuesta del query la base datos
$result = $stmt->get_result();

//creamos la variable que almacena la respuesta final
$response= array();

/* código para almacenar la respuesta donde se tiene que verficar que la 
respuesta tenga al menos una fila.*/
// Se tiene que ir almacenando los datos de $result en $response
if($result){
	//...
	echo json_encode($response);
}else{
	$response["success"] = 0;
	$response["message"] = "User not found";
	echo json_decode($response);
}

?>
