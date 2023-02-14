<?php

namespace Sparkly\System\ORM;

use Exception;
use PDOStatement;
use system\ORM\Connection\Connection;
use system\ORM\Connection\ConnectionManager;
use system\ORM\EntityManagerInterface;
use system\ORM\EntityMapper\EntityMapper;
use system\ORM\EntityMapper\EntityReflector;
use system\ORM\QueryBuilder\QueryBuilder;
use system\ORM\EntityRepository;
use system\ORM\UnitOfWork;

final class EntityManager implements EntityManagerInterface
{
    /** @var UnitOfWork $unitOfWork */
    private UnitOfWork $unitOfWork;
    /** @var Connection $connection */
    private Connection $connection;

    public function __construct()
    {
        $this->unitOfWork = new UnitOfWork($this);
        $this->connection = (new ConnectionManager())->getConnection();
    }

    /**
     * @param string $query
     * @return PDOStatement
     * @throws Exception
     */
    public function raw(string $query): PDOStatement
    {
        return $this->connection->query($query);
    }

    /**
     * @return Connection
     */
    public function getConnection(): Connection
    {
        return $this->connection;
    }

    /**
     * @param object $class
     * @return void
     */
    public function persist(object $class): void
    {
        $this->unitOfWork->persist($class);
    }

    /**
     * @param string $entityName
     * @return EntityRepository
     */
    public function getRepository(string $entityName): EntityRepository
    {
        return new EntityRepository($this, $entityName);
    }

    /**
     * @return UnitOfWork
     */
    public function getUnitOfWork(): UnitOfWork
    {
        return $this->unitOfWork;
    }

    /**
     * @return QueryBuilder
     */
    public function getQueryBuilder(): QueryBuilder
    {
        return new QueryBuilder();
    }

    /**
     * @param EntityReflector $entityReflector
     * @return EntityMapper
     */
    public function getEntityMapper(EntityReflector $entityReflector): EntityMapper
    {
        return new EntityMapper($entityReflector);
    }
}
