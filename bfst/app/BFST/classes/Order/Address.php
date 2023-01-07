<?php

namespace Order;

use RuntimeException;

class Address
{
    private string $fullname;
    private string $address;
    private string $postcode;
    private string $city;
    private string $email;
    private string $phone;

    public function get(string $prop): mixed
    {
        return $this->{$prop};
    }

    /**
     * @param string $prop
     * @param mixed $value
     * @return void
     * @throws RuntimeException
     */
    public function set(string $prop, mixed $value): void
    {
        if (!property_exists($this, $prop)) {
            throw new RuntimeException("Parametr $prop nie jest zdeklarowany w klasie Order");
        }

        $this->{$prop} = $value;
    }
}
