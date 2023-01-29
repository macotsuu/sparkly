<?php

namespace BFST\Order\Application\SearchOrder;

use BFST\Order\Domain\Order\OrderList;

class SearchOrderAction
{
    public function handle(): array
    {
        return (new OrderList())
            ->setFilter($_GET)
            ->fetchOrders()
            ->getOrders();
    }
}