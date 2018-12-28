<?php

use Symfony\Component\Routing\RouteCollection;

$routeCollection = new RouteCollection();
$routeCollection->addCollection(require __DIR__ . '/api.php');

return $routeCollection;