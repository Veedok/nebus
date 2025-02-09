<?php

namespace App\Repository;

use App\Entity\Activity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Репозиторий Вида деятельности
 * @extends ServiceEntityRepository<Activity>
 */
class ActivityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Activity::class);
    }

    //    /**
    //     * @return Activity[] Returns an array of Activity objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Activity
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    /**
     * Возвращает последний уровень вложенности у видов деятельности
     * @return mixed
     */
    public function getLastChild(): mixed
    {
        $manager = $this->getEntityManager();
        $query = $manager->createQuery('SELECT a FROM App\Entity\Activity a WHERE a.id NOT IN (SELECT DISTINCT p.parent FROM App\Entity\Activity p)');
        return $query->getResult();
    }

    /**
     * Возвращает потомков по идентификатору родителя
     * @param $parentId
     * @return mixed
     */
    public function getChildren($parentId): mixed
    {
        $manager = $this->getEntityManager();
        $query = $manager->createQuery('SELECT a FROM App\Entity\Activity a WHERE a.parent = :parent')->setParameter('parent', $parentId);
        return $query->getResult();
    }
}
