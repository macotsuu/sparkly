<?php

namespace BFST\Order;

use BFST\Database\MySQL;
use Exception;

class OrderFilter
{
    private int $page = 0;
    private int $limit = 100;
    private int $orderID = 0;
    private MySQL $sql;

    /**
     * @param array|null $params
     */
    public function __construct(array $params = null)
    {
        $this->sql = MySQL::i();
        if ($params !== null) {
            $this->setLimit($params['limit'] ?: $this->limit);
            $this->setCurrentPage($params['page'] ?: $this->page);
            $this->setOrderId($params['orderID'] ?: 0);
        }
    }

    /**
     * @param int $limit
     * @return $this
     */
    public function setLimit(int $limit): self
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * @param int $page
     * @return $this
     */
    public function setCurrentPage(int $page): self
    {
        $this->page = $page;

        return $this;
    }

    /**
     * @param int $orderID
     * @return $this
     */
    public function setOrderId(int $orderID): self
    {
        $this->orderID = $orderID;

        return $this;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getOrders(): array
    {
        $query = "
            SELECT o.*
            FROM orders o
            WHERE 1=1
                ".( $this->orderID > 0 ? " AND o.order_id={$this->orderID}" : "")."
            LIMIT {$this->page}, {$this->limit}
        ";

        return $this->sql->select(trim($query));
    }
}