<?php

namespace Tops\BackmarketApi\Api;

use Tops\BackmarketApi\Api\BaseApi;

class TaskApi extends BaseApi
{
    // Endpoint URLs for tasks-related APIs
    protected $getTaskStatusEndpoint  = "/ws/tasks/{taskId}";

    /**
     * Retrieve the status of a specific task status from the Backmarket API.
     *
     * Sends a GET request to fetch the task status for a specific task ID.
     * Optional query parameters can be provided.
     *
     * @param int|string $taskId The ID of the task to retrieve the status.
     * @param array $params Optional query parameters to append to the request.
     * @return array The API response containing the task status or an error message.
     * @author Hiral Prajapati <hiralprajapati@topsinfosolutions.com> | 25-12-2024
     * @link https://api.backmarket.dev/#/paths/ws-category-tree-categoryId/get
    */
    public function getTaskStatus($taskId = null, $params = [])
    {
        if(empty($taskId))
        {
            // Return exception details
            return [
                'status'      => 'error',
                'message'     => 'Task ID is missing. Please provide a valid task ID.',
                'status_code' => 400,  // HTTP 400 Bad Request
            ];
        }

        // Replace the {taskId} placeholder with the actual category ID
        $endpoint = str_replace('{taskId}', $taskId, $this->getTaskStatusEndpoint);

        return $this->makeRequest($endpoint, 'GET', [], $params);
    }
}
