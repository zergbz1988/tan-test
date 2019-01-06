<?php

namespace App\Http\Controllers;

use App\Models\Entities\Car;
use App\Validators\CarInfoValidator;
use Symfony\Component\HttpFoundation\Response;
use TanTest\Foundation\App;
use TanTest\Http\Controller;

/**
 * Class CarController
 * @package App\Http\Controllers
 *
 * @method App app()
 */
class CarController extends Controller
{
    public function info(): Response
    {
        $validator = new CarInfoValidator($this->request()->query);
        if (!$validator->validate()) {
            return $this->response([
                'status' => 'wrong query',
                'data' => $validator->errors(),
            ], 400);
        }

        $make = $this->request()->query->get('make');
        $model = $this->request()->query->get('model');
        $componentry = $this->request()->query->get('componentry');

        try {
            $entityManager = $this->app()->getEntityManager();
            $data = $entityManager->getRepository(Car::class)
                ->findFirstByClientAndCarParams($make . '%', $model . '%', '%' . $componentry . '%');
        } catch (\LogicException $e) {
            $documentManager = $this->app()->getDocumentManager();
            $data = $documentManager->getRepository(Car::class)
                ->findFirstByClientAndCarParams('/' . $make . '.*/', '/' . $model . '.*/', '/.*' . $componentry . '.*/');
        }

        return $this->response([
            'status' => 'ok',
            'data' => $data,
        ]);
    }
}