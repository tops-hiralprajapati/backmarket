<?php

namespace Tops\BackmarketApi\Api;

use Illuminate\Support\Facades\Http;

class BaseApi
{
    protected $apiUrl;
    protected $apiKey;
    protected $secretKey;

    /**
     * Initialize backMarket credentials and base configurations.
     *
     * This method initializes the necessary API credentials and configurations such as the API endpoint,
     * API key, secret key, and seller ID to be used for making requests to the backMarket API.
     *
     * @param array $config Configuration array containing API endpoint, API key, secret key, and seller ID.
    */
    public function init($config = [])
    {
        $this->apiUrl    = $config['api_endpoint'] ?? null;
        $this->apiKey    = $config['api_key'] ?? null;
        $this->secretKey = $config['secret_key'] ?? null;
        $this->sellerId  = $config['seller_id'] ?? null;
    }

    /**
     * Build the full URL with seller ID and additional query parameters.
     *
     * This helper method constructs the full URL required for the API request, including the seller ID
     * and any additional query parameters.
     *
     * @param string $endpoint The endpoint URL to append to the base API URL.
     * @param array $params Optional additional query parameters to include in the URL.
     * @return string The fully constructed URL with query parameters.
    */
    protected function buildUrl($endpoint, $params = [])
    {
        $queryParams = ['sellerid' => $this->sellerId];

        if (!empty($params)) {
            $queryParams = array_merge($queryParams, $params);
        }

        return $this->apiUrl . $endpoint . '?' . http_build_query($queryParams);
    }

    /**
     * Make an HTTP request.
     *
     * This method sends a request to the specified endpoint using the specified HTTP method (GET, POST, etc.)
     * and request payload. It also handles adding necessary headers and error handling for API responses.
     *
     * @param string $baseUrl The endpoint URL to send the request to.
     * @param string $method The HTTP method to use for the request (GET, POST, etc.).
     * @param array $reqPayload The data to be sent with the request (optional).
     * @param array $params Optional query parameters to append to the URL.
     * @return array An associative array containing the status, data, and response status code.
    */
    public function makeRequest($baseUrl, $method = 'GET', $reqPayload = [], $params = [])
    {
        try {

            $url = $this->buildUrl($baseUrl, $params);
            
            // If extra parameters are provided, merge them with seller ID
            if (!empty($params)) {
                $queryParams = array_merge($queryParams, $params);
            }

            // Configure headers
            $headers = [
                'Authorization' => $this->apiKey,
                'SecretKey'     => $this->secretKey,
                'Content-Type'  => 'application/json',
                'Accept'        => 'application/json',
            ];
            
            // Create and send the request
            $response = Http::withHeaders($headers)->$method($url, $reqPayload);

            // Check if the response is successful
            if ($response->successful()) {
                return [
                    'status'      => 'success',
                    'data'        => $response->body(),
                    'status_code' => 200
                ];
            }

            return [
                'status'      => 'error',
                'message'     => $response->body(),
                'status_code' => $response->status(),
            ];

        }catch (\Exception $e) {
            
            $statusCode = method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 500;
            
            return [
                'status'      => 'error',
                'message'     => $e->getMessage(),
                'status_code' => $statusCode,
            ];
        }
    }
}
