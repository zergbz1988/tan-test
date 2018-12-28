<?php

namespace TanTest\Http;

use TanTest\Http\Interfaces\ControllerInterface;
use TanTest\Http\Response\JsonResponse;


class Controller implements ControllerInterface
{
    protected $response;

    function __construct($response = null)
    {
        $this->response = $response ?? JsonResponse::class;
    }
}