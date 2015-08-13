<?php
//Listar todos los usuarios registrados

//Conexión con mongo
$connection = new MongoClient ();
$db = $connection->users;
$user_collection = $db->user;

//Tomar todos los usuarios
$user = $user_collection->find ();

//Arreglo que vamos a regresar
$response = array ();

//Contador necesario para ir agregando a la respuesta los usuarios
$i=0;

//Toma cada usuario, lo introduce en un arreglo y finalmente toma este arreglo y lo agrega a la respuesta.
foreach ( $user as $document ) {
	$to_add = array();
	$to_add ['username'] = $document ['username'];
	$to_add ['password'] = $document ['password'];
	$to_add ['school'] = $document ['school'];
	$to_add ['x'] = $document ['x'];
	$to_add ['y'] = $document ['y'];
	$to_add ['alert'] = $document ['alert'];
	$response[$i] = $to_add;
	$i++;
}
echo json_encode ( $response );
?>