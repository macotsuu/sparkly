<?php

namespace Sparkly\System\Database\ORM\QueryBuilder;

use Sparkly\System\Database\ORM\QueryBuilder\Query\Insert;
use Sparkly\System\Database\ORM\QueryBuilder\Query\Select;
use Sparkly\System\Database\ORM\QueryBuilder\Query\Update;

class QueryBuilder
{
    /**
     * @param ...$select
     * @return Select
     */
    public function select(...$select): Select
    {
        return new Select($select);
    }

    /**
     * @param string $table
     * @return Insert
     */
    public function insert(string $table): Insert
    {
        return new Insert($table);
    }

    /**
     * @param string $table
     * @return Update
     */
    public function update(string $table): Update
    {
        return new Update($table);
    }
}
