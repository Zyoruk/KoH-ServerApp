<?php
$connection = new MongoClient ();
// buscar user en DB.

$db = $connection->zones;
$zone_collection = $db->zone;

// Tomamos todas las zonas
$zone = $zone_collection->find ();
$response = array ();
$i=0;
foreach ( $zone as $document ) {
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
if($response[0] == NULL){
	$response['message']=0;
}else{
	$response['message']=1;
}
echo json_encode ( $response );
?>