<?php
//Crear admin 
$response = array ();
if (isset ( $_GET ['pwd'] ) && isset ( $_GET ['un'] )) {
	$connection = new MongoClient ();

	$db = $connection->admins;
	$admin_collection = $db->admin;

	// No pueden haber dos admins con el mismo nombre.
	$admin = $admin_collection->find ();
	$exists = false;
	foreach ( $admin as $document ) {
		if ($document ['username'] == $_GET ['un']) {
			$exists = true;
			break;
		}
	}
	if ($exists == false) {
		$doc = array (
				"username" => $_GET ['un'],
				"password" => $_GET ['pwd'],
		);
		$admin_collection->insert ( $doc );
		$response ["message"] = 1;
	} else {
		$response ["message"] = 0;
	}
} else {
	$response ['message'] = 0;
}
echo json_encode ( $response );