<?php
/**
 * Created by PhpStorm.
 * User: Marat
 * Date: 26.12.2018
 * Time: 21:27
 */

namespace TanTest\Foundation;

use Pimple\Psr11\Container;
use Psr\Container\ContainerInterface;
use Pimple\Container as PimpleContainer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use TanTest\Http\ControllerResolver;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;

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
     */
    public function __construct($container = [])
    {
        if (is_array($container)) {
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
        /** @var Request $request */
        $request = $config['request'];
        $request = $request::createFromGlobals();
        $response = $config['response'];
        $context = new RequestContext();
        $context->fromRequest($request);
        $matcher = new UrlMatcher($routes, $context);

        $controllerResolver = new ControllerResolver($response);
        $argumentResolver = new ArgumentResolver();

        try {
            $request->attributes->add($matcher->match($request->getPathInfo()));
            $controller = $controllerResolver->getController($request);
            $arguments = $argumentResolver->getArguments($request, $controller);
            $response = call_user_func_array($controller, $arguments);
        } catch (ResourceNotFoundException $e) {
            $response = new $response(['Not Found'], 404);
        } catch (\Exception $e) {
            $response = new $response(['An error occurred'], 500);
        }
        $response->send();
        die();
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
}