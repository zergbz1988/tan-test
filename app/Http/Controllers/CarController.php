<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;
use TanTest\Http\Controller;

/**
 * Class CarController
 * @package App\Http\Controllers
 */
class CarController extends Controller
{
    public function info(): Response
    {
        return new $this->response([
            'status' => 'ok',
            'data' => [
                'car' => [
                    'name' => 'asdad',
                    'price' => 123
                ]
            ]
        ]);
    }
}