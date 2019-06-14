<?php
header("Content-Type: application/json");
$callbackJSONData = file_get_contents('php://input');
$callbackData = json_decode($mpesaResponse, true);
$logFile = "TransactionStatusResult.json";
$log = fopen($logFile, "a");
fwrite($log, $callbackData);
fclose($log);


$resultCode=$callbackData->Result->ResultCode;
$resultDesc=$callbackData->Result->ResultDesc;
$OriginatorConversationID=$callbackData->Result->OriginatorConversationID;
$ConversationID=$callbackData->Result->ConversationID;
$TransactionID = $callbackData->Result->TransactionID;
$ReceiptNo = $callbackData->Result->ResultParameters->ResultParameter[0]->value;
$TransactionTime = $callbackData->Result->ResultParameters->ResultParameter[2]->value;
$amount = $callbackData->Result->ResultParameters->ResultParameter[3]->value;
$TransactionStatus = $callbackData->Result->ResultParameters->ResultParameter[4]->value;
$ReasonType = $callbackData->Result->ResultParameters->ResultParameter[5]->value;
$DebitPartyCharges = $callbackData->Result->ResultParameters->ResultParameter[6]->value;
$clientname = $callbackData->Result->ResultParameters->ResultParameter[10]->value;
$bussinessname = $callbackData->Result->ResultParameters->ResultParameter[11]->value;
