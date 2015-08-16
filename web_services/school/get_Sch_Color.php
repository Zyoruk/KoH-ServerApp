<?php
$response = array();
if (isset($_GET['sch'])){
	$connection = new MongoClient ();
	// buscar user en DB.
	$db = $connection->koh;
	$school_collection = $db->school;
	$school = $school_collection->findOne ( array (
			'sch_name' => $_GET ['sch']
	) );
	if ($school['sch_color'] == NULL){
		$response['color'] = $_GET['sch_color'];
		$response['message'] = 1;
	}else{
		$response['message'] = 0;
	}
}else{
	$response['message'] = 0;
}
echo json_encode($response);