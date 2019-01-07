<?php

namespace TanTest\Http;

use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use TanTest\Http\Interfaces\ControllerInterface;
use TanTest\Http\Response\JsonResponse;

/**
 * Class Controller
 * @package TanTest\Http
 *
 * @property $app ContainerInterface
 * @property $request Request
 * @property $responseClass string
 */
class Controller implements ControllerInterface
{
    protected $app, $request, $responseClass;

    public function __construct(ContainerInterface $app, Request $request = null, string $responseClass = null)
    {
        $this->app = $app;
        $this->request = $request;
        $this->responseClass = $responseClass ?? JsonResponse::class;
    }

    /**
     * @return ContainerInterface
     */
    public function app(): ContainerInterface
    {
        return $this->app;
    }

    /**
     * @return Request
     */
    public function request(): Request
    {
        return $this->request;
    }

    /**
     * @param array $content
     * @param int $code
     * @return Response
     */
    public function response(array $content = [], int $code = 200): Response
    {
        return new $this->responseClass($content, $code);
    }
}