<?php

namespace Tops\BackmarketApi\Api;

use Tops\BackmarketApi\Api\BaseApi;

class CategoryApi extends BaseApi
{
    // Endpoint URLs for category-related APIs
    protected $getCategoryTreeEndpoint    = "/ws/category/tree";
    protected $getCategoryBranchEndpoint  = "/ws/category/tree/{categoryId}";

    /**
     * Retrieve the category tree from the API.
     *
     * Sends a GET request to fetch the category hierarchy. Additional query parameters can be included if needed.
     *
     * @param array $params Optional query parameters to include in the request.
     * @return array The API response containing the category tree or an error message.
     * @author Hiral Prajapati <hiralprajapati@topsinfosolutions.com> | 05-12-2024 
     * @link https://api.backmarket.dev/#/operations/get-bm-catalog-category
    */
    public function getCategoryTree($params = [])
    {
        return $this->makeRequest($this->getCategoryTreeEndpoint, 'GET', [], $params);
    }

    /**
     * Retrieve a specific category branch from the API.
     *
     * Sends a GET request to fetch the category hierarchy for a specific category ID.
     * Optional query parameters can be provided.
     *
     * @param int|string $categoryId The ID of the category to retrieve.
     * @param array $params Optional query parameters to append to the request.
     * @return array The API response containing the category branch or an error message.
     * @author Hiral Prajapati <hiralprajapati@topsinfosolutions.com> | 05-12-2024
     * @link https://api.backmarket.dev/#/paths/ws-category-tree-categoryId/get
    */
    public function getCategoryBranch($categoryId = null, $params = [])
    {
        if(empty($categoryId))
        {
            // Return exception details
            return [
                'status'      => 'error',
                'message'     => 'Category Id is missing.',
                'status_code' => 400,  // HTTP 400 Bad Request
            ];
        }

        // Replace the {categoryId} placeholder with the actual category ID
        $endpoint = str_replace('{categoryId}', $categoryId, $this->getCategoryBranchEndpoint);

        return $this->makeRequest($endpoint, 'GET', [], $params);
    }
}
