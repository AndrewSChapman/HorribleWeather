<?php

use App\Domains\Weather\Action\GetCurrentWeatherAction;
use App\Domains\Location\Action\CheckLocationAction;
use App\Domains\Location\Action\SaveLocationAction;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

/** @var \Laravel\Lumen\Routing\Router $router */
$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/weather', function () use ($router) {
    /** @var GetCurrentWeatherAction $action */
    $action = $router->app->make(GetCurrentWeatherAction::class);
    return $action->getCurrentWeather();
});

$router->get('/location-check', function () use ($router) {
    /** @var CheckLocationAction $action */
    $action = $router->app->make(CheckLocationAction::class);
    return $action->checkLocation();
});

$router->post('/location', function () use ($router) {
    /** @var SaveLocationAction $action */
    $action = $router->app->make(SaveLocationAction::class);
    return $action->saveLocation();
});
