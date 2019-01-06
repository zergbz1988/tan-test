<?php

namespace TanTest\Foundation;

use Doctrine\Common\DataFixtures\Executor\MongoDBExecutor;
use Doctrine\Common\DataFixtures\Purger\MongoDBPurger;
use Doctrine\MongoDB\Connection;
use Doctrine\ODM\MongoDB\Configuration;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Mapping\Driver\YamlDriver;
use Throwable;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Pimple\Psr11\Container;
use Psr\Container\ContainerInterface;
use Pimple\Container as PimpleContainer;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use TanTest\Http\ControllerResolver;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\{RequestContext, RouteCollection};

/**
 * Class App
 * @package TanTest\Foundation
 */
class App implements ContainerInterface
{
    private $container;

    /**
     * App constructor.
     * @param array $container
     * @throws \Doctrine\ORM\ORMException
     */
    public function __construct($container = [])
    {
        if (is_array($container)) {
            if (!key_exists('config', $container) || !is_array($container['config'])) {
                throw new InvalidConfigurationException('Config must be set in Application');
            }
            $this->initStore($container);

            $container = new Container(new PimpleContainer($container));
        }
        if (!$container instanceof ContainerInterface) {
            throw new \InvalidArgumentException('Expected a ContainerInterface');
        }
        $this->container = $container;
    }

    public function run(): void
    {
        $config = $this->get('config');
        /** @var RouteCollection $routes */
        $routes = $config['routes'];
        /** @var Request $requestClass */
        $requestClass = $config['requestClass'];
        $request = $requestClass::createFromGlobals();
        /** @var string $responseClass */
        $responseClass = $config['responseClass'];

        $this->handleRequest($routes, $request, $responseClass);
    }

    /**
     * @param string $id
     * @return mixed
     */
    public function get($id)
    {
        return $this->container->get($id);
    }

    /**
     * @param string $id
     * @return bool
     */
    public function has($id): bool
    {
        return $this->container->has($id);
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager(): EntityManager
    {
        if (!$this->container->has('entityManager')) {
            throw new \LogicException('The Entity Manager is not set in your application.');
        }

        return $this->container->get('entityManager');
    }

    /**
     * @return DocumentManager
     */
    public function getDocumentManager(): DocumentManager
    {
        if (!$this->container->has('documentManager')) {
            throw new \LogicException('The Document Manager is not set in your application.');
        }

        return $this->container->get('documentManager');
    }

    /**
     * @param array $container
     * @throws \Doctrine\ORM\ORMException
     */
    protected function initStore(array &$container): void
    {
        $config = $container['config'];
        if (!key_exists('store', $config) || !is_array($config['store'])) {
            throw new InvalidConfigurationException('Store must be set in config');
        }
        $store = $config['store'];
        if (!key_exists('type', $store)) {
            throw new InvalidConfigurationException('Type must be set in store config');
        }
        switch ($store['type']) {
            case 'sql':
                $this->handleSqlStore($container, $store);
                break;
            case 'mongodb':
                $this->handleMongoDbStore($container, $store);
                break;
            default:
                throw new InvalidConfigurationException('Store type must be set to "sql" or "mongodb"');
        }
    }

    /**
     * @param array $container
     * @param $store
     * @throws \Doctrine\ORM\ORMException
     */
    protected function handleSqlStore(array &$container, $store): void
    {
        if (!key_exists('entitiesMapper', $store) || !is_array($store['entitiesMapper'])) {
            throw new InvalidConfigurationException('entitiesMapper must be set in store config');
        }
        if (!key_exists('dbParams', $store) || !is_array($store['dbParams'])) {
            throw new InvalidConfigurationException('dbParams must be set in store config');
        }
        $entitiesMapper = $store['entitiesMapper'];
        $dbParams = $store['dbParams'];
        $isDevMode = $store['isDevMode'] ?? false;
        $config = Setup::createYAMLMetadataConfiguration($entitiesMapper, $isDevMode);
        $entityManager = EntityManager::create($dbParams, $config);
        if (key_exists('useFixtures', $store) && $store['useFixtures']) {
            $fixturesLoader = new Loader();
            if (!key_exists('fixtures', $store) || !is_array($store['fixtures'])) {
                throw new InvalidConfigurationException('Fixtures must be set in store config if useFixtures option is set to true');
            }
            foreach ($store['fixtures'] as $fixture) {
                $fixturesLoader->addFixture(new $fixture);
            }
            $purger = new ORMPurger();
            $executor = new ORMExecutor($entityManager, $purger);
            $executor->execute($fixturesLoader->getFixtures());
        }
        $container['entityManager'] = $entityManager;
    }

    /**
     * @param array $container
     * @param $store
     */
    protected function handleMongoDbStore(array &$container, $store): void
    {
        if (!key_exists('documentsMapper', $store) || !is_array($store['documentsMapper'])) {
            throw new InvalidConfigurationException('documentsMapper must be set in store config');
        }
        if (!key_exists('mongodbParams', $store)) {
            throw new InvalidConfigurationException('mongodbParams must be set in store config');
        }
        if (!key_exists('proxyDir', $store)) {
            throw new InvalidConfigurationException('proxyDir must be set in store config');
        }
        if (!key_exists('hydratorDir', $store)) {
            throw new InvalidConfigurationException('hydratorDir must be set in store config');
        }
        $documentsMapper = $store['documentsMapper'];
        $mongodbParams = $store['mongodbParams'];
        $connection = new Connection($mongodbParams);
        $config = new Configuration();
        $config->setProxyDir($store['proxyDir']);
        $config->setProxyNamespace('Proxies');
        $config->setHydratorDir($store['hydratorDir']);
        $config->setHydratorNamespace('Hydrators');
        $yamlDriver = new YamlDriver($documentsMapper);
        $config->setMetadataDriverImpl($yamlDriver);
        $documentManager = DocumentManager::create($connection, $config);

        if (key_exists('useFixtures', $store) && $store['useFixtures']) {
            $fixturesLoader = new Loader();
            if (!key_exists('fixtures', $store) || !is_array($store['fixtures'])) {
                throw new InvalidConfigurationException('Fixtures must be set in store config if useFixtures option is set to true');
            }
            foreach ($store['fixtures'] as $fixture) {
                $fixturesLoader->addFixture(new $fixture);
            }
            $purger = new MongoDBPurger();
            $executor = new MongoDBExecutor($documentManager, $purger);
            $executor->execute($fixturesLoader->getFixtures());
        }
        $container['documentManager'] = $documentManager;
    }

    /**
     * @param RouteCollection $routes
     * @param Request $request
     * @param string $responseClass
     */
    protected function handleRequest(RouteCollection $routes, Request $request, string $responseClass): void
    {
        $context = new RequestContext();
        $context->fromRequest($request);
        $matcher = new UrlMatcher($routes, $context);

        $controllerResolver = new ControllerResolver($this, $request, $responseClass);
        $argumentResolver = new ArgumentResolver();

        try {
            $request->attributes->add($matcher->match($request->getPathInfo()));
            $controller = $controllerResolver->getController($request);
            $arguments = $argumentResolver->getArguments($request, $controller);
            $response = call_user_func_array($controller, $arguments);
        } catch (ResourceNotFoundException $e) {
            $response = new $responseClass(['Error' => $e->getMessage()], 404);
        } catch (Throwable $e) {
            $response = new $responseClass(['Error' => $e->getMessage()], 500);
        }

        $response->send();
    }
}