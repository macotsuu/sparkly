<?php

namespace Sparkly\Framework\Database\ORM;

readonly class UnitOfWork
{
    public function __construct(
        private EntityManagerInterface $em
    ) {
    }

    /**
     * @param Entity $entity
     * @return void
     */
    public function persist(Entity $entity): void
    {
        $reflector = new \Sparkly\ORM\EntityReflector($entity);

        $fieldsValues = array();
        foreach ($reflector->getEntityFields() as $field => $property) {
            if ($reflector->getValue($field) === false) {
                continue;
            }

            $declaringValue = match (true) {
                $property->getType()->getName() === 'DateTime' => $reflector->getValue($field)->format('Y-m-d H:i:s'),
                $property->getType()->getName() === 'string' => addslashes($reflector->getValue($field)),
                default => $reflector->getValue($field)
            };

            $fieldsValues[$property->getName()] = $declaringValue;
            $onDuplicateKey[$property->getName()] = "{$property->getName()}=VALUES({$property->getName()})";
        }

        $q = $this->em->getQueryBuilder()
                ->insert($reflector->getTableName())
                ->columns(...array_keys($fieldsValues))
                ->values(...array_values($fieldsValues))
                ->addons("ON DUPLICATE KEY UPDATE " . implode(',', $onDuplicateKey))
                ->build();

        $this->em->getConnection()->execute($q);
    }
}
