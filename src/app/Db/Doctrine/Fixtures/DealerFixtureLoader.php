<?php

namespace App\Db\Doctrine\Fixtures;

use App\Models\Entities\Dealer;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class CarFixtureLoader
 * @package App\Db\Doctrine\Fixtures
 */
class DealerFixtureLoader extends AbstractFixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $dealer1 = new Dealer('Дилерский центр №1', 'ул. Академика Янгеля, 5');
        $dealer2 = new Dealer('Дилерский центр №2', 'пр. Мира, 83');
        $dealer3 = new Dealer('Дилерский центр №3', 'ул. Бориса Галушкина, 10');

        $manager->persist($dealer1);
        $manager->persist($dealer2);
        $manager->persist($dealer3);
        $manager->flush();

        $this->addReference('dealer1', $dealer1);
        $this->addReference('dealer2', $dealer2);
        $this->addReference('dealer3', $dealer3);
    }
}