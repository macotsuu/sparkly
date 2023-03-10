<?php

namespace Sparkly\Framework\Database;

interface ConnectionInterface
{
    /**
     * Fetch one matching record from database
     *
     * @param string $query
     * @param array $attributes
     * @return mixed
     */
    public function fetch(string $query, array $attributes): mixed;

    /**
     * Fetch all matching records from database
     *
     * @param string $query
     * @param array $attributes
     * @return array
     */
    public function fetchAll(string $query, array $attributes): array;

    /**
     *
     * @param string $query
     * @param array $attributes
     * @return int
     */
    public function execute(string $query, array $attributes): int;
}
