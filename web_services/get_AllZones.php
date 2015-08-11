<?php
$connection = new MongoClient ();
//buscar user en DB.

$db = $connection->zones;
$zone_collection = $db->zone;

// Tomamos todas las zonas
$zone = $zone_collection->find ();
$response = array ();
foreach ( $zone as $document ) {
	$response['zone_id'] = $document['zone_id'];
	$response['zone_X1'] = $document['zone_X1'];
	$response['zone_X2'] = $document['zone_X2'];
	$response['zone_Y1'] = $document['zone_Y1'];
	$response['zone_Y2'] = $document['zone_Y2'];
	$response['zone_owner'] = $document['zone_owner'];
	$response['zone_fight_alert'] = $document['zone_fight_alert'];
}
if ($response['zone_id'] == NULL){
	$response['message'] = 0;
}
echo json_encode ( $response );
?>