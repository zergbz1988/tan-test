<?php

use App\Db\Doctrine\Fixtures\{CarFixtureLoader, DealerFixtureLoader};
use Symfony\Component\Config\FileLocator;
use TanTest\Http\Request\{JsonRequest, XmlRequest, YamlRequest, SerializedObjectRequest};
use Symfony\Component\Routing\Loader\PhpFileLoader;
use TanTest\Http\Response\{JsonResponse, XmlResponse, HtmlResponse};

$fileLocator = new FileLocator(__DIR__ . '/../routes');
$loader = new PhpFileLoader($fileLocator);

return [
    'routes' => $loader->load('routes.php'),
    'requestClass' => JsonRequest::class,
//    'requestClass' => XmlRequest::class,
//    'requestClass' => YamlRequest::class,
//    'requestClass' => SerializedObjectRequest::class,
    'responseClass' => JsonResponse::class,
//    'responseClass' => XmlResponse::class,
//    'responseClass' => HtmlResponse::class,
    'store' => [
        //'type' => 'sql',
        'type' => 'mongodb',
        'dbParams' => require_once __DIR__ . '/doctrine/db.php',
        'mongodbParams' => require_once __DIR__ . '/doctrine/mongodb.php',
        'useFixtures' => true,
        'fixtures' => [
            DealerFixtureLoader::class,
            CarFixtureLoader::class
        ],
        'entitiesMapper' => [
            __DIR__ . '/doctrine/entities'
        ],
        'documentsMapper' => [
            __DIR__ . '/doctrine/documents'
        ],
        'proxyDir' => __DIR__ . '/../Models/Proxies',
        'hydratorDir' => __DIR__ . '/../Models/Hydrators',
        'isDevMode' => true,
    ],
];