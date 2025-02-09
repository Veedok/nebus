<?php

namespace App\DataFixtures;

use App\Entity\Address\Building;
use App\Entity\Address\Street;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

/** Класс генерации зданий */
class BuildingFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * Метод генерации зданий
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('ru_RU');
        $repository = $manager->getRepository(Street::class);
        $list = [
            'Москва' => [
                'lat' => ['min' => 55.5, 'max' => 56],
                'lon' => ['min' => 37, 'max' => 38],
            ],
            'Санкт-Петербург' => [
                'lat' => ['min' => 59.7, 'max' => 60.2],
                'lon' => ['min' => 30.1, 'max' => 30.6],
            ]
        ];
        $streets = $repository->findAll();
        foreach ($streets as $street) {
            $count = mt_rand(10, 20);
            $minMax = $list[$street->getCityId()->getName()];
            for ($i = 0; $i < $count; $i++) {
                $building = new Building();
                $building->setStreetId($street);
                $building->setNum($faker->buildingNumber());
                $building->setLatitude($faker->latitude($minMax['lat']['min'], $minMax['lat']['max']));
                $building->setLongitude($faker->longitude($minMax['lon']['min'], $minMax['lon']['max']));
                $manager->persist($building);
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
        return [StreetFixtures::class];
    }
}
