<?php

namespace routes;


use App\Aton\Http\Controllers\CityController;
use App\Aton\Http\Controllers\CountryController;

use App\Aton\Http\Controllers\HomeController;
use App\Core\Routing\Router;

return function (Router $router): void {
    $router->get('', [HomeController::class]);
    $router->group(['prefix' => 'aton'], function (Router $router): void {
        $router->get('cities', [CityController::class, 'index']);
        $router->get('countries', [CountryController::class, 'index']);
        $router->get('countries/create', [CountryController::class, 'create']);
        $router->post('countries/create', [CountryController::class, 'store']);
        $router->get('countries/edit/{id}', [CountryController::class, 'edit']);
        $router->post('countries/edit/{id}', [CountryController::class, 'update']);
    });
};