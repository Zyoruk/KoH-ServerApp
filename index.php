<?php
	header("Content-Type:application/json");
	include("functions.php");
	if(!empty($_GET['request_param1'])){
		deliver_response(200, "Request Accepted", "the request was complete");
	}else{
		deliver_response(400, "Invalid Request", NULL);
	}
	
	function deliver_response($status, $status_message, $information){
		header("HTTP/1.1 $status $status_message");
		$response['status'] = $status;
		$response['status_message'] = $status_message;
		$response['information'] = $information;
		
		$json_response= json_encode($response);
		echo $json_response;
	}
?>