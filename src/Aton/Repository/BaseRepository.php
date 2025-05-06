<?php

namespace App\Aton\Repository;

use App\Core\Database\Connection;

abstract class BaseRepository
{
    protected \PDO $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection->getConnection();
    }
}