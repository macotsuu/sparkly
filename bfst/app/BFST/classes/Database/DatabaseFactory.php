<?php

namespace BFST\Database;

use BFST\Logger\Logger;
use Exception;
use PDO;
use PDOException;

class DatabaseFactory
{
    private static array $instances = [];
    protected PDO $pdo;

    protected function __construct()
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
        }
    }

    public static function i()
    {
        $subclass = static::class;
        if (!isset(self::$instances[$subclass])) {
            self::$instances[$subclass] = new static();
        }
        return self::$instances[$subclass];
    }

    /**
     * @throws Exception
     */
    public function __wakeup()
    {
        throw new Exception("Cannot serialize singleton");
    }

    protected function __clone()
    {
    }
}