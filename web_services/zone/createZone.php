<?php
// Servicio para la parte administrativa del juego.
// No debería ser pública para la aplicación android.
$response = array ();
if (isset ( $_GET ['zid'] ) && isset ( $_GET ['x1'] ) && isset ( $_GET ['x2'] ) && isset ( $_GET ['y1'] ) && isset ( $_GET ['y2'] )) {
	$connection = new MongoClient ();
	// Verificar que no exista otra zona con el mismo nombre.
	$db = $connection->koh;
	$zone_collection = $db->zone;
	// Tomamos todas las zonas
	$zone = $zone_collection->find ();
	$exists = false;
	$fits = true;
	foreach ( $zone as $document ) {
		if ($document ['zone_id'] == $_GET ['zid']) {
			$exists = true;
			break;
		} else if ($_GET ['x1'] >= $document ['zone_X1'] && $_GET ['x2'] <= $document ['zone_X2'] && $_GET ['y1'] >= $document ['zone_Y1'] && $_GET ['y2'] >= $document ['zone_Y2']) {
			$fits = false;
			break;
		}
	}
	if ($exists == false && $fits == true) {
		$document = array (
				'zone_id' => $_GET ['zid'],
				'zone_owner' => 'neutral',
				'zone_X1' => $_GET ['x1'],
				'zone_X2' => $_GET ['x2'],
				'zone_Y1' => $_GET ['y1'],
				'zone_Y2' => $_GET ['y2'],
				'zone_fight_alert' => 'safe' 
		);
		$zone_collection->insert ( $document );
		$response ['message'] = 1;
	} else {
		$response ['message'] = 0;
	}
} else {
	$response ['message'] = 0;
}
echo json_encode ( $response );
?>
