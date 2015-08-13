<?php
// Actualiza coordenadas

$response = array ();
if (isset ( $_GET ['un'] ) && isset ( $_GET ['x'] ) && isset ( $_GET ['y'] )) {
	$connection = new MongoClient ();
	$db = $connection->users;
	$user_collection = $db->user;
	// Buscamos a un usuario
	$user = $user_collection->findOne ( array (
			"username" => $_GET ['un'] 
	) );
	if ($user['username'] != NULL) {
		$user_collection->update ( array (
				"username" => $_GET ['un'] 
		), array (
				'$set' => array (
						"x" => $_GET ['x'],
						"y" => $_GET ['y'] 
				) 
		) );

		// una vez actualizado, verificar si no esta en zona enemiga.
		$db_2 = $connection->zones;
		$zone_collection = $db->zone;
		// Buscamos la zona que cumpla con las coordenadas y le cambiamos la bandera a Fight si es necesario.
		$zone = $zone_collection->find ();
		
		foreach ( $zone as $document ) {
			if ($document ['zone_owner'] != $user ['school']) {
				if ($document ['zone_X1'] < $user ['x'] && $document ['zone_X2'] > $user ['x'] &&
						$document ['zone_Y1'] < $user ['y'] && $document ['zone_Y2'] > $user ['y']) {
							if($document['zone_owner']==$user['school']){
								$response['status']='safe';
								$response['message']=1;
								break;
							}
							if ($document ['zone_owner'] == 'neutral') {
								$zone->update ( array (
										'zone_id' => $document ['zone_id']
								), array (
										'$set' => array (
												'zone_owner' => $user ['school']
										)
								) );
								$response['status']='safe';
								$response['message']=1;
								break;
							} else {
								$zone->update ( array (
										'zone_id' => $document ['zone_id']
								), array (
										'$set' => array (
												'zone_fght_alert' => 'fight'
										)
								) );
								$user->update ( array (
										'username' => $_GET ['un']
								), array (
										'$set' => array (
												'alert' => 'fight'
										)
								) );
								$response['status']='fight';
								$response['message']=1;
								break;
							}
						}
			}
		}
		if ($response['status'] == NULL){
			//Esto quiere decir que estaba fuera de zona de juego.
			$response['message']=0;
		}
	}else{
		$response ['message'] = 0;
	}
} else {
	$response ['message'] = 0;
}

echo json_encode ( $response );
?>
