<?php

namespace App\Models\Repositories;

use Doctrine\ODM\MongoDB\Query\Expr;
use MongoRegex;
use App\Models\Entities\Car;
use Doctrine\ODM\MongoDB\DocumentRepository;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

/**
 * Class CarRepository
 * @package App\Models\EntityRepositories
 */
class CarDocumentRepository extends DocumentRepository
{
    /**
     * @param string $make
     * @param string $model
     * @param string $componentry
     * @return array
     * @throws \MongoException
     */
    public function findFirstByClientAndCarParams(string $make, string $model, string $componentry): array
    {
        $car = $this->getDocumentManager()
            ->createQueryBuilder(Car::class)
            ->select(['price', 'vin', 'dealer.name', 'dealer.address'])
            ->field('dealer.name')->gt('')
            ->field('make')->equals(new MongoRegex($make))
            ->field('model')->equals(new MongoRegex($model))
            ->field('componentry')->equals(new MongoRegex($componentry))
            ->getQuery()
            ->getSingleResult();

        if (empty($car)) {
            throw new ResourceNotFoundException('Car Not Found');
        }

        return [
            'car' => [
                'price' => $car->price(),
                'vin' => $car->vin(),
            ],
            'dealer' => [
                'name' => $car->dealer()->name(),
                'address' => $car->dealer()->address(),
            ],
        ];
    }
}