<?php

namespace Sparkly\System\ORM;

use ReflectionException;
use system\ORM\EntityManagerInterface;

class EntityRepository
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly string $entityClassName
    ) {
    }

    /**
     * @param mixed $id
     * @return object|null
     */
    public function find(mixed $id): object|null
    {
        return $this->entityManager->getUnitOfWork()->load($this->entityClassName, $id);
    }

    /**
     * @return array
     * @throws ReflectionException
     */
    public function findAll(): array
    {
        return $this->findBy([]);
    }

    /**
     * @param array $criteria
     * @param array|null $orderBy
     * @param int|null $limit
     * @param int|null $offset
     * @return array
     * @throws ReflectionException
     */
    public function findBy(array $criteria, array $orderBy = null, int $limit = null, int $offset = null): array
    {
        return $this->entityManager->getUnitOfWork()->loadAll(
            $this->entityClassName,
            $criteria,
            $orderBy,
            $limit,
            $offset
        );
    }
}


