<?php

use PHPUnit\Framework\TestCase;
use CircleCreative\Payvala;  // Sesuaikan dengan namespace yang Anda gunakan

class PayvalaTest extends TestCase
{
    protected $payvala;

    protected function setUp(): void
    {
        // Membuat instance dari Payvala untuk pengujian
        $this->payvala = new Payvala();
        $this->payvala->setAccessKey("test-access-key");
        $this->payvala->setAccessKeyId("test-access-key-id");
        $this->payvala->setAuthCode("test-auth-code");
    }

    public function testSetAccessKey()
    {
        $this->payvala->setAccessKey("new-access-key");
        $this->assertEquals("new-access-key", $this->payvala->accessKey);
    }

    public function testSetAccessKeyId()
    {
        $this->payvala->setAccessKeyId("new-access-key-id");
        $this->assertEquals("new-access-key-id", $this->payvala->accessKeyId);
    }

    public function testSetAuthCode()
    {
        $this->payvala->setAuthCode("new-auth-code");
        $this->assertEquals("new-auth-code", $this->payvala->authCode);
    }

    public function testSendMessage()
    {
        // Simulasi respons dari API menggunakan data pesan
        $data = [
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
        ];

        $response = $this->payvala->sendMessage($data);

        // Asersi dasar pada struktur respons
        $this->assertIsArray($response);
        $this->assertArrayHasKey('code', $response);
        $this->assertArrayHasKey('message', $response);
        $this->assertArrayHasKey('requestId', $response);
        $this->assertArrayHasKey('nonce', $response);
    }

    public function testSendMessageWithError()
    {
        // Kirim data yang tidak lengkap untuk memicu kesalahan
        $data = [
            'requestId' => 'unique_request_id',
            'deviceSn' => 'device_serial_number',
            'amount' => '100.00',
            // Hilangkan 'template' atau 'language' untuk memicu kesalahan
        ];

        $response = $this->payvala->sendMessage($data);

        // Pastikan ada pesan error dalam respons
        $this->assertIsArray($response);
        $this->assertArrayHasKey('error', $response);
        $this->assertNotEmpty($response['error']);
    }
}