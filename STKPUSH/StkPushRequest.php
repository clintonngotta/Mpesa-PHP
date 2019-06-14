<?php
require_once("../MpesaPayments.php");
$stk = NEW MpesaPayments();
$accesstoken = $stk->GenerateAccessToken();
$response = $stk->StkPushRequest($accesstoken);
print_r($response);