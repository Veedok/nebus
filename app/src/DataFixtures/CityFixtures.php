<?php

namespace App\DataFixtures;

use App\Entity\Address\City;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/** Класс генерации городов */
class CityFixtures extends Fixture
{

    /**
     * Метод генерации городов
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        $cities = ['Москва', 'Санкт-Петербург'];
        foreach ($cities as $key=> $value) {
            $city = new City();
            $city->setName($value);
            $city->setId($key+1);
            $manager->persist($city);
        }
        $manager->flush();
    }
}
