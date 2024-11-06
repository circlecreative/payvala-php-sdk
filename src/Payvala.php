<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

/**
 * Class Payvala
 * Service class to handle sending messages to the Payvala API.
 */
class Payvala
{
    /**
     * @var Client $client
     * The HTTP client used to send requests to the Payvala API.
     */
    protected $client;

    /**
     * @var string $accessKey
     * The access key required for API authentication, set via setter method.
     */
    protected $accessKey;

    /**
     * @var string $accessKeyId
     * The access key ID required for API authentication, set via setter method.
     */
    protected $accessKeyId;

    /**
     * @var string $authCode
     * The authorization code required for API authentication, set via setter method.
     */
    protected $authCode;

    /**
     * Payvala constructor.
     * Initializes the HTTP client.
     */
    public function __construct()
    {
        // Initialize the Guzzle HTTP client with the base URL and timeout for API requests
        $this->client = new Client([
            'base_uri' => 'https://stage-api.payvala.com',
            'timeout'  => 10.0,
        ]);
    }

    /**
     * Sets the access key.
     *
     * @param string $accessKey The access key for API authentication.
     */
    public function setAccessKey(string $accessKey)
    {
        $this->accessKey = $accessKey;
    }

    /**
     * Sets the access key ID.
     *
     * @param string $accessKeyId The access key ID for API authentication.
     */
    public function setAccessKeyId(string $accessKeyId)
    {
        $this->accessKeyId = $accessKeyId;
    }

    /**
     * Sets the authorization code.
     *
     * @param string $authCode The authorization code for API authentication.
     */
    public function setAuthCode(string $authCode)
    {
        $this->authCode = $authCode;
    }

    /**
     * Sends a message to the Payvala API.
     *
     * @param array $data The data to be sent in the API request.
     * @return array Response data with a code message or an error message on failure.
     */
    public function sendMessage(array $data)
    {
        // Set up the required fields for the API request
        $payload = [
            'accessKey' 	=> $this->accessKey,               	// Required: Access key
            'accessKeyId' 	=> $this->accessKeyId,           	// Required: Access key ID
            'authCode' 		=> $this->authCode,                 // Required: Authorization code
            'requestId' 	=> $data['requestId'],             	// Required: Unique request ID
            'deviceSn' 		=> $data['deviceSn'],               // Required: Device serial number
            'amount' 		=> $data['amount'],                 // Required: Transaction amount
            'template' 		=> $data['template'],               // Required: Template for display format
            'language' 		=> $data['language'],               // Required: Language code
        ];

        // Add optional fields to the payload if they are present
        if (isset($data['payer'])) $payload['payer'] = $data['payer'];
        if (isset($data['txnId'])) $payload['txnId'] = $data['txnId'];
        if (isset($data['channel'])) $payload['channel'] = $data['channel'];
        if (isset($data['timestamp'])) $payload['timestamp'] = $data['timestamp'];
        if (isset($data['transactingBank'])) $payload['transactingBank'] = $data['transactingBank'];

        try {
            // Send the POST request to the /message/send endpoint with the JSON payload
            $response = $this->client->post('/message/send', [
                'json' => $payload,
            ]);

            // Decode the JSON response body into an associative array
            $responseBody = json_decode($response->getBody(), true);

            // Get the code from the response and determine the message based on the code
            $code = $responseBody['code'] ?? null;
            $message = $this->getCodeMessage($code);

            // Return the specific response fields needed by the application
            return [
                'code' 		=> $code,
                'message' 	=> $message,
                'requestId' => $responseBody['requestId'] ?? null,
                'nonce' 	=> $responseBody['nonce'] ?? null,
            ];

        } catch (RequestException $e) {
            // Handle any errors during the API request
            return [
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Get the message corresponding to the return code from the API response.
     *
     * @param string|null $code The return code from the API response.
     * @return string The message corresponding to the code.
     */
    private function getCodeMessage($code)
    {
        // Define the possible return codes and their messages
        $messages = [
            '0001' => 'Delivered to Device',
            '0002' => 'Broadcasted by Device',
            '0003' => 'Delivered to Device and Broadcasted by Device',
            '1001' => 'Invalid credentials (Access Key ID/Access Key/Auth Code)',
            '1002' => 'Missing credentials (Access Key ID/Access Key/Auth Code)',
            '1003' => 'Incorrect Parameter Value',
            '1004' => 'Missing Mandatory parameter',
            '1005' => 'Incorrect combination of template and language',
            '1006' => 'Amount Invalid',
            '2001' => 'Device Does not exist / not provisioned / Device Inactive',
            '2002' => 'Device offline / delivery to device unsuccessful',
            '3001' => 'MQTT system failure',
            '3002' => 'API not available',
            '3003' => 'API overflow',
            '9000' => 'Other Error',
        ];

        // Return the message corresponding to the code, or a default message if the code is not recognized
        return $messages[$code] ?? 'Unknown Error';
    }
}