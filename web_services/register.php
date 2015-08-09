<?php
// require_once ("../connection.php");
// nos conectamos a la base da datos.

$connection = new MongoClient();
$username = $_GET['username'];
$pwd = $_GET['password'];
// y demas datos para crear un usuario nuevo.

//crear user en DB.

 $db = $connection->users;
 $user_collection = $db->user;
 
//No pueden dos usuarios con el mismo nombre.
 $cursor = $user_collection->find();
 $exists = false;
 foreach ($cursor as $document) {
 	if($document['username']== $username){
 		$exists = true;
 		break;
 	}
 }
 $response = array();
 if ($exists == false){
 	$doc = array("username" => $username, "password" => $pwd);
 	$user_collection->insert($doc);
 	$response["success"] = 1;
 }else{
 	$response["success"] = 0;
 }
 echo json_encode($response);
?>