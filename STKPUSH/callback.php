<?php
header("Content-Type: application/json");
$mpesaResponse = file_get_contents('php://input');
$jsonMpesaResponse = json_decode($mpesaResponse, true);
$logFile = "stkPushCallbackResponse.json";
$log = fopen($logFile, "a");
fwrite($log, $jsonMpesaResponse);
fclose($log);
?>