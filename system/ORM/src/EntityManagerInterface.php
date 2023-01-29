<?php

namespace Volcano\ORM;

interface EntityManagerInterface
{
    /**
     * @param object $class
     * @return void
     */
    public function persist(object $class): void;
}
