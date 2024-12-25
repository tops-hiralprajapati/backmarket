<?php

namespace Tops\BackmarketApi\Api;

use Tops\BackmarketApi\Api\BaseApi;

class ListingApi extends BaseApi
{
    // Endpoint URLs for listing-related actions
    protected $listingEndpoint         = "/ws/listings";
    protected $specificListingEndpoint = "/ws/listings/{listingId}";

    /**
     * Retrieve the product listings from the API.
     *
     * Sends a GET request to fetch the product listings available under the authenticated account.
     *
     * @param array $params Optional additional query parameters to be appended to the URL.
     * @return array The response from the API request (success or error).
     * @author Hiral Prajapati <hiralprajapati@topsinfosolutions.com> | 28-11-2024
     * @link https://api.backmarket.dev/#/paths/ws-listings/get
    */
    public function getListing($params = [])
    {
        return $this->makeRequest($this->listingEndpoint, 'GET', [], $params);
    }

    /**
     * Retrieve details of a specific listing.
     *
     * This function sends a GET request to the API to retrieve information about a specific listing
     * using the provided listing ID and optional query parameters. If the listing ID is missing,
     * it returns an error response with a status code of 400.
     *
     * @param int|string|null $listingId The ID of the listing to retrieve. It must not be empty.
     * @param array $params Optional additional query parameters to be appended to the request URL.
     *                       For example, filters or pagination parameters.
     * @return array The response from the API request (success or error).
     * @throws \Exception If the API request fails for reasons other than a missing listing ID.
     * @author Mahendra Sundesha <mahendera.sundesha@topsinfosolutions.com> | 10-12-2024
     * @link https://api.backmarket.dev/#/paths/ws-listings-listingId/get
    */
    public function getSpecificListing($listingId = null, $params = [])
    {
        if(empty($listingId))
        {
            // Return exception details
            return [
                'status'      => 'error',
                'message'     => 'Listing ID is missing. Please provide a valid listing ID.',
                'status_code' => 400,  // HTTP 400 Bad Request
            ];
        }

        // Replace the {listingId} placeholder with the actual category ID
        $endpoint = str_replace('{listingId}', $listingId, $this->specificListingEndpoint);
        return $this->makeRequest($endpoint, 'GET', [], $params);
    }

    /**
     * Update details of a specific listing.
     *
     * This function sends a POST request to the API to update the details of a specific listing.
     * It requires the listing ID and the request payload containing the update data. 
     * Optional query parameters can also be appended to the request URL.
     * If the listing ID or the request payload is missing, it returns an error response with a status code of 400.
     *
     * @param int|string|null $listingId The ID of the listing to update. It must not be empty.
     * @param array $reqPayload The data payload containing fields to update in the listing.
     *                          Example: ['name' => 'Updated Listing', 'price' => 100.00].
     * @param array $params Optional additional query parameters to be appended to the request URL.
     *                       For example, filters or pagination parameters.
     * @return array The response from the API request (success or error).
     * @throws \Exception If the API request fails for reasons other than missing input parameters.
     * @author Mahendra Sundesha <mahendera.sundesha@topsinfosolutions.com> | 10-12-2024
     * @link https://api.backmarket.dev/#/paths/ws-listings-listingId/post
    */
    public function updateSpecificListing($listingId = null, $reqPayload, $params = [])
    {
        if (empty($listingId) || empty($reqPayload)) {
            return [
                'status'      => 'error',
                'message'     => empty($listingId) ? 'Listing ID is missing. Please provide a valid listing ID.' : 'Request parameters are missing.',
                'status_code' => 400, // HTTP 400 Bad Request
            ];
        }

        // Replace the {listingId} placeholder with the actual category ID
        $endpoint = str_replace('{listingId}', $listingId, $this->specificListingEndpoint);
        return $this->makeRequest($endpoint, 'POST', $reqPayload, $params);
    }
}
