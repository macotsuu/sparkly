<?php

namespace Volcano\ORM\QueryBuilder\Query;

interface QueryInterface
{
    public function build(): string;
}
