<?php

namespace Order;

use Exception;
use Volcano\Foundation\MySQL;

class OrderFilters
{
    private array $orders = [];
    private array $filters = [];
    public int $page = 0;
    public int $limit = 100;
    public MySQL $mySQL;

    public function __construct(array $filters)
    {
        $this->mySQL = new MySQL();

        $this->page = $filters['page'] ?? $this->page;
        $this->limit = $filters['limit'] ?? $this->limit;

        $this->filters[] = isset($filters['orderID']) ? "o.order_id LIKE '%{$filters['orderID']}%'" : "";
        $this->filters = array_filter(
            $this->filters,
            function ($value) {
                return trim($value) !== '';
            }
        );
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
            " . (!empty($this->filters) ? "WHERE " . implode(" AND ", $this->filters) : "") . "
            LIMIT $page, $limit
        ";

        $rows = $this->mySQL->select($query);
        $orderIds = array_column($rows, 'order_id');

        $productsRows = $this->mySQL->select(
            "SELECT * FROM orders_products WHERE order_id IN (" . implode(',', $orderIds) . ");"
        );

        foreach ($productsRows as $pIdx => $product) {
            $products[$product->order_id][] = $product;
        }

        foreach ($rows as $rIdx => $row) {
            $this->orders[$rIdx] = $row;
            if (isset($products) && isset($products[$row->order_id])) {
                $this->orders[$rIdx]->products = $products[$row->order_id];
            }
        }

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
