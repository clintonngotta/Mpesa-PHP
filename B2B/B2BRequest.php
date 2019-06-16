<?php
    require_once("../MpesaPayments.php");
    $b2b = NEW MpesaPayments();
    $accesstoken = $b2b->GenerateAccessToken();
    $response = $b2b->B2B($accesstoken);
    print_r($response);
?>