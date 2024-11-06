
# Payvala

[![Build Status](https://scrutinizer-ci.com/g/circlecreative/payvala-php-sdk/badges/build.png?b=master)](https://scrutinizer-ci.com/g/circlecreative/payvala-php-sdk)
[![Code Quality](https://scrutinizer-ci.com/g/circlecreative/payvala-php-sdk/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/circlecreative/payvala-php-sdk)
[![Latest Version](https://poser.pugx.org/circlecreative/payvala-php-sdk/v/stable)](https://packagist.org/packages/circlecreative/payvala-php-sdk)
[![Total Downloads](https://poser.pugx.org/circlecreative/payvala-php-sdk/downloads)](https://packagist.org/packages/circlecreative/payvala-php-sdk)
[![License](https://poser.pugx.org/circlecreative/payvala-php-sdk/license)](https://packagist.org/packages/circlecreative/payvala-php-sdk)

`Payvala` adalah library PHP untuk mengirimkan pesan melalui API Payvala. Library ini menggunakan `GuzzleHttp\Client` untuk melakukan komunikasi HTTP dengan API Payvala.

## Fitur

- **Otentikasi Mudah**: Mendukung otentikasi dengan `accessKey`, `accessKeyId`, dan `authCode`.
- **Pengiriman Pesan**: Kirim pesan dengan berbagai parameter yang fleksibel.
- **Penanganan Respons**: Mendapatkan respons yang jelas berupa kode dan pesan dari API.

## Instalasi

Untuk menginstal `Payvala`, Anda dapat menggunakan Composer:

```bash
composer require circlecreative/payvala-php-sdk
```

Jika Anda menggunakan PHP tanpa framework, Anda bisa mengikutkan file autoload:

```php
require_once('path/to/circlecreative/payvala-php-sdk/src/autoload.php');
```

## Penggunaan

### Menggunakan Payvala

```php
use App\Services\Payvala;

// Membuat instance dari Payvala
$service = new Payvala();

// Menetapkan kredensial untuk otentikasi
$service->setAccessKey('your_access_key');
$service->setAccessKeyId('your_access_key_id');
$service->setAuthCode('your_auth_code');

// Mengirim pesan
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

// Menangani respons
if (isset($response['error'])) {
    echo "Error: " . $response['error'];
} else {
    echo "Code: " . $response['code'];
    echo "Message: " . $response['message'];
    echo "Request ID: " . $response['requestId'];
    echo "Nonce: " . $response['nonce'];
}
```

## Metode

### `setAccessKey(string $accessKey)`

Menetapkan `accessKey` untuk otentikasi.

### `setAccessKeyId(string $accessKeyId)`

Menetapkan `accessKeyId` untuk otentikasi.

### `setAuthCode(string $authCode)`

Menetapkan `authCode` untuk otentikasi.

### `sendMessage(array $data): array`

Mengirim pesan melalui API Payvala dengan data yang disediakan.

### Respons API

```php
[
    'code' => 'response_code',
    'message' => 'response_message',
    'requestId' => 'returned_request_id',
    'nonce' => 'response_nonce',
    'error' => 'error_message' // Jika ada kesalahan
]
```

## Daftar Kode Respons

| Kode  | Pesan                                                                                      |
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

## Lisensi

Library ini dilisensikan di bawah [MIT License](LICENSE).

## Kontribusi

Kami menyambut kontribusi dari komunitas. Jika Anda ingin berkontribusi, harap lakukan hal berikut:

1. Fork repositori ini
2. Buat branch untuk fitur baru (`git checkout -b feature-new-feature`)
3. Commit perubahan Anda (`git commit -am 'Add new feature'`)
4. Push ke branch (`git push origin feature-new-feature`)
5. Buka pull request

## Kontak

Jika Anda memiliki pertanyaan atau membutuhkan bantuan lebih lanjut, silakan buat *issue* di repositori GitHub atau hubungi kami melalui email.