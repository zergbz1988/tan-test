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
        $dealer1 = $this->getReference('dealer1');
        $manager->initializeObject($dealer1);
        $dealer2 = $this->getReference('dealer2');
        $manager->initializeObject($dealer2);
        $dealer3 = $this->getReference('dealer3');
        $manager->initializeObject($dealer3);

        $car1 = new Car('Mercedes-Benz', 'C-klasse', 'Электропакет', 2500000, '4USBT53544LT26841');
        $car2 = new Car('Mercedes-Benz', 'C-klasse', 'Электропакет', 2500000, 'WMWRC31060TB95535');
        $car3 = new Car('Audi', 'Q7', 'Электропакет, Продвинутая сигнализация', 4300000, 'ZFA18800004473122');
        $car4 = new Car('Audi', 'Q7', 'Электропакет, Продвинутая сигнализация', 3950000, 'JHLRE48577C415490');
        $car5 = new Car('Skoda', 'Octavia', 'Пакет безопасности, Электропакет', 1100000, 'KMHBT31GP3U013758');
        $car6 = new Car('Porsche', 'Panamera', 'Продвинутая сигнализация, Пакет безопасности', 6200000, 'KNDJC733545301768');
        $car1->addToDealer($dealer1);
        $car2->addToDealer($dealer1);
        $car3->addToDealer($dealer2);
        $car4->addToDealer($dealer2);
        $car5->addToDealer($dealer3);

        $manager->persist($car1);
        $manager->persist($car2);
        $manager->persist($car3);
        $manager->persist($car4);
        $manager->persist($car5);
        $manager->persist($car6);
        $manager->flush();
    }
}