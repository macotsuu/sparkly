<?php

namespace Sparkly\System\ORM;

interface EntityManagerInterface
{
    /**
     * @param object $class
     * @return void
     */
    public function persist(object $class): void;
}
