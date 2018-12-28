<?php

use Symfony\Component\Routing\Loader\PhpFileLoader;
use Symfony\Component\Config\FileLocator;
use TanTest\Http\Response\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

$fileLocator = new FileLocator(__DIR__ . '/../routes');
$loader = new PhpFileLoader($fileLocator);

return [
    'routes' => $loader->load('routes.php'),
    'request' => Request::class,
    'response' => JsonResponse::class
];