<?php

namespace Tops\BackmarketApi\Api;

use Illuminate\Support\Facades\Http;

class BaseApi
{
    protected $token;
    protected $apiUrl;
    protected $userAgent;
    protected $countryLang;

    /**
     * Initialize BackMarket API credentials and configurations.
     *
     * Sets up the API token and endpoint required for making requests to the BackMarket API.
     *
     * @param array $config Configuration array containing 'token','user_agent','language' and 'api_endpoint'.
    */
    public function init($config = [])
    {
        $this->token       = $config['token'] ?? null;
        $this->apiUrl      = $config['api_endpoint'] ?? null;
        $this->userAgent   = $config['user_agent'] ?? null;
        $this->countryLang = $config['language'] ?? null;
    }

    /**
     * Send an HTTP request to the BackMarket API.
     *
     * Makes an HTTP request using the specified method, payload, and optional query parameters.
     * Includes headers such as authorization and content type. Handles errors gracefully.
     *
     * @param string $baseUrl The API endpoint to send the request to.
     * @param string $method HTTP method to use (GET, POST, etc.). Default is 'GET'.
     * @param array $reqPayload Data to send in the request body (optional).
     * @param array $params Query parameters to append to the URL (optional).
     * @return array Associative array containing the request status, data, and HTTP status code.
     */
    public function makeRequest($baseUrl, $method = 'GET', $reqPayload = [], $params = [])
    {
        try {
            $url = $this->apiUrl . $baseUrl . '?' . http_build_query($params);

            // Set up request headers
            $headers = [
                'Content-Type'    => 'application/json',
                'Accept'          => 'application/json',
                'Accept-Language' =>  $this->countryLang,
                'Authorization'   => 'Basic ' . $this->token,
                'User-Agent'      => $this->userAgent, // Use your actual Seller or ERP name
            ];

            // Send the HTTP request
            if(!empty($reqPayload))
            {
                $response = Http::withHeaders($headers)->$method($url, $reqPayload);
            } else {
                $response = Http::withHeaders($headers)->$method($url);
            }

            // Handle a successful response
            if ($response->successful()) {
                return [
                    'status'      => 'success',
                    'data'        => $response->body(),
                    'status_code' => 200,
                ];
            }

            // Handle an error response
            return [
                'status'      => 'error',
                'message'     => $response->body(),
                'status_code' => $response->status(),
            ];
        } catch (\Exception $e) {
            $statusCode = method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 500;

            // Return exception details
            return [
                'status'      => 'error',
                'message'     => $e->getMessage(),
                'status_code' => $statusCode,
            ];
        }
    }
}
