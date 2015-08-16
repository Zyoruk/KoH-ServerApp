<?php
// nos conectamos a la base da datos.
$response = array ();
if (isset ( $_GET ['pwd'] ) && isset ( $_GET ['un'] ) && isset ( $_GET ['sch'] ) && isset ( $_GET ['x'] )&& isset ( $_GET ['y'] )) {
	$connection = new MongoClient ();
	$db = $connection->koh;
	$user_collection = $db->user;
	
	$user = $user_collection->findOne (array('username'=>$_GET['un']));
	
	$db = $connection->schools;
	$school_collection = $db->school;
	$school = $school_collection->findOne(array('sch_name'=>$_GET['sch']));
	if ($user['username'] == NULL && $school['sch_name']!=NULL) {
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