<?php

namespace Order;

use Exception;
use Product\Product;
use Volcano\Foundation\Entity;
use Volcano\Foundation\MySQL;

class Order extends Entity
{
    public Address $customer;
    public Address $delivery;
    private int $order_id;
    private string $order_designation;
    private string $order_date;
    private string $order_status;
    private string $order_payment;
    private string $order_media;
    private string $order_shipment;
    private string $order_currency;
    private float $order_buy_price;
    private float $order_sell_price;
    private float $order_buy_net;
    private float $order_sell_net;
    private float $order_paid;

    private array $products = [];
    private MySQL $sql;

    public function __construct(MySQL $sql = null)
    {
        $this->customer = new Address();
        $this->sql = $sql ?: new MySQL();
    }

    /**
     * @param Product $product
     * @return void
     */
    public function addProduct(Product $product): void
    {
        $this->products[] = $product;
    }

    public function saveOrder(): bool
    {
        $query = "INSERT INTO orders (
                    order_designation, 
                    order_date, 
                    order_status, 
                    order_payment, 
                    order_media, 
                    order_customer_full_name, 
                    order_customer_address, 
                    order_customer_postcode, 
                    order_customer_city, 
                    order_customer_email, 
                    order_customer_phone, 
                    order_shipment,
                    order_currency, 
                    order_buy_price, 
                    order_sell_price, 
                    order_buy_net, 
                    order_sell_net, 
                    order_paid
                ) VALUES (
                          '$this->order_designation',
                          '$this->order_date',
                          '$this->order_status',
                          '$this->order_payment',
                          '$this->order_media',
                          '{$this->customer->get('fullname')}',
                          '{$this->customer->get('address')}',
                          '{$this->customer->get('postcode')}',
                          '{$this->customer->get('city')}',
                          '{$this->customer->get('email')}',
                          '{$this->customer->get('phone')}',
                          '$this->order_shipment',
                          '$this->order_currency',
                          $this->order_buy_price,
                          $this->order_sell_price,
                          $this->order_buy_net,
                          $this->order_sell_net,
                          $this->order_paid
                )";

        try {
            $this->sql->execute($query);
        } catch (Exception $ex) {
            echo $ex->getMessage();
            return false;
        }
        return true;
    }
}
