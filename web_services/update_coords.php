<?php
$connection = new MongoClient ();	

$username = $_GET['un'];
$new_Xcoords = $_GET ['X'];
$new_Ycoords = $_GET ['Y'];

// updating the coords
$db = $connection->users;
$user_collection = $db->user;
$user_collection->update ( array (
		"username" => $username 
), array (
		'$set' => array (
				"coords_X" => $new_Xcoords,
				"coords_Y" => $new_Ycoords 
		) 
) );

// once udpated, check if not on enemy territory.
$db_2 = $connection->zones;
$zone_collection = $db->zone;
// Buscamos la zona que cumpla con las coordenadas y le cambiamos la bandera a Fight si es necesario.
$zone = $zone_collection->find ();

$user = $user_collection->findOne ( array (
		"username" => $username 
) );
$response=array();
foreach ( $zone as $document ) {
	if ($document ['zone_X1'] < $user ['coords_X'] && $document ['zone_X2'] > $user['coords_X'] && $document ['zone_Y1'] < $user ['coords_Y'] && $document ['zone_Y2'] > $user['coords_Y']) {
		if ($document['zone_owner'] == $user['school']){
			$response ['status'] = "Safe";
			$response ['message'] = 1;
		}else{
			$response ['status'] = "Fight";
			$response ['message'] = 0;
			$zone->update(array('zone_id' => $document['zone_id']), array('$set'=> array('zone_fight_alert'=> 'Fight')));
		}
		break;
	}
}
if ($response['message'] == NULL){
	$response['message'] = 0;
}

echo json_encode($response);
?>
