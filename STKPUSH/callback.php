<?php
header("Content-Type: application/json");
$callbackJSONData = file_get_contents('php://input');
$jsonMpesaResponse = json_decode($mpesaResponse, true);
$logFile = "stkPushCallbackResponse.json";
$log = fopen($logFile, "a");
fwrite($log, $jsonMpesaResponse);
fclose($log);

$callbackData=json_decode($callbackJSONData);
$resultCode=$callbackData->Body->stkCallback->ResultCode;
$resultDesc=$callbackData->Body->stkCallback->ResultDesc;
$merchantRequestID=$callbackData->Body->stkCallback->MerchantRequestID;
$checkoutRequestID=$callbackData->Body->stkCallback->CheckoutRequestID;

$amount=$callbackData->stkCallback->Body->CallbackMetadata->Item[0]->Value;
$mpesaReceiptNumber=$callbackData->Body->stkCallback->CallbackMetadata->Item[1]->Value;
$balance=$callbackData->stkCallback->Body->CallbackMetadata->Item[2]->Value;
$b2CUtilityAccountAvailableFunds=$callbackData->Body->stkCallback->CallbackMetadata->Item[3]->Value;
$transactionDate=$callbackData->Body->stkCallback->CallbackMetadata->Item[4]->Value;
$phoneNumber=$callbackData->Body->stkCallback->CallbackMetadata->Item[5]->Value;

$result=[
    "resultDesc"=>$resultDesc,
    "resultCode"=>$resultCode,
    "merchantRequestID"=>$merchantRequestID,
    "checkoutRequestID"=>$checkoutRequestID,
    "amount"=>$amount,
    "mpesaReceiptNumber"=>$mpesaReceiptNumber,
    "balance"=>$balance,
    "b2CUtilityAccountAvailableFunds"=>$b2CUtilityAccountAvailableFunds,
    "transactionDate"=>$transactionDate,
    "phoneNumber"=>$phoneNumber
];
echo json_encode($result);
?>
?>