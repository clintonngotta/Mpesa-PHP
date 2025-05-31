# Mpesa-PHP

This project is a vanilla/native PHP implementation of the M-Pesa API based on the [Daraja documentation](https://developer.safaricom.co.ke/docs). It provides sample scripts for integrating with M-Pesa's C2B, B2C, B2B, STK Push, and Transaction Status APIs.

## Project Structure

- **MpesaPayments.php**: Main class for handling authentication and API requests.
- **C2B/**: Customer to Business (C2B) endpoint handlers and simulation.
- **B2C/**: Business to Customer (B2C) request and callback handlers.
- **B2B/**: Business to Business (B2B) request and callback handlers.
- **STKPUSH/**: STK Push request and callback handlers.
- **TransactionStatus/**: Transaction status query and result handler.
- **cert.cer**: Example certificate file for security credentials.

## Usage

### 1. Authentication

All API requests require an access token. The [`MpesaPayments`](MpesaPayments.php) class handles token generation:

```php
$mpesa = new MpesaPayments();
$accessToken = $mpesa->GenerateAccessToken();
```

### 2. C2B (Customer to Business)

- Register C2B URLs and simulate a payment in [`C2B/C2B.php`](C2B/C2B.php).
- Validation and confirmation callbacks are handled by [`C2B/validation_url.php`](C2B/validation_url.php) and [`C2B/confirmation.php`](C2B/confirmation.php).

### [C2B](https://developer.safaricom.co.ke/docs#c2b-api)

- This endpoint enables developers to receive real time notifications when a client makes a payments to a merchant's Till number or Paybill number. It assumes the payment are made via the SIM card toolkit and as a developer you need to know when that payment hits the merchants till/paybill number for reconciliation and accounting purposes.

### 3. B2C (Business to Customer)

- Initiate a B2C payment using [`B2C/B2CRequest.php`](B2C/B2CRequest.php).
- Callback responses are logged by [`B2C/B2CResult.php`](B2C/B2CResult.php).

### 4. B2B (Business to Business)

- Initiate a B2B payment using [`B2B/B2BRequest.php`](B2B/B2BRequest.php).
- Callback responses are logged by [`B2B/B2BResult.php`](B2B/B2BResult.php).

### 5. STK Push

- Initiate an STK Push using [`STKPUSH/StkPushRequest.php`](STKPUSH/StkPushRequest.php).
- Callback responses are handled by [`STKPUSH/callback.php`](STKPUSH/callback.php).

### 6. Transaction Status

- Query transaction status using [`TransactionStatus/QueryTransactionStatus.php`](TransactionStatus/QueryTransactionStatus.php).
- Callback responses are handled by [`TransactionStatus/TransactionStatusResult.php`](TransactionStatus/TransactionStatusResult.php).

## Notes

- Update callback URLs in [`MpesaPayments.php`](MpesaPayments.php) to point to your server.
- Database credentials in [`C2B/confirmation.php`](C2B/confirmation.php) must be set for transaction logging.
- Security credentials and certificates should be securely managed.

## References

- [Daraja API Documentation](https://developer.safaricom.co.ke/docs)
