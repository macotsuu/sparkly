<?php

namespace Volcano\ORM\EntityMapper;

use DateTime;
use ReflectionException;

readonly class EntityMapper
{
    public function __construct(private EntityReflector $entityReflector)
    {
    }

    /**
     * @param object $entry
     * @return object
     * @throws ReflectionException
     */
    public function morph(object $entry): object
    {
        $entity = $this->entityReflector->instantiateEntity();

        foreach ($this->entityReflector->getEntityFields() as $field => $property) {
            if (!isset($entry->{$field})) {
                continue;
            }

            $declaringValue = match (true) {
                $property->getType()->getName() === 'DateTime' => DateTime::createFromFormat(
                    'Y-m-d H:i:s',
                    $entry->{$field}
                ),
                default => $entry->{$field}
            };

            $entity->{$field} = $declaringValue;
        }

        return $entity;
    }
}