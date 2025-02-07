<?php

namespace App\DataFixtures;

use App\Entity\City;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/** Класс генерации городов */
class CityFixtures extends Fixture
{
    public const string STREET_CITY_REFERENCE = 'street-city';
    /**
     * Метод генерации городов
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        $cities = ['Москва', 'Санкт-Петербург'];
        foreach ($cities as$key=> $value) {
            $city = new City();
            $city->setName($value);
            $manager->persist($city);
            $this->addReference((self::STREET_CITY_REFERENCE . ($key +1)), $city);
        }
        $manager->flush();


    }
}
