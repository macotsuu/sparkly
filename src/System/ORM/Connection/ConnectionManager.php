<?php

namespace Sparkly\System\ORM\Connection;

class ConnectionManager
{
    /** @var array<string, Connection> $connections */
    private array $connections = [];

    public function getConnection(string $name = 'default'): Connection
    {
        if (!isset($this->connections[$name])) {
            $this->connections[$name] = new Connection();
        }

        return $this->connections[$name];
    }
}