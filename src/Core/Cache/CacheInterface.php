<?php

namespace App\Core\Cache;

interface CacheInterface
{
    public function get(string $key, callable $callback);
}