<?php
$response = array ();
if (isset ( $_GET ['pwd'] ) && isset ( $_GET ['un'] )) {
	$connection = new MongoClient ();
	// y demas datos para crear un usuario nuevo.
	
	// buscar user en DB.
	
	$db = $connection->users;
	$user_collection = $db->user;
	
	// No pueden dos usuarios con el mismo nombre.
	$cursor = $user_collection->find ();
	foreach ( $cursor as $document ) {
		if ($document ['username'] == $_GET ['un'] && $document ['password'] == $_GET ['pwd']) {
			
			$response ['username'] = $document ['username'];
			$response ['password'] = $document ['password'];
			$response ['school'] = $document ['school'];
			$response ['x'] = $document ['x'];
			$response ['y'] = $document ['y'];
			$response ['alert'] = $document ['alert'];
			$response ['taps'] = $document ['taps'];
			$response ['message'] = 1;
			break;
		}
	}
	if ($response ['username'] == NULL) {
		$response ['message'] = 0;
	}
} else {
	$response ['message'] = 0;
}
echo json_encode ( $response );
?>
