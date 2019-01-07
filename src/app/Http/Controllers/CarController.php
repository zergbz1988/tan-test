<?php

namespace App\Http\Controllers;

use App\Models\Entities\Car;
use App\Validators\CarInfoValidator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use TanTest\Foundation\App;
use TanTest\Http\Controller;
use LogicException;

/**
 * Class CarController
 * @package App\Http\Controllers
 *
 * @method App app()
 */
class CarController extends Controller
{
    /**
     * @return Response
     */
    public function info(): Response
    {
        $validator = new CarInfoValidator($this->request()->query);
        if (!$validator->validate()) {
            throw new BadRequestHttpException($validator->errorsAsString());
        }

        $make = $this->request()->query->get('make');
        $model = $this->request()->query->get('model');
        $componentry = $this->request()->query->get('componentry');

        try {
            $entityManager = $this->app()->getEntityManager();
            $data = $entityManager->getRepository(Car::class)
                ->findFirstByClientAndCarParams($make . '%', $model . '%', '%' . $componentry . '%');
        } catch (LogicException $e) {
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