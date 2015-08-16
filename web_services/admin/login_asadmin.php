<?php
$response = array ();
if (isset ( $_GET ['un'] ) && isset ( $_GET ['pwd'] )) {
	$connection = new MongoClient ();
	// buscar user en DB.
	$db = $connection->koh;
	$admin_collection = $db->admin;
	$admin = $admin_collection->findOne ( array (
			'username' => $_GET ['un'],
			'password' => $_GET ['pwd'] 
	) );
	if ($admin ['username'] == NULL) {
		$response ['message'] = 0;
	} else {
		$response ['message'] = 1;
	}
} else {
	$response ['message'] = 0;
}

echo json_encode ( $response );
?>