<?php

namespace App\Core\Database\Migration;

use App\Core\Database\Connection;

abstract class Migration
{
    public function __construct(protected Connection $connection)
    {
    }

    abstract public function up(): void;

    abstract public function down(): void;
}