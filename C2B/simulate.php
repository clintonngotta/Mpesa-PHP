<?php
  $headers = ['Content-Type:application/json; charset=utf8'];

  $consumerKey = 'uwd4VCfOjYcpawEsAYAkRyUYKRgCBdJ7';
  $consumerSecret = 'cq1hvOrJMyQYtgHU';
  $tokenurlurl = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

  $curl = curl_init($tokenurlurl);
  curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($curl, CURLOPT_HEADER, FALSE);
  curl_setopt($curl, CURLOPT_USERPWD, $consumerKey.':'.$consumerSecret);
  $result = curl_exec($curl);
  $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
  $result = json_decode($result);

  $access_token = $result->access_token;

  $simulateurl = 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/simulate';  
  $ShortCode  = '600256'; 
  $amount     = '1';
  $msisdn     = '254708374149';
  $billRef    = 'Rent Payment'; 

  $curlsimulate = curl_init();
  curl_setopt($curlsimulate, CURLOPT_URL, $simulateurl);
  curl_setopt($curlsimulate, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$access_token));


  $curl_post_data = array(
         'ShortCode' => $ShortCode,
         'CommandID' => 'CustomerPayBillOnline',
         'Amount' => $amount,
         'Msisdn' => $msisdn,
         'BillRefNumber' => $billRef
  );

  $data_string = json_encode($curl_post_data);
  curl_setopt($curlsimulate, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curlsimulate, CURLOPT_POST, true);
  curl_setopt($curlsimulate, CURLOPT_POSTFIELDS, $data_string);
  $curl_response = curl_exec($curlsimulate);
  print_r($curl_response);

  echo $curl_response;
?>
