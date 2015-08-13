<?php
$response = array ();
// Definidos player 1 como el defensor de la zona y player 2 como el retador
if (isset ( $_GET ['v1'] ) && isset ( $_GET ['v2'] )) {
	if ($_GET ['v1'] >= $_GET ['v2']) {
		// Se mantiene la zona tal cual está
		$response ['fight_output'] = 'Defender won.';
		$reponse ['message'] = 1;
	} else {
		$response ['fight_output'] = 'Attacker won.';
		$reponse ['message'] = 1;
	}
} else {
	$response ['message'] = 0;
}
echo json_encode ( $response );
?>