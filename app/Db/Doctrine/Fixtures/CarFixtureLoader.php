<?php

namespace App\Db\Doctrine\Fixtures;

use App\Models\Entities\Car;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class CarFixtureLoader
 * @package App\Db\Doctrine\Fixtures
 */
class CarFixtureLoader extends AbstractFixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $car1 = new Car('Mercedes-Benz', 'C-klasse', 'Электропакет', 2500000, '4USBT53544LT26841');
        $car1->addToDealer($this->getReference('dealer 1'));
        $car2 = new Car('Mercedes-Benz', 'C-klasse', 'Электропакет', 2500000, 'WMWRC31060TB95535');
        $car2->addToDealer($this->getReference('dealer 1'));
        $car3 = new Car('Audi', 'Q7', 'Электропакет, Продвинутая сигнализация', 4300000, 'ZFA18800004473122');
        $car3->addToDealer($this->getReference('dealer 2'));
        $car4 = new Car('Audi', 'Q7', 'Электропакет, Продвинутая сигнализация', 3950000, 'JHLRE48577C415490');
        $car4->addToDealer($this->getReference('dealer 2'));
        $car5 = new Car('Skoda', 'Octavia', 'Пакет безопасности, Электропакет', 1100000, 'KMHBT31GP3U013758');
        $car5->addToDealer($this->getReference('dealer 3'));
        $car6 = new Car('Porsche', 'Panamera', 'Продвинутая сигнализация, Пакет безопасности', 6200000, 'KNDJC733545301768');

        $manager->persist($car1);
        $manager->persist($car2);
        $manager->persist($car3);
        $manager->persist($car4);
        $manager->persist($car5);
        $manager->persist($car6);
        $manager->flush();
    }
}