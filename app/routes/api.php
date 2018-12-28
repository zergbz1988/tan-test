<?php

use Symfony\Component\Routing\{Route, RouteCollection};

$namespace = 'App\\Http\\Controllers\\';

$routes = new RouteCollection();
$routes->add('carInfo', new Route('/Car/Info', ['_controller' => $namespace . 'CarController::info'], []));

return $routes;