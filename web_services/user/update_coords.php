<?php
// Actualiza coordenadas

$response = array ();
if (isset ( $_GET ['un'] ) && isset ( $_GET ['x'] ) && isset ( $_GET ['y'] )) {
	$connection = new MongoClient ();
	$db = $connection->koh;
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
		$user = $user_collection->findOne ( array (
				"username" => $_GET ['un']
		) );
		// una vez actualizado, verificar si no esta en zona enemiga.
		$db_2 = $connection->koh;
		$zone_collection = $db_2->zone;
		// Buscamos la zona que cumpla con las coordenadas y le cambiamos la bandera a Fight si es necesario.
		$zone = $zone_collection->find ();
		$i=0;
		foreach ( $zone as $document ) {
			if ($document ['zone_owner'] != $user ['school']) {
				if ($document ['zone_X1'] < $user ['x'] && $document ['zone_X2'] > $user ['x'] &&
						$document ['zone_Y1'] < $user ['y'] && $document ['zone_Y2'] > $user ['y']) {
							if ($document ['zone_owner'] == 'neutral') {
								$zone_collection->update ( array (
										'zone_id' => $document ['zone_id']
								), array (
										'$set' => array (
												'zone_owner' => $user ['school']
										)
								) );
								$response['status']='safe';
								$response['message']=1;
							} else {
								$zone_collection->update ( array (
										'zone_id' => $document ['zone_id']
								), array (
										'$set' => array (
												'zone_fight_alert' => 'fight'
										)
								) );
								$user_collection->update ( array (
										'username' => $_GET ['un']
								), array (
										'$set' => array (
												'alert' => 'fight'
										)
								) );
								$response['status']='fight';
								$response['message']=1;
							}
						}
			}else{
					if ($document ['zone_fight_alert'] == 'fight'){
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
					$response['status']='safe';
					$response['message']=1;
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
