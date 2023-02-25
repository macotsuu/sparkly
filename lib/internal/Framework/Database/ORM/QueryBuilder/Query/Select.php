<?php

namespace Sparkly\System\Database\ORM\QueryBuilder\Query;

class Select implements QueryInterface
{
    /** @var array<string> $fields */
    private array $fields = [];

    /** @var array<string> $conditions */
    private array $conditions = [];

    /** @var array<string> $order */
    private array $order = [];

    /** @var array<string> $from */
    private array $from = [];

    /** @var array<string> $innerJoin */
    private array $innerJoin = [];

    /** @var array<string> $leftJoin */
    private array $leftJoin = [];

    /** @var int|null $limit */
    private ?int $limit = null;

    /** @var int|null @offset */
    private ?int $offset = null;

    public function __construct(array $select)
    {
        $this->fields = $select;
    }

    /**
     * @param string ...$select
     * @return $this
     */
    public function select(string ...$select): self
    {
        foreach ($select as $arg) {
            $this->fields[] = $arg;
        }
        return $this;
    }

    /**
     * @param string $table
     * @param string|null $alias
     * @return $this
     */
    public function from(string $table, ?string $alias = null): self
    {
        $this->from[] = $alias === null ? $table : "{$table} AS {$alias}";
        return $this;
    }

    /**
     * @param ?array $where
     * @return $this
     */
    public function where(?array $where): self
    {
        foreach ($where as $arg) {
            $this->conditions[] = $arg;
        }
        return $this;
    }

    /**
     * @param ?array $order
     * @return $this
     */
    public function orderBy(?array $order): self
    {
        if ($order !== null) {
            foreach ($order as $arg) {
                $this->order[] = $arg;
            }
        }
        return $this;
    }

    /**
     * @param string ...$join
     * @return $this
     */
    public function innerJoin(string ...$join): self
    {
        $this->leftJoin = [];
        foreach ($join as $arg) {
            $this->innerJoin[] = $arg;
        }
        return $this;
    }

    /**
     * @param string ...$join
     * @return $this
     */
    public function leftJoin(string ...$join): self
    {
        $this->innerJoin = [];
        foreach ($join as $arg) {
            $this->leftJoin[] = $arg;
        }
        return $this;
    }

    /**
     * @param int|null $limit
     * @return $this
     */
    public function limit(?int $limit): self
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * @param int|null $offset
     * @return $this
     */
    public function offset(?int $offset): self
    {
        $this->offset = $offset;
        return $this;
    }

    public function build(): string
    {
        return 'SELECT ' . implode(', ', $this->fields)
                . ' FROM ' . implode(', ', $this->from)
                . ($this->leftJoin === [] ? '' : ' LEFT JOIN ' . implode(' LEFT JOIN ', $this->leftJoin))
                . ($this->innerJoin === [] ? '' : ' INNER JOIN ' . implode(' INNER JOIN ', $this->innerJoin))
                . ($this->conditions === [] ? '' : ' WHERE 1=1 ' . implode(' ', $this->conditions))
                . ($this->order === [] ? '' : ' ORDER BY ' . implode(', ', $this->order))
                . ($this->limit === null ? '' : " LIMIT " . ($this->offset === null ? "" : ceil(
                    $this->offset * $this->limit
                ) . ", ") . $this->limit);
    }
}
