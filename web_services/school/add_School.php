<?php
// Agregar una NUEVA escuela.
$response = array ();
if (isset ( $_GET ['sch'] ) && isset($_GET['color'])) {
	
	$connection = new MongoClient ();
	// buscar user en DB.
	$db = $connection->koh;
	$school_collection = $db->school;
	$school = $school_collection->findOne ( array (
			'sch_name' => $_GET ['sch'] 
	) );
	
	if ($school ['sch_name'] == NULL) {
		$school = $school_collection->findOne ( array (
				'sch_color' => $_GET ['color']
		) );
		if ($school['sch_color'] == NULL){
						$document = array (
					'sch_name' => $_GET ['sch'],
					'sch_color' => $_GET['color']
			);
			$school_collection->insert ( $document );
			$response ['message'] = 1;
		}else{
			$response ['message'] = 0;
			
		}
	} else {
		$response ['message'] = 0;
	}
} else {
	$response ['message'] = 0;
}
echo json_encode ( $response );
?>