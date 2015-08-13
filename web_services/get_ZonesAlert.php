<?php
//Debe de devolver todas las zonas que tengan la alerta en fight.
$response = array();
if(isset($_GET['sch'])){
	$connection = new MongoClient ();	
	$db = $connection->zones;
	$zone_collection = $db->zone;
	
	// Tomamos todas las zonas
	$zone = $zone_collection->find ();
	
	$i=0;
	foreach($zone as $document){
		if ($document['zone_owner'] == $_GET['sch']){
			$to_add = array();
			$to_add ['zone_id'] = $document ['zone_id'];
			$to_add ['zone_owner'] = $document ['zone_owner'];
			$to_add ['zone_X1'] = $document ['zone_X1'];
			$to_add ['zone_X2'] = $document ['zone_X2'];
			$to_add ['zone_Y1'] = $document ['zone_Y1'];
			$to_add ['zone_Y2'] = $document ['zone_Y2'];
			$to_add ['zone_fight_alert'] = $document ['zone_fight_alert'];
			$response[$i] = $to_add;
			$i++;
		}
	}
}else{
	$response['message']= 0;
}