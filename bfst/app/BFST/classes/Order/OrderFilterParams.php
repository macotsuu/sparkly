<?php

namespace Order;

class OrderFilterParams
{
    public int $orderID = 0;

    public function __construct(array $params = null)
    {
        if ($params !== null) {
            if (isset($params['orderID'])) {
                $this->orderID = (int)$params['orderID'];
            }
        }
    }
}