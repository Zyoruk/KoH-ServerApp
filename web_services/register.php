<?php
// require_once ("../connection.php");
// nos conectamos a la base da datos.
$response = array ();
if (isset ( $_GET ['pwd'] ) && isset ( $_GET ['un'] ) && isset ( $_GET ['sch'] ) && isset ( $_GET ['x'] )&& isset ( $_GET ['y'] )) {
	$connection = new MongoClient ();
	// y demas datos para crear un usuario nuevo.
	
	// crear user en DB.
	
	$db = $connection->users;
	$user_collection = $db->user;
	
	// No pueden dos usuarios con el mismo nombre.
	$cursor = $user_collection->find ();
	$exists = false;
	foreach ( $cursor as $document ) {
		if ($document ['username'] == $_GET ['un']) {
			$exists = true;
			break;
		}
	}
	if ($exists == false) {
		$doc = array (
				"username" => $_GET ['un'],
				"password" => $_GET ['pwd'],
				"school" => $_GET ['sch'],
				"x"=> $_GET['x'],
				"y"=> $_GET['y'],
				"alert"=>'safe'
		);
		$user_collection->insert ( $doc );
		$response ["message"] = 1;
	} else {
		$response ["message"] = 0;
	}
} else {
	$response ['message'] = 0;
}
echo json_encode ( $response );
?>