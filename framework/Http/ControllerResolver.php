<?php
/**
 * Created by PhpStorm.
 * User: Marat
 * Date: 28.12.2018
 * Time: 3:06
 */

namespace TanTest\Http;

use Symfony\Component\HttpKernel\Controller\ControllerResolver as SymfonyControllerResolver;

class ControllerResolver extends SymfonyControllerResolver
{
    private $response;

    public function __construct($response)
    {
        $this->response = $response;
        parent::__construct(null);
    }

    /**
     * Returns an instantiated controller.
     *
     * @param string $class A class name
     *
     * @return object
     */
    protected function instantiateController($class)
    {
        return new $class($this->response);
    }
}