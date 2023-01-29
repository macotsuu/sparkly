<?php

namespace BFST\Order\Domain\Order;

use ReflectionException;
use Volcano\ORM\EntityManager;

class OrderList
{
    private array $orders;
    private array $meta;
    private array $filters;
    private EntityManager $em;

    public function __construct()
    {
        $this->em = new EntityManager();
    }

    /**
     * @param array $filters
     * @return self
     */
    public function setFilter(array $filters): self
    {
        $this->filters[] = isset($filters['order_id']) ? " AND o.order_id = " . $filters['order_id'] : null;
        $this->filters[] = isset($filters['buyer']) ? " AND o.order_buyer_name LIKE '%" . addslashes(
                $filters['buyer']
            ) . "%'" : null;

        $this->meta['offset'] = $filters['page'] ?? 1;
        $this->meta['limit'] = $filters['limit'] ?? 25;

        $this->filters = array_filter($this->filters);

        return $this;
    }

    /**
     * @return $this
     * @throws ReflectionException
     */
    public function fetchOrders(): self
    {
        $this->orders = $this->em
            ->getRepository(Order::class)
            ->findBy(
                $this->filters,
                ['o.order_id DESC'],
                ((int)$this->meta['limit'] - 1) > 0 ? (int)$this->meta['limit'] : 0,
                (int)$this->meta['offset'] - 1
            );

        return $this;
    }

    /**
     * @return array
     */
    public function getOrders(): array
    {
        return [
            'orders' => $this->orders,
            'meta' => [
                'count' => count($this->orders),
                'limit' => $this->meta['limit'],
                'offset' => $this->meta['offset']
            ]
        ];
    }
}