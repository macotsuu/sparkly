<?php

namespace Sparkly\Framework\Foundation\Kernel\Bootstrap;

use PDO;
use Sparkly\Framework\Database\Connection;
use Sparkly\Framework\Database\ORM\EntityManager;
use Sparkly\Framework\Foundation\Application;

final class SetupDatabase
{
    public function boot(Application $app): void
    {
        $app->bind(EntityManager::class, function () use ($app) {
            $configuration = $app['config']->get('database');
            $dsn = sprintf("mysql:host=%s;dbname=%s", $configuration['hostname'], $configuration['database']);

            $pdo = new PDO($dsn, $configuration['username'], $configuration['password'], [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_CASE => PDO::CASE_NATURAL,
                PDO::ATTR_ORACLE_NULLS => PDO::NULL_EMPTY_STRING
            ]);

            return new EntityManager(new Connection($pdo));
        });
    }
}
