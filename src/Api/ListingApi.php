<?php

namespace Tops\BackmarketApi\Api;

use Tops\BackmarketApi\Api\BaseApi;

class ListingApi extends BaseApi
{
    // Endpoint URLs for report-related actions
    protected $listingEndpoint    = "/ws/listings";

    /**
     * Submit a report request to the API.
     *
     * This function sends a POST request to the `submitReportUrl` with the provided request data and parameters.
     *
     * @param array $reqData The data to be sent with the request.
     * @param array $params Optional additional query parameters to be appended to the URL.
     * @return array The response from the API request (success or error).
     * @author Hiral Prajapati <hiralprajapati@topsinfosolutions.com> | 28-11-2024
     * @link https://developer.newegg.com/newegg_marketplace_api/reports_management/submit_report_request/
    */
    public function getListing($params = [])
    {
        return $this->makeRequest($this->listingEndpoint, 'GET', [], $params);
    }
}
