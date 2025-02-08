<?php

namespace App\DataFixtures;

use App\Entity\Activity;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/** Класс генерации видов деятельности */
class ActivityFixtures extends Fixture
{
    /** @var array Массив видов деятельности */
    const array ACTIVITY = [
            [
                'name' => 'Еда',
                'child' => [
                    [
                        'name' => 'Мясная продукция',
                        'child' => [
                            ['name' => 'Изделия из свинины'], ['name' => 'Изделия из курицы'], ['name' => 'Изделия из говядины']
                        ]
                    ],
                    [
                        'name' => 'Молочная продукция',
                        'child' => [
                            ['name' => 'Кисломолочная продукция'], ['name' => 'Производные молочной продукции']
                        ]
                    ]
                ]
            ],
            [
                'name' => 'Автомобили',
                'child' => [
                    [
                        'name' => 'Грузовые',
                        'child' => [
                            ['name' => 'Ford'], ['name' => 'КАМАЗ'], ['name' => 'Isuzu']
                        ]
                    ],
                    [
                        'name' => 'Легковые',
                        'child' => [
                            ['name' => 'Hyundai'], ['name' => 'Lada'], ['name' => 'Toyota']
                        ]
                    ],
                    [
                        'name' => 'Запчасти',
                        'child' => [
                            ['name' => 'Подвеска'], ['name' => 'Двигатель'], ['name' => 'КПП']
                        ]
                    ],
                    [
                        'name' => 'Аксессуары',
                        'child' => [
                            ['name' => 'Держатели для телефона'], ['name' => 'Ароматизаторы'], ['name' => 'Электроника']
                        ]
                    ]
                ]
            ]
        ];

    /**
     * Метод генерации видов деятельности
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        $this->genActivity($manager, self::ACTIVITY);
    }

    /**
     * Метод для создания тестовых данных в таблице категорий
     * @param ObjectManager $manager
     * @param array $activity
     * @param int|null $parent
     * @return void
     */
    private function genActivity(ObjectManager $manager, array $activity, int $parent = null): void
    {
        foreach ($activity as $value) {
            $parentId = !empty($parent) ? $parent : 0;
            $activity = new Activity();
            $activity->setName($value['name']);
            $activity->setParent($parentId);
            $manager->persist($activity);
            $manager->flush();
            if (array_key_exists('child', $value)) {
                $this->genActivity($manager, $value['child'], $activity->getId());
            }
        }
    }
}
