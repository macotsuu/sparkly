<?php

namespace Sparkly\Framework\Database\ORM\QueryBuilder\Query;

class Insert implements QueryInterface
{
    /** @var string $table */
    private string $table;

    /** @var array<string> $columns */
    private array $columns = [];

    /** @var array<string> $values */
    private array $values = [];
    private array $addons = [];

    public function __construct(string $table)
    {
        $this->table = $table;
    }

    /**
     * @param string ...$columns
     * @return $this
     */
    public function columns(string ...$columns): self
    {
        foreach ($columns as $column) {
            $this->columns[] = $column;
        }

        return $this;
    }

    /**
     * @param ...$values
     * @return $this
     */
    public function values(...$values): self
    {
        foreach ($values as $value) {
            $this->values[] = "'" . addslashes($value) . "'";
        }
        return $this;
    }

    /**
     * @param string ...$addons
     * @return $this
     */
    public function addons(string ...$addons): self
    {
        foreach ($addons as $addon) {
            $this->addons[] = $addon;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function build(): string
    {
        return 'INSERT INTO ' . $this->table
                . ' (' . implode(', ', $this->columns) . ') VALUES (' . implode(', ', $this->values) . ') '
                . (!empty($this->addons) ? implode(' ', $this->addons) : '');
    }
}
