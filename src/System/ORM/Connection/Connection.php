<?php

namespace Sparkly\System\ORM\Connection;

use Closure;
use Exception;
use PDO;
use PDOException;

class Connection
{
    private PDO $pdo;

    public function __construct()
    {
        $pdo = new PDO(
            "{$_ENV['DB_DRIVER']}:dbname={$_ENV['DB_DATABASE']};host={$_ENV['DB_HOSTNAME']}",
            $_ENV['DB_USERNAME'],
            $_ENV['DB_PASSWORD']
        );

        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $pdo->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_NATURAL);
        $pdo->setAttribute(PDO::ATTR_STRINGIFY_FETCHES, false);
        $pdo->setAttribute(PDO::ATTR_STRINGIFY_FETCHES, false);

        $this->pdo = $pdo;
    }

    /**
     * @param string $query
     * @return mixed
     * @throws Exception
     */
    public function query(string $query): mixed
    {
        return $this->run($query, function ($query) {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();

            return $stmt;
        });
    }

    /**
     * @param string $query
     * @param Closure $callback
     * @return mixed
     * @throws Exception
     */
    private function run(string $query, Closure $callback): mixed
    {
        try {
            $start = microtime(true);
            $result = $callback($query);
            $stop = microtime(true);

            if ($stop - $start > 0.3) {
                //logger()->info('!!SLOW', "QUERY: $query");
                //logger()->info('!!SLOW', "TIME: " . $stop - $start . "s");
            }
        } catch (PDOException $exception) {
            //logger()->error('!!MYSQL', $exception->getMessage());
            // logger()->error('!!MYSQL', $exception->getTraceAsString());

            throw new Exception($exception->getMessage());
        }

        return $result;
    }
}
