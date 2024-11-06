# Payvala

[![Build Status](https://scrutinizer-ci.com/g/circlecreative/payvala-php-sdk/badges/build.png?b=master)](https://scrutinizer-ci.com/g/circlecreative/payvala-php-sdk)
[![Code Quality](https://scrutinizer-ci.com/g/circlecreative/payvala-php-sdk/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/circlecreative/payvala-php-sdk)
[![Latest Version](https://poser.pugx.org/circlecreative/payvala-php-sdk/v/stable)](https://packagist.org/packages/circlecreative/payvala-php-sdk)
[![Total Downloads](https://poser.pugx.org/circlecreative/payvala-php-sdk/downloads)](https://packagist.org/packages/circlecreative/payvala-php-sdk)
[![License](https://poser.pugx.org/circlecreative/payvala-php-sdk/license)](https://packagist.org/packages/circlecreative/payvala-php-sdk)

`Payvala` is a PHP library to send messages through the Payvala API. This library uses `GuzzleHttp\Client` for HTTP communication with the Payvala API.

## Features

- **Easy Authentication**: Supports authentication with `accessKey`, `accessKeyId`, and `authCode`.
- **Message Sending**: Send messages with flexible parameters.
- **Response Handling**: Get clear responses with code and messages from the API.

## Installation

To install `Payvala`, you can use Composer:

```bash
composer require circlecreative/payvala-php-sdk
```

If you are using PHP without a framework, you can include the autoload file:

```php
require_once('path/to/circlecreative/payvala-php-sdk/src/autoload.php');
```

## Usage

### Using Payvala

```php
use App\Services\Payvala;

// Create an instance of Payvala
$service = new Payvala();

// Set credentials for authentication
$service->setAccessKey('your_access_key');
$service->setAccessKeyId('your_access_key_id');
$service->setAuthCode('your_auth_code');

// Send a message
$response = $service->sendMessage([
    'requestId' => 'unique_request_id',
    'deviceSn' => 'device_serial_number',
    'amount' => '100.00',
    'template' => 'message_template',
    'language' => 'en',
    'payer' => 'payer_info',
    'txnId' => 'txn_id',
    'channel' => 'channel_info',
    'timestamp' => time(),
    'transactingBank' => 'bank_name'
]);

// Handle the response
if (isset($response['error'])) {
    echo "Error: " . $response['error'];
} else {
    echo "Code: " . $response['code'];
    echo "Message: " . $response['message'];
    echo "Request ID: " . $response['requestId'];
    echo "Nonce: " . $response['nonce'];
}
```

## Methods

### `setAccessKey(string $accessKey)`

Sets the `accessKey` for authentication.

### `setAccessKeyId(string $accessKeyId)`

Sets the `accessKeyId` for authentication.

### `setAuthCode(string $authCode)`

Sets the `authCode` for authentication.

### `sendMessage(array $data): array`

Sends a message via the Payvala API with the provided data.

### API Response

```php
[
    'code' => 'response_code',
    'message' => 'response_message',
    'requestId' => 'returned_request_id',
    'nonce' => 'response_nonce',
    'error' => 'error_message' // If any error occurs
]
```

## Response Code List

| Code  | Message                                                                                      |
|-------|---------------------------------------------------------------------------------------------|
| 0001  | Delivered to Device                                                                         |
| 0002  | Broadcasted by Device                                                                       |
| 0003  | Delivered to Device and Broadcasted by Device                                               |
| 1001  | Invalid credentials (Access Key ID/Access Key/Auth Code)                                   |
| 1002  | Missing credentials (Access Key ID/Access Key/Auth Code)                                   |
| 1003  | Incorrect Parameter Value                                                                   |
| 1004  | Missing Mandatory parameter                                                                 |
| 1005  | Incorrect combination of template and language                                              |
| 1006  | Amount Invalid                                                                              |
| 2001  | Device Does not exist / not provisioned / Device Inactive                                  |
| 2002  | Device offline / delivery to device unsuccessful                                           |
| 3001  | MQTT system failure                                                                         |
| 3002  | API not available                                                                           |
| 3003  | API overflow                                                                                |
| 9000  | Other Error                                                                                 |

## License

This library is licensed under the [MIT License](LICENSE).

## Contributing

We welcome contributions from the community. If you'd like to contribute, please follow these steps:

1. Fork this repository
2. Create a branch for your new feature (`git checkout -b feature-new-feature`)
3. Commit your changes (`git commit -am 'Add new feature'`)
4. Push to the branch (`git push origin feature-new-feature`)
5. Open a pull request

## Contact

If you have any questions or need further assistance, please open an *issue* on the GitHub repository or contact us via email.