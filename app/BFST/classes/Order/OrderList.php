<?php

namespace Order;

use Exception;

class OrderList
{
    /**
     * @param array $filters {
     *      orderID: int
     * }
     * @param array $params {
     *      returnAsObjects: bool
     * }
     * @return array<int, array>
     * @throws Exception
     */
    public function listOrders(array $filters, array $params = []): array
    {
        $orderFilter = new OrderFilters($filters);
        $orderFilter->fetchOrders($orderFilter->page, $orderFilter->limit);

        if (isset($params['returnAsObjects']) && $params['returnAsObjects'] === true) {
            //TODO: Return Array<Order>
            return [];
        }

        return $orderFilter->getOrders();
    }
}
