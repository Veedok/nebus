<?php

namespace App\DataFixtures;

use App\Entity\Address\City;
use App\Entity\Address\Street;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

/** Класс генерации улиц */
class StreetFixtures extends Fixture implements DependentFixtureInterface
{

    /**
     * Метод генерации улиц
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('ru_RU');
        $repository = $manager->getRepository(City::class);
        $cities = $repository->findAll();
        foreach ($cities as $city) {
            for ($i = 0; $i < 20; $i++) {
                $street = new Street();
                $street->setCityId($city);
                $street->setName($faker->streetName());
                $manager->persist($street);
            }
        }
        $manager->flush();
    }

    /**
     * Определение зависимостей
     * @return \class-string[]
     */
    public function getDependencies(): array
    {
        return [CityFixtures::class];
    }
}
