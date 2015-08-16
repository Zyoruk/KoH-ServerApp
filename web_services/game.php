<?php
$response = array ();
if (isset ( $_GET ['tps'] ) && isset ( $_GET ['un'] )) {
	$connection = new MongoClient ();
	$db = $connection->koh;
	$user_collection = $db->user;
	$user_collection->update ( array (
			'username' => $_GET ['un'] 
	), array (
			'$set' => array (
					'taps' => $_GET ['tps'] 
			) 
	) );
	$updated = $user_collection->findOne ( array (
			'username' => $_GET ['un'] 
	));
	$user = $user_collection->find ();
	
	foreach ( $user as $document ) {
		if ($document ['taps'] > 0 && $document ['username'] != $_GET ['un']) {
			if ($_GET ['tps'] > $document ['taps']) {
				$response ['winner'] = $updated ['username'];
				$db = $connection->koh;
				$zone_collection = $db->zone;
				$zone = $zone_collection->find ();
				foreach ( $zone as $document2 ) {
					if ($document2 ['zone_X1'] < $updated ['x'] && $document2 ['zone_X2'] > $updated ['x'] && $document2 ['zone_Y1'] < $updated ['y'] && $document2 ['zone_Y2'] > $updated ['y']) {
						$zone_collection->update ( array (
								'zone_id' => $document2 ['zone_id'] 
						), array (
								'$set' => array (
										'zone_owner' => $updated ['school'],
										'zone_fight_alert' => 'safe' 
								) 
						) );
						$user_collection->update ( array (
								'username' => $updated ['username'] 
						), array (
								'$set' => array (
										'alert' => 'safe' 
								) 
						) );
						$user_collection->update ( array (
								'username' => $document ['username'] 
						), array (
								'$set' => array (
										'alert' => 'safe' 
								) 
						) );
						$response ['message'] = 1;
						break;
					}
				}
			} elseif ($_GET ['tps'] < $document ['taps']) {
				$response ['winner'] = $document ['username'];
				
				$db_2 = $connection->zones;
				$zone_collection = $db_2->zone;
				// Buscamos la zona que cumpla con las coordenadas y le cambiamos la bandera a Fight si es necesario.
				$zone = $zone_collection->find ();
				foreach ( $zone as $document2 ) {
					if ($document2 ['zone_X1'] < $document ['x'] && $document ['zone_X2'] > $document ['x'] && $document2 ['zone_Y1'] < $document ['y'] && $document2 ['zone_Y2'] > $document ['y']) {
						$zone_collection->update ( array (
								'zone_id' => $document2 ['zone_id'] 
						), array (
								'$set' => array (
										'zone_owner' => $document ['school'],
										'zone_fight_alert' => 'safe' 
								) 
						) );
						$user_collection->update ( array (
								'username' => $updated ['username'] 
						), array (
								'$set' => array (
										'alert' => 'safe' 
								) 
						) );
						$user_collection->update ( array (
								'username' => $document ['username'] 
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
				$zone = $zone_collection->find ();
				foreach ( $zone as $document2 ) {
					if ($document2 ['zone_X1'] < $document ['x'] && $document2 ['zone_X2'] > $document ['x'] && $document2 ['zone_Y1'] < $document ['y'] && $document2 ['zone_Y2'] > $document ['y']) {
						$zone_collection->update ( array (
								'zone_id' => $document2 ['zone_id'] 
						), array (
								'$set' => array (
										'zone_fight_alert' => 'safe' 
								) 
						) );
						$user_collection->update ( array (
								'username' => $updated ['username'] 
						), array (
								'$set' => array (
										'alert' => 'safe' 
								) 
						) );
						$user_collection->update ( array (
								'username' => $document ['username'] 
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
			break;
		}else{
			$response ['message'] = 0;
			break;
		}
	}
} else {
	$response ['message'] = 0;
}
echo json_encode($response);
?>