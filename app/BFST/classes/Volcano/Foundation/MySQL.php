<?php

namespace Volcano\Foundation;

use Closure;
use Exception;
use PDO;
use PDOException;
use Volcano\Logger\Logger;

final class MySQL
{

    /**
     * @var PDO $pdo
     */
    protected PDO $pdo;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        try {
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
        } catch (PDOException $exception) {
            Logger::logger()->critical('exceptions/!MYSQL', $exception->getMessage());
            Logger::logger()->critical('exceptions/!MYSQL', $exception->getTraceAsString());

            throw new Exception("Nie udało się połączyć z bazą");
        }
    }

    /**
     * @param string $query
     * @return mixed
     * @throws Exception
     */
    public function first(string $query): mixed
    {
        return $this->run(
            $query,
            function (string $query) {
                $stmt = $this->pdo->prepare($query);
                $stmt->execute();

                return $stmt->fetch();
            }
        );
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
                logger()->info('!!SLOW', "QUERY: $query");
                logger()->info('!!SLOW', "TIME: " . $stop - $start . "s");
            }
        } catch (PDOException $exception) {
            logger()->error('!!MYSQL', $exception->getMessage());
            logger()->error('!!MYSQL', $exception->getTraceAsString());

            if (config()->get('BFST_ENVIRONMENT') === 'production') {
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
        return $this->run(
            $query,
            function (string $query) {
                $stmt = $this->pdo->prepare($query);
                $stmt->execute();

                return $stmt->rowCount();
            }
        );
    }

    /**
     * @param string $query
     * @return array
     * @throws Exception
     */
    public function select(string $query): array
    {
        return $this->run(
            $query,
            function (string $query) {
                $stmt = $this->pdo->prepare($query);
                $stmt->execute();

                return $stmt->fetchAll();
            }
        );
    }
}
