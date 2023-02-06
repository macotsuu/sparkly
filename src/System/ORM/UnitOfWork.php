<?php

namespace Sparkly\System\ORM;

use ReflectionException;
use Sparkly\System\ORM\EntityMapper\EntityReflector;

class UnitOfWork
{
    public function __construct(
        private readonly EntityManagerInterface $em
    ) {
    }

    /**
     * @param object $class
     * @return void
     */
    public function persist(object $class): void
    {
    }

    /**
     * @param string $entityClassName
     * @param mixed $id
     * @return object|null
     */
    public function load(string $entityClassName, mixed $id): object|null
    {
        return null;
    }

    /**
     * @param string $entityClassName
     * @param array $criteria
     * @param array|null $orderBy
     * @param int|null $limit
     * @param int|null $offset
     * @return array
     * @throws ReflectionException
     */
    public function loadAll(
        string $entityClassName,
        array $criteria,
        array $orderBy = null,
        int $limit = null,
        int $offset = null
    ): array {
        $entityReflector = new EntityReflector($entityClassName);
        $sql = $this->em->getQueryBuilder()
            ->select(...array_keys($entityReflector->getEntityFields()))
            ->from($entityReflector->getTableName())
            ->where($criteria)
            ->orderBy($orderBy)
            ->limit($limit)
            ->offset($offset)
            ->build();

        $stmt = $this->em->getConnection()->query($sql);
        $entityMapper = $this->em->getEntityMapper($entityReflector);

        return array_map(function ($record) use ($entityMapper) {
            return $entityMapper->morph($record);
        }, $stmt->fetchAll());
    }
}