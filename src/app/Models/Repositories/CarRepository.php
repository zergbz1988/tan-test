<?php

namespace App\Models\Repositories;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

/**
 * Class CarRepository
 * @package App\Models\EntityRepositories
 */
class CarRepository extends EntityRepository
{
    /**
     * @param string $make
     * @param string $model
     * @param string $componentry
     * @return array
     */
    public function findFirstByClientAndCarParams(string $make, string $model, string $componentry): array
    {
        $q = $this->getEntityManager()
            ->createQuery('SELECT c.price, c.vin, d.name, d.address 
                            FROM App\Models\Entities\Car c 
                            JOIN c.dealer d 
                            WHERE d.id > 0 
                            AND c.make LIKE :make
                            AND c.model LIKE :model
                            AND c.componentry LIKE :componentry  
                            ORDER BY c.vin ASC');
        $result = $q->execute(compact('make', 'model', 'componentry'))[0] ?? [];

        if (empty($result)) {
            throw new ResourceNotFoundException('Car Not Found');
        }

        return [
            'car' => [
                'price' => $result['price'],
                'vin' => $result['vin'],
            ],
            'dealer' => [
                'name' => $result['name'],
                'address' => $result['address'],
            ],
        ];
    }
}