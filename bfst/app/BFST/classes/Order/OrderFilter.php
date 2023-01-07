<?php

namespace Order;

use Exception;
use Volcano\Database\MySQL;

class OrderFilter
{
    private OrderFilterParams $params;
    private array $orders;

    public function setFilterParams(OrderFilterParams $params): self
    {
        $this->params = $params;

        return $this;
    }

    /**
     * @param int $page
     * @param int $limit
     * @return bool
     * @throws Exception
     */
    public function fetchOrders(int $page = 0, int $limit = 100): bool
    {
        $query = "
            SELECT o.*
            FROM orders o
            WHERE 1=1
                " . ($this->params->orderID > 0 ? " AND o.order_id LIKE '%{$this->params->orderID}%'" : "") . "
            LIMIT {$page}, {$limit}
        ";

        $this->orders = MySQL::i()->select($query);

        return true;
    }

    /**
     * @return array
     */
    public function getOrders(): array
    {
        return $this->orders;
    }
}
