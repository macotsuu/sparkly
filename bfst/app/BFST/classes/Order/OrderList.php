<?php

namespace BFST\Order;

use Exception;

class OrderList
{

    /**
     * @throws Exception
     */
    public function listOrders(array $params): array
    {
        $orderFilter = new OrderFilter($params);
        return $orderFilter->getOrders();
    }
}