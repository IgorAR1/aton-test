<?php

use App\Aton\Http\Middlewares\ClearCacheMiddleware;
use App\Aton\Http\Middlewares\StartSessionMiddleware;
use App\Aton\ServiceProviders\AppServiceProviders;
use App\Core\Cache\CacheServiceProvider;
use App\Core\Event\EventServiceProvider;
use App\Core\Logger\LoggerServiceProvider;
use App\Core\Routing\RouteServiceProvider;
use Dotenv\Dotenv;

include __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$app = new \App\Core\Application\Application();
$request = \GuzzleHttp\Psr7\ServerRequest::fromGlobals();

$app->withProviders([
    RouteServiceProvider::class,
    CacheServiceProvider::class,
    EventServiceProvider::class,
    CacheServiceProvider::class,
    LoggerServiceProvider::class,
    AppServiceProviders::class
])->withMiddlewares([
    StartSessionMiddleware::class,
    ClearCacheMiddleware::class
])->handleRequest($request);



