<?php
    require_once("../MpesaPayments.php");
    $b2c = NEW MpesaPayments();
    $accesstoken = $b2c->GenerateAccessToken();
    $response = $b2c->B2C($accesstoken);
    print_r($response);
?>