<?php

namespace Sparkly\Framework\Database\ORM\QueryBuilder\Query;

interface QueryInterface
{
    public function build(): string;
}
