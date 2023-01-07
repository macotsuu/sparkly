<?php

namespace Volcano\Database;

use Closure;
use Exception;
use PDOException;
use Volcano\Logger\Logger;

class MySQL extends DatabaseFactory
{
    /**
     * @param string $query
     * @return mixed
     * @throws Exception
     */
    public function first(string $query): mixed
    {
        return $this->run($query, function (string $query) {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();

            return $stmt->fetch();
        });
    }

    /**
     * @param string $query
     * @return array
     * @throws Exception
     */
    public function select(string $query): array
    {
        return $this->run($query, function (string $query) {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll();
        });
    }

    /**
     * @throws Exception
     */
    private function run(string $query, Closure $callback): mixed
    {
        try {
            $start = microtime(true);
            $result = $callback($query);
            $stop = microtime(true);

            if ($stop - $start > 0.3) {
                Logger::logger()->info('!!SLOW', "QUERY: $query");
                Logger::logger()->info('!!SLOW', "TIME: " . $stop - $start . "s");
            }
        } catch (PDOException $exception) {
            Logger::logger()->error('!!MYSQL', $exception->getMessage());
            Logger::logger()->error('!!MYSQL', $exception->getTraceAsString());

            if (BFST_ENVIRONMENT === 'production') {
                throw new Exception("Problem z bazą danych!");
            }

            throw new Exception($exception->getMessage());
        }

        return $result;
    }

    /**
     * @param string $query
     * @return int
     * @throws Exception
     */
    public function execute(string $query): int
    {
        return $this->run($query, function (string $query) {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();

            return $stmt->rowCount();
        });
    }
}
