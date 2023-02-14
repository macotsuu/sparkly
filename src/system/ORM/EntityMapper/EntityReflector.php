<?php

namespace Sparkly\System\ORM\EntityMapper;

use ReflectionClass;
use ReflectionException;
use ReflectionProperty;

class EntityReflector
{
    public const FIELD_TABLE = 'table';
    public const FIELD_PRIMARY_KEY = 'primaryKey';

    private string $entityName;

    private object $entityInstance;

    private ReflectionClass $entityReflectionClass;
    private array $entityFields;

    /**
     * @throws ReflectionException
     *
     */
    public function __construct(string $entity)
    {
        $this->entityName = $entity;
        $this->entityReflectionClass = new ReflectionClass($this->entityName);
        $this->entityInstance = $this->instantiateEntity();
    }

    /**
     * @return object
     * @throws ReflectionException
     */
    public function instantiateEntity(): object
    {
        return $this->entityReflectionClass->newInstanceWithoutConstructor();
    }

    /**
     * @return string
     * @throws ReflectionException
     */
    public function getTableName(): string
    {
        return $this->entityReflectionClass->getProperty(self::FIELD_TABLE)->getValue($this->entityInstance);
    }

    /**
     * @return string
     * @throws ReflectionException
     */
    public function getPrimaryKeyName(): string
    {
        return $this->entityReflectionClass->getProperty(self::FIELD_PRIMARY_KEY)->getValue($this->entityInstance);
    }

    /**
     * @return array
     */
    public function getEntityFields(): array
    {
        foreach ($this->entityReflectionClass->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
            $this->entityFields[$property->getName()] = $property;
        }

        return $this->entityFields;
    }
}
