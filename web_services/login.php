<?php
$connection = new MongoClient ();
$username = $_GET ['username'];
$pwd = $_GET ['password'];
// y demas datos para crear un usuario nuevo.

// buscar user en DB.

$db = $connection->users;
$user_collection = $db->user;

// No pueden dos usuarios con el mismo nombre.
$cursor = $user_collection->find ();
$response = array ();
foreach ( $cursor as $document ) {
	if ($document ['username'] == $username && $document ['password'] == $pwd) {
		
		$response ['username'] = $document ['username'];
		$response ['password'] = $document ['password'];
		$response ['message'] = 1;
		break;
	}
}
if ($response['username'] == NULL){
	$response['message'] = 0;
}
echo json_encode ( $response );

?>
