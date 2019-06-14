<?php
class MpesaPayments 
{
    public $consumerKey = 'uwd4VCfOjYcpawEsAYAkRyUYKRgCBdJ7';
    public $consumerSecret = 'cq1hvOrJMyQYtgHU';
    public $access_token = '';
    public $ShortCode = '600256';
    public $accessTokenUrl = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

    public function __construct(){
       $this->access_token = $this->GenerateAccessToken();
    }

    public function GenerateAccessToken()
    {
        $curl = curl_init($this->accessTokenUrl);
        $headers = ['Content-Type:application/json; charset=utf8'];
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_HEADER, FALSE);
        curl_setopt($curl, CURLOPT_USERPWD, $this->consumerKey.':'.$this->consumerSecret);
        $result = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $result = json_decode($result);
        $access_token = $result->access_token;
        return $access_token;
    }

    public function RegisterC2BUrl($access_token)
    {
        $headers = ['Content-Type:application/json; charset=utf8'];
        $url = 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/registerurl';
        $shortCode = '600256'; 
        $validationUrl = 'https://www.boondoproperties.co.ke/MpesaApi/C2B/validation_url.php';
        $confirmationUrl ='https://www.boondoproperties.co.ke/MpesaApi/C2B/confirmation.php';
        $data = array(
          'ShortCode' => $shortCode,
          'ResponseType' => 'Confirmed',
          'ConfirmationURL' => $confirmationUrl,
          'ValidationURL' => $validationUrl
        );

        $headers = array('Content-Type:application/json','Authorization:Bearer '.$access_token);
        $response  = $this->ProcessRequest($data, $headers, $url);
        return $response;
    }

    public function SimulateC2B($access_token)
    {
        $headers = array('Content-Type:application/json','Authorization:Bearer '.$access_token);
        $simulateurl = 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/simulate';  
        $ShortCode  = '600256'; 
        $amount     = '1';
        $msisdn     = '254708374149';
        $billRef    = 'Rent Payment'; 

        $data = array(
             'ShortCode' => $ShortCode,
             'CommandID' => 'CustomerPayBillOnline',
             'Amount' => $amount,
             'Msisdn' => $msisdn,
             'BillRefNumber' => $billRef
        );
        $response  = $this->ProcessRequest($data, $headers, $simulateurl);
        return $response;
    }

    public function StkPushRequest($access_token)
    {
        date_default_timezone_set('Africa/Nairobi');
        $ShortCode = '174379';
        $Passkey = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';
        $Timestamp = date('YmdHis');    
        $Password = base64_encode($ShortCode.$Passkey.$Timestamp);
        $PartyA = '254713229184';
        $AccountReference = 'tes123';
        $TransactionDesc = 'Payrent';
        $Amount = '1';
        $initiate_url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
        $CallBackURL = 'https://www.boondoproperties.co.ke/MpesaApi/STKPUSH/callback.php';
        $headers = array('Content-Type:application/json','Authorization:Bearer '.$access_token);
        $data = array(
            'BusinessShortCode' => $ShortCode,
            'Password' => $Password,
            'Timestamp' => $Timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => $Amount,
            'PartyA' => $PartyA,
            'PartyB' => $ShortCode,
            'PhoneNumber' => $PartyA,
            'CallBackURL' => $CallBackURL,
            'AccountReference' => $AccountReference,
            'TransactionDesc' => $TransactionDesc
          );

        $response  = $this->ProcessRequest($data, $headers, $initiate_url);
        return $response;
    }

    public function TransactionStatusQuery($access_token)
    {
        $headers = array('Content-Type:application/json','Authorization:Bearer '.$access_token);
        $ResultURL = 'https://www.boondoproperties.co.ke/MpesaApi/TransactionStatus/TransactionStatusResult.php';
        $QueueTimeOutURL = 'https://www.boondoproperties.co.ke/MpesaApi/TransactionStatus/TransactionStatusResult.php';
        $shortCode = '600256';
        $TransactionId = 'NFC41H8NZU';
        $Msisdn = '254708374149';
        $Initiator ='apitest382';
        $Remarks = 'Rent P';
        $SecurityCredential = 'N3rRIwOaGr2qo/dc6ZwoqjoYQermkRxIhdabI2nMcx7GXYcdR0br2tPScyyJasjWWBHDcgk7z2rg7V99gOL1ZyVpAllWAnxtN0MfZ4RUaHruMhIGIe9/2cUqQN742aVkLrNPYmKCePuHoJRpbhh46iFTeR4lTQuchcFky3pn1zkfCVqcyMZZXftmVKdu5yUi36HVmjQkbhjoHiaTkvZU5bKrRB3ejsuM4uLbTRbGxa4tP1NObTAzXuU2lewmxksede3Vkm6PwspL8+TURE4EFWIm+11CZShkYVDVQLjTyqvtKAIufy7iLvSBuc/+28QHSbq4FumxVFV9rX9VpZu0vA==';

        $url = 'https://sandbox.safaricom.co.ke/mpesa/transactionstatus/v1/query';
        $data = array(
          'Initiator' => $Initiator,
          'SecurityCredential' => $SecurityCredential,
          'CommandID' => 'TransactionStatusQuery',
          'TransactionID' => $TransactionId,
          'PartyA' => $shortCode,
          'IdentifierType' => '4',
          'ResultURL' => $ResultURL,
          'QueueTimeOutURL' => $QueueTimeOutURL,
          'Remarks' => $Remarks,
          'Occasion' => ''
        );

        $response  = $this->ProcessRequest($data, $headers, $url);
        return $response;
    }
    public function ProcessRequest($data, $headers, $url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $data = json_encode($data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        $response = curl_exec($curl);
        return $response;
    }

}

?>