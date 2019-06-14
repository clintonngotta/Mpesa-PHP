<?php
require_once("../MpesaPayments.php");
$stk = NEW MpesaPayments();
$accesstoken = $stk->GenerateAccessToken();
$response = $stk->TransactionStatusQuery($accesstoken);
print_r($response);