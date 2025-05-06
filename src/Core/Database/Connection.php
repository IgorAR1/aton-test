<?php

namespace App\Core\Database;

use App\Core\Config\Config;

class Connection implements ConnectionInterface
{
    private \PDO $connection;

    public function __construct(Config $config)
    {
        $connection = new \PDO($config->get('database.dsn'), $config->get('database.username'), $config->get('database.password'));
        $connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        $this->connection = $connection;
    }

    public function getConnection(): \PDO
    {
        return $this->connection;
    }
}