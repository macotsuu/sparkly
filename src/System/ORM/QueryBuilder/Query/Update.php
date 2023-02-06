<?php

namespace Sparkly\System\ORM\QueryBuilder\Query;

class Update implements QueryInterface
{
    /** @var string $table */
    private string $table;

    /** @var array<string> $conditions */
    private array $conditions = [];

    /** @var array<string> $columns */
    private array $columns = [];

    public function __construct(string $table)
    {
        $this->table = $table;
    }

    /**
     * @param string ...$where
     * @return $this
     */
    public function where(string ...$where): self
    {
        foreach ($where as $arg) {
            $this->conditions[] = $arg;
        }
        return $this;
    }

    /**
     * @param string ...$columns
     * @return $this
     */
    public function set(string ...$columns): self
    {
        foreach ($columns as $column) {
            $this->columns[] = $column;
        }
        return $this;
    }

    /**
     * @return string
     */
    public function build(): string
    {
        return 'UPDATE ' . $this->table
            . ' SET ' . implode(', ', $this->columns)
            . ($this->conditions === [] ? '' : ' WHERE ' . implode(' ', $this->conditions));
    }
}
