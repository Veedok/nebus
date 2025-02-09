<?php

namespace App\DataFixtures;

use App\Entity\Activity;
use App\Entity\Address\Building;
use App\Entity\Organization;
use App\Repository\ActivityRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

/** Класс генерации организаций */
class OrganizationFixtures extends Fixture implements DependentFixtureInterface
{

    /**
     * Метод генерации организаций
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        $buildingRepo = $manager->getRepository(Building::class);
        $activityRepo = $manager->getRepository(Activity::class);
        /** @var ActivityRepository $activityRepo */
        $activity = $activityRepo->getLastChild();
        $faker = Factory::create('ru_RU');
        $address = $buildingRepo->findAll();
        foreach ($address as $building) {
            for ($i = 0; $i < mt_rand(1,10); $i++) {
                $organization = new Organization();
                $organization->setAddress($building);
                $organization->setName($faker->company());
                $phones = [];
                for ($i = 0; $i < mt_rand(1,3); $i++) {
                    $phones[] = $faker->phoneNumber();
                }
                $organization->setPhones($phones);
                for ($i = 0; $i < mt_rand(1,3); $i++) {
                    $organization->addActivity($activity[mt_rand(0,count($activity)-1)]);
                }
                $manager->persist($organization);
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
        return [BuildingFixtures::class];
    }
}
