<?php

namespace Sparkly\Order\Application\SearchOrder;

use Sparkly\Order\Domain\Order\OrderList;

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