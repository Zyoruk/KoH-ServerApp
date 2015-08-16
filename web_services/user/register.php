<?php
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
	
	//buscamos que la escuela exista (utilizaremos la misma variable $exists solo para reciclar.)
	$db = $connection->schools;
	$school_collection = $db->school;
	$school = $school_collection->findOne(array('sch_name'=>$_GET['sch']));
	if($school['sch_name']==NULL){
		$exists=true;
	}
	
	if ($exists == false) {
		$doc = array (
				"username" => $_GET ['un'],
				"password" => $_GET ['pwd'],
				"school" => $_GET ['sch'],
				"x"=> $_GET['x'],
				"y"=> $_GET['y'],
				"alert"=>'safe',
				'taps'=> 0
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