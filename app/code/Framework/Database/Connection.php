<?php

namespace Sparkly\Framework\Database;

use Closure;
use Exception;
use PDOStatement;

final readonly class Connection implements ConnectionInterface
{
    public function __construct(protected \PDO $pdo)
    {
    }

    /**
     * @inheritDoc
     */
    public function fetch(string $query, array $attributes = []): mixed
    {
        return $this->run($query, $attributes)->fetch();
    }
    /**
     * @inheritDoc
     */
    public function execute(string $query, array $attributes = []): int
    {
        return $this->run($query, $attributes)->rowCount();
    }

    /**
     * @inheritDoc
     */
    public function fetchAll(string $query, array $attributes = []): array
    {
        return $this->run($query, $attributes)->fetchAll();
    }
    /**
     * @param string $query
     * @param array $attributes
     * @return mixed
     * @throws Exception
     */
    private function run(string $query, array $attributes): PDOStatement
    {
        return $this->runQuery($query, $attributes, function ($query, $attributes) {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($attributes);

            return $stmt;
        });
    }

    /**
     * @param string $query
     * @param array $attributes
     * @param Closure $callback
     * @return PDOStatement
     */
    private function runQuery(string $query, array $attributes, Closure $callback): PDOStatement
    {
        return $callback($query, $attributes);
    }
}
