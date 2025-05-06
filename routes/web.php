<?php

namespace routes;


use App\Aton\Http\Controllers\CityController;
use App\Aton\Http\Controllers\CountryController;

use App\Aton\Http\Controllers\HomeController;
use App\Aton\Http\Controllers\UserController;
use App\Core\Routing\Router;

return function (Router $router): void {
    $router->get('', [HomeController::class]);
    $router->group(['prefix' => 'aton'], function (Router $router): void {
        $router->group(['prefix' => 'cities'], function (Router $router): void {
            $router->get('/', [CityController::class, 'index']);
            $router->get('/create', [CityController::class, 'create']);
            $router->post('/create', [CityController::class, 'store']);
            $router->get('/edit/{id}', [CityController::class, 'edit']);
            $router->post('/edit/{id}', [CityController::class, 'update']);
        });

        $router->group(['prefix' => 'countries'], function (Router $router): void {
            $router->get('/', [CountryController::class, 'index']);
            $router->get('/create', [CountryController::class, 'create']);
            $router->post('/create', [CountryController::class, 'store']);
            $router->get('/edit/{id}', [CountryController::class, 'edit']);
            $router->post('/edit/{id}', [CountryController::class, 'update']);
        });

        $router->group(['prefix' => 'users'], function (Router $router): void {
            $router->get('/', [UserController::class, 'index']);
            $router->get('create', [UserController::class, 'create']);
            $router->post('create', [UserController::class, 'store']);
            $router->get('edit/{id}', [UserController::class, 'edit']);
            $router->post('edit/{id}', [UserController::class, 'update']);
            $router->delete('delete/{id}', [UserController::class, 'delete']);
        });
    });
};