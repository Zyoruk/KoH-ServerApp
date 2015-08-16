<?php
$response = array ();
if (isset ( $_GET ['pwd'] ) && isset ( $_GET ['un'] )) {
	$connection = new MongoClient ();
	// y demas datos para crear un usuario nuevo.
	
	// buscar user en DB.
	
	$db = $connection->koh;
	$user_collection = $db->user;
	
	// No pueden dos usuarios con el mismo nombre.
	$user = $user_collection->findOne(array('username'=>$_GET['un']));
	if ($user ['username'] == NULL) {
		$response ['message'] = 0;
	}else{
		$response ['username'] = $user ['username'];
		$response ['password'] = $user ['password'];
		$response ['school'] = $user ['school'];
		$response ['x'] = $user ['x'];
		$response ['y'] = $user ['y'];
		$response ['alert'] = $user ['alert'];
		$response ['taps'] = $user ['taps'];
		$response ['message'] = 1;
	}
} else {
	$response ['message'] = 0;
}
echo json_encode ( $response );
?>
