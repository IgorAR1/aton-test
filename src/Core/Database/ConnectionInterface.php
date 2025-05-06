<?php

namespace App\Core\Database;

interface ConnectionInterface
{
    public function getConnection(): \PDO;
}