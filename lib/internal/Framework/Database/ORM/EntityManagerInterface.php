<?php

namespace Sparkly\System\Database\ORM;

use Sparkly\System\Database\Connection;
use Sparkly\System\Database\ORM\QueryBuilder\QueryBuilder;

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
