<?php

use App\Db\Doctrine\Fixtures\{CarFixtureLoader, DealerFixtureLoader};
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Loader\PhpFileLoader;
use TanTest\Http\Response\JsonResponse;

$fileLocator = new FileLocator(__DIR__ . '/../routes');
$loader = new PhpFileLoader($fileLocator);

return [
    'routes' => $loader->load('routes.php'),
    'requestClass' => Request::class,
    'responseClass' => JsonResponse::class,
    'store' => [
        'type' => 'sql',
        'dbParams' => require_once __DIR__ . '/doctrine/db.php',
        'useFixtures' => true,
        'fixtures' => [
            DealerFixtureLoader::class,
            CarFixtureLoader::class
        ],
        'entitiesMapper' => [
            __DIR__ . '/doctrine/entities'
        ],
        'isDevMode' => true,
    ],
];