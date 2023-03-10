<?php

namespace Sparkly\Framework\Database\ORM;

use Sparkly\Framework\Database\Connection;
use Sparkly\Framework\Database\ORM\QueryBuilder\QueryBuilder;

interface EntityManagerInterface
{
    /**
     * @param Entity $entity
     * @return bool
     */
    public function persist(Entity $entity): bool;

    /**
     * @return Connection
     */
    public function getConnection(): Connection;

    /**
     * @return QueryBuilder
     */
    public function getQueryBuilder(): QueryBuilder;
}
