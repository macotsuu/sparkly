<?php

namespace Sparkly\System\ORM\QueryBuilder\Query;

interface QueryInterface
{
    public function build(): string;
}
