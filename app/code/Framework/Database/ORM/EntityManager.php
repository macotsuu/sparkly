<?php

namespace Sparkly\Framework\Database\ORM;

use Sparkly\Framework\Database\Connection;
use Sparkly\Framework\Database\ORM\QueryBuilder\QueryBuilder;

final class EntityManager implements EntityManagerInterface
{
    /** @var UnitOfWork $unitOfWork */
    private UnitOfWork $unitOfWork;

    /** @var Connection $connection */
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
        $this->unitOfWork = new UnitOfWork($this);
    }

    /**
     * @inheritDoc
     */
    public function persist(Entity $entity): bool
    {
        $this->unitOfWork->persist($entity);
        return true;
    }

    /**
     * @inheritDoc
     */
    public function getConnection(): Connection
    {
        return $this->connection;
    }

    /**
     * @inheritDoc
     */
    public function getQueryBuilder(): QueryBuilder
    {
        return new QueryBuilder();
    }
}
