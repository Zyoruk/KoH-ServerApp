<?php
$response = array ();
if (isset ( $_GET ['tps'] ) && isset ( $_GET ['un'] )) {
	$connection = new MongoClient ();
	$db = $connection->users;
	$user_collection = $db->user;
	$user = $user_collection->find ();
	$updated = $user_collection->findOne ( array (
			'username' => $_GET ['un'] 
	), array (
			'$set' => array (
					'taps' => $_GET ['taps'] 
			) 
	) );
	foreach ( $user as $document ) {
		if ($user ['taps'] > 0 && $user ['username'] != $_GET ['un']) {
			if ($_GET ['tps'] > $user ['taps']) {
				$response ['winner'] = $updated ['username'];
				
				$db_2 = $connection->zones;
				$zone_collection = $db_2->zone;
				// Buscamos la zona que cumpla con las coordenadas y le cambiamos la bandera a Fight si es necesario.
				$zone = $zone_collection->find ();
				foreach ( $zone as $document ) {
					if ($document ['zone_X1'] < $updated ['x'] && $document ['zone_X2'] > $updated ['x'] && $document ['zone_Y1'] < $updated ['y'] && $document ['zone_Y2'] > $updated ['y']) {
						$zone_collection->update ( array (
								'zone_id' => $document ['zone_id'] 
						), array (
								'$set' => array (
										'zone_owner' => $updated ['school'],
										'zone_fight_alert' => 'safe' 
								) 
						) );
						$user_collection->update ( array (
								'username' => $updated ['un'] 
						), array (
								'$set' => array (
										'alert' => 'safe' 
								) 
						) );
						$user_collection->update ( array (
								'username' => $user ['un'] 
						), array (
								'$set' => array (
										'alert' => 'safe' 
								) 
						) );
						$response ['message'] = 1;
						break;
					}
				}
			} elseif ($_GET ['tps'] < $user ['taps']) {
				$response ['winner'] = $user ['username'];
				
				$db_2 = $connection->zones;
				$zone_collection = $db_2->zone;
				// Buscamos la zona que cumpla con las coordenadas y le cambiamos la bandera a Fight si es necesario.
				$zone = $zone_collection->find ();
				foreach ( $zone as $document ) {
					if ($document ['zone_X1'] < $user ['x'] && $document ['zone_X2'] > $user ['x'] && $document ['zone_Y1'] < $user ['y'] && $document ['zone_Y2'] > $user ['y']) {
						$zone_collection->update ( array (
								'zone_id' => $document ['zone_id'] 
						), array (
								'$set' => array (
										'zone_owner' => $user ['school'],
										'zone_fight_alert' => 'safe' 
								) 
						) );
						$user_collection->update ( array (
								'username' => $updated ['un'] 
						), array (
								'$set' => array (
										'alert' => 'safe' 
								) 
						) );
						$user_collection->update ( array (
								'username' => $user ['un'] 
						), array (
								'$set' => array (
										'alert' => 'safe' 
								) 
						) );
						$response ['message'] = 1;
						break;
					}
				}
			} else {				
				$db_2 = $connection->zones;
				$zone_collection = $db_2->zone;
				// Buscamos la zona que cumpla con las coordenadas y le cambiamos la bandera a Fight si es necesario.
				$zone = $zone_collection->find ();
				foreach ( $zone as $document ) {
					if ($document ['zone_X1'] < $user ['x'] && $document ['zone_X2'] > $user ['x'] && $document ['zone_Y1'] < $user ['y'] && $document ['zone_Y2'] > $user ['y']) {
						$zone_collection->update ( array (
								'zone_id' => $document ['zone_id'] 
						), array (
								'$set' => array (
										'zone_fight_alert' => 'safe' 
								) 
						) );
						$user_collection->update ( array (
								'username' => $updated ['un'] 
						), array (
								'$set' => array (
										'alert' => 'safe' 
								) 
						) );
						$user_collection->update ( array (
								'username' => $user ['un'] 
						), array (
								'$set' => array (
										'alert' => 'safe' 
								) 
						) );
						$response ['message'] = 1;
						break;
					}
				}
			}
		}
	}
} else {
	$response ['message'] = 0;
}
?>