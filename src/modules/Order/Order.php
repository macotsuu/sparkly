<?php

namespace modules\Order;

use DateTime;

class Order
{
    public int $order_id;
    public string $order_currency;
    public string $order_status;
    public DateTime $order_date;
    public DateTime $order_last_update;
    public string $order_buyer_name;
    public float $order_sell_price;
    public float $order_sell_net;

    protected string $table = 'orders o';
    protected string $primaryKey = 'order_id';

}
