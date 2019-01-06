<?php
/**
 * Created by PhpStorm.
 * User: Marat
 * Date: 28.12.2018
 * Time: 3:06
 */

namespace TanTest\Http;

use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ControllerResolver as SymfonyControllerResolver;

/**
 * Class ControllerResolver
 * @package TanTest\Http
 */
class ControllerResolver extends SymfonyControllerResolver
{
    private $app, $request, $responseClass;

    /**
     * ControllerResolver constructor.
     * @param ContainerInterface $app
     * @param Request $request
     * @param string $responseClass
     */
    public function __construct(ContainerInterface $app, Request $request, string $responseClass)
    {
        $this->app = $app;
        $this->request = $request;
        $this->responseClass = $responseClass;
        parent::__construct(null);
    }

    /**
     * @param string $class
     * @return mixed|object
     */
    protected function instantiateController($class)
    {
        return new $class($this->app, $this->request, $this->responseClass);
    }
}