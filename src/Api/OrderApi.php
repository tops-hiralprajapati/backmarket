<?php

namespace Tops\BackmarketApi\Api;

use Tops\BackmarketApi\Api\BaseApi;

class OrderApi extends BaseApi
{
    // Endpoint URLs for order-related APIs
    protected $getOrderEndpoint              = "/ws/orders";
    protected $getOrderDetailEndpoint        = "/ws/orders/{order_id}";
    protected $orderUpdateEndpoint           = "/ws/orders/{order_id}";
    protected $updateCustomerInvoiceEndpoint = "/ws/orders/{order_id}/invoice";

    /**
     * Retrieve a list of orders from the API.
     *
     * Sends a GET request to fetch the list of orders based on optional query parameters.
     *
     * @param array $params Optional query parameters to filter the orders.
     * @return array The API response containing the list of orders or an error message.
     * @author Hiral Prajapati <hiralprajapati@topsinfosolutions.com> | 10-12-2024
     * @link https://api.backmarket.dev/#/operations/get-ws-list-order
    */
    public function getOrders($params = [])
    {
        return $this->makeRequest($this->getOrderEndpoint, 'GET', [], $params);
    }

    /**
     * Retrieve details of a specific order from the API.
     *
     * Sends a GET request to fetch the details of an order by its ID. 
     * Returns an error if the order ID is missing.
     *
     * @param int|string $orderId The ID of the order to retrieve.
     * @param array $params Optional query parameters to append to the request.
     * @return array The API response containing order details or an error message.
     * @author Hiral Prajapati <hiralprajapati@topsinfosolutions.com> | 10-12-2024
     * @link https://api.backmarket.dev/#/operations/get-ws-specific-order
    */
    public function getOrderDetails($orderId = null, $params = [])
    {
        if(empty($orderId))
        {
            // Return exception details
            return [
                'status'      => 'error',
                'message'     => 'Order ID is missing. Please provide a valid order ID.',
                'status_code' => 400,  // HTTP 400 Bad Request
            ];
        }

        // Replace the {order_id} placeholder with the actual Order ID
        $endpoint = str_replace('{order_id}', $orderId, $this->getOrderDetailEndpoint);

        return $this->makeRequest($endpoint, 'GET', [], $params);
    }


    /**
     * Update a specific order in the API.
     *
     * Sends a POST request to update the details of an order identified by its ID.
     * Optional parameters can be provided to specify the update details.
     * Returns an error response if the order ID is missing.
     *
     * @param int|string $orderId The ID of the order to update.
     * @param array $params Optional parameters to specify the update details.
     * @return array The API response confirming the update or an error message.
     * @author Hiral Prajapati <hiralprajapati@topsinfosolutions.com> | 11-12-2024
     * @link https://api.backmarket.dev/#/operations/update-ws-specific-order
    */
    public function updateOrder($orderId = null, $params = [])
    {
        if(empty($orderId))
        {
            // Return exception details
            return [
                'status'      => 'error',
                'message'     => 'Order ID is missing. Please provide a valid order ID.',
                'status_code' => 400,  // HTTP 400 Bad Request
            ];
        }

        // Replace the {order_id} placeholder with the actual Order ID
        $endpoint = str_replace('{order_id}', $orderId, $this->getOrderUpdateEndpoint);

        return $this->makeRequest($endpoint, 'POST', [], $params);
    }

    /**
     * Update the customer's invoice for a specific order.
     *
     * Sends a POST request to update the invoice details of an order by its ID.
     * Returns an error if the order ID is missing.
     *
     * @param int|string $orderId The ID of the order whose invoice is to be updated.
     * @param array $params Optional parameters for the invoice update.
     * @return array The API response confirming the update or an error message.
     * @author Hiral Prajapati <hiralprajapati@topsinfosolutions.com> | 11-12-2024
     * @link https://api.backmarket.dev/#/operations/post-ws-specific-order-invoice
    */
    public function updateCustomerOrderInvoice($orderId = null, $params = [])
    {
        if(empty($orderId))
        {
            // Return exception details
            return [
                'status'      => 'error',
                'message'     => 'Order ID is missing. Please provide a valid order ID.',
                'status_code' => 400,  // HTTP 400 Bad Request
            ];
        }

        // Replace the {order_id} placeholder with the actual Order ID
        $endpoint = str_replace('{order_id}', $orderId, $this->updateCustomerInvoiceEndpoint);

        return $this->makeRequest($endpoint, 'POST', [], $params);
    }
}