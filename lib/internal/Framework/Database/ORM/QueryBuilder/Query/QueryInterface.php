<?php

namespace Sparkly\System\Database\ORM\QueryBuilder\Query;

interface QueryInterface
{
    public function build(): string;
}
