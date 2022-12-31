<?php

namespace BFST\Order;

use Exception;

class OrderList
{

    /**
     * @param int $page
     * @param int $limit
     * @param array $filters {
     *      orderID: int
     * }
     * @param array $params {
     *      returnAsObjects: bool
     * }
     * @return array
     * @throws Exception
     */
    public function listOrders(int $page, int $limit, array $filters = [], array $params = []): array
    {
        $orderFilter = new OrderFilter();
        $orderFilter->setFilterParams(new OrderFilterParams($filters));

        if (!$orderFilter->fetchOrders($page, $limit)) {
            return ['message' => 'Brak zamówień'];
        }

        if (isset($params['returnAsObjects']) && $params['returnAsObjects'] === true) {
            //TODO: Return Array<Order>
            return [];
        }

        return $orderFilter->getOrders();
    }
}