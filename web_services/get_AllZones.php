<?php
require_once("../connection.php");
//nos conectamos a la base da datos.
$db = Conexion::GetConexion();
//... acá seguirá algo más de la BD?

//realiza un query para tomar todas las zonas existentes y sus datos.
$query = "";
$stmt = $db->prepare($query);
$stmt->execute();
//cramos una variable que almacenará la respuesta del query
$result = stmt->get_result();

//creamos la variable que almacena la respuesta final
$response= array();
/* código para almacenar la respuesta donde se tiene que verficar que la 
respuesta tenga al menos una fila.*/
// Se tiene que ir almacenando los datos de $result en $response
if($result){
	//...
	echo json_decode($response);
}else{
	$response["success"] = 0;
	$response["message"] = "No zones found";
	echo json_decode($response);
}
?>