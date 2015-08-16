<?php
// Agregar una NUEVA escuela.
$response = array ();
if (isset ( $_GET ['sch'] )) {
	
	$connection = new MongoClient ();
	// buscar user en DB.
	$db = $connection->schools;
	$school_collection = $db->school;
	$school = $school_collection->findOne ( array (
			'sch_name' => $_GET ['sch'] 
	) );
	
	if ($school ['sch_name'] == NULL) {
		$document = array (
				'sch_name' => $_GET ['sch'] 
		);
		$school_collection->insert ( $document );
		$response ['message'] = 1;
	} else {
		$response ['message'] = 0;
	}
} else {
	$response ['message'] = 0;
}
echo json_encode ( $response );
?>