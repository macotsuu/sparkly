<?php

namespace Sparkly\System\Database\ORM;

use ReflectionClass;
use ReflectionException;
use ReflectionProperty;

class EntityReflector
{
    public const FIELD_TABLE = 'table';
    public const FIELD_PRIMARY_KEY = 'primaryKey';
    private Entity $entity;
    private ReflectionClass $entityReflectionClass;
    private array $entityFields = [];
    public function __construct(Entity $entity)
    {

        $this->entity = $entity;
        $this->entityReflectionClass = new ReflectionClass($entity);
    }

    public function getValue(string $name): mixed
    {
        if ($this->entityFields[$name]) {
            $property = $this->entityFields[$name];

            if ($property->isInitialized($this->entity)) {
                return $property->getValue($this->entity);
            }
        }

        return false;
    }

    /**
     * @return string
     * @throws ReflectionException
     */
    public function getTableName(): string
    {
        return $this->entityReflectionClass->getProperty(self::FIELD_TABLE)->getValue($this->entity);
    }

    /**
     * @return string
     * @throws ReflectionException
     */
    public function getPrimaryKeyName(): string
    {
        return $this->entityReflectionClass->getProperty(self::FIELD_PRIMARY_KEY)->getValue($this->entity);
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
