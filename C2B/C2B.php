<?php
require_once("../MpesaPayments.php");

$c2b = NEW MpesaPayments();
$accesstoken = $c2b->GenerateAccessToken();
$registerurl = $c2b->RegisterC2BUrl($accesstoken);

$register_url_response = json_decode($registerurl, true);
if($register_url_response['ResponseDescription'] == 'success'){
	$simulate_rquest = $c2b->SimulateC2B($accesstoken);
	print_r($simulate_rquest);
}else{
	print_r($register_url_response);
}

?>