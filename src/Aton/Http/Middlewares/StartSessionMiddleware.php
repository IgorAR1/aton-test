<?php

namespace App\Aton\Http\Middlewares;

use App\Core\Http\Middleware\MiddlewareInterface;
use App\Core\Http\Middleware\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class StartSessionMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $response = $handler->handle($request);

//        unset($_SESSION['errors']);

        return $response;
    }
}