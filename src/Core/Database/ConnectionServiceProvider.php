<?php

namespace App\Core\Database;

use App\Core\Support\ServiceProvider\ServiceProvider;

class ConnectionServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->application->bind(Connection::class, function () {
            return new Connection($this->application->getConfig());
        });
    }
}