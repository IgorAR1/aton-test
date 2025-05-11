<?php

namespace App\Aton\Http\Middlewares;

use App\Core\Cache\CacheInterface;
use App\Core\Http\Middleware\MiddlewareInterface;
use App\Core\Http\Middleware\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ClearCacheMiddleware implements MiddlewareInterface
{
    public function __construct(private CacheInterface $cache)
    {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $query = $request->getQueryParams();

        $clearCache = $query['clearCache'] ?? false;

        if($clearCache === 'true') {
            $this->cache->clear();
        }

        return $handler->handle($request);
    }
}