<?php

//Definidos player 1 como el defensor de la zona y player 2 como el retador
$pushes_1 = $_GET['v1'];
$pushes_2 = $_GET['v2'];

$player1 = $_GET['p1'];
$player2 = $_GET['p2'];

$response = array();
if ($pushes_1 >= $pushes_2 ){
	//Se mantiene la zona tal cual está
	$response['fight_output'] = 'Defense won.';
	$reponse['message'] = 1;
}else{
	$response['fight_output'] = 'Offensive won.';
	$reponse['message'] = 0;
}
echo json_encode($response);
?>