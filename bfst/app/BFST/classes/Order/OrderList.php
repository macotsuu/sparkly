<?php

namespace Order;

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
    public function listOrders(array $filters = [], array $params = []): array
    {
        $orderFilter = new OrderFilter();
        $orderFilter->setFilterParams(new OrderFilterParams($filters));

        if (!$orderFilter->fetchOrders(0, 100)) {
            return ['message' => 'Brak zamówień'];
        }

        if (isset($params['returnAsObjects']) && $params['returnAsObjects'] === true) {
            //TODO: Return Array<Order>
            return [];
        }

        return $orderFilter->getOrders();
    }
}