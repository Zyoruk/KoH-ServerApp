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
	$response['zone_coords'] = $document['zone_coords'];
	$response['zone_owner'] = $document['zone_owner'];
	$response['zone_fight_alert'] = $document['zone_fight_alert'];
}
if ($response['zone_id'] == NULL){
	$response['message'] = 0;
}
echo json_encode ( $response );
?>