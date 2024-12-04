<?php

namespace App\Repository;

use App\Entity\Trips;
use App\Entity\Couriers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Trip>
 */
class TripsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trips::class);
    }
    public function findForCourier(Couriers $courier): array 
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.courier = :courier')
            ->setParameter('courier', $courier)
            ->getQuery()
            ->getResult();
    }
    public function findByFilters(string $beginDate = null,string $endDate = null): array
    {
        $queryBuilder = $this->createQueryBuilder('t');

        if ($beginDate)
        {
            $queryBuilder -> andWhere('t.beginDate= :beginDate')->setParameter('beginDate',new \DateTime($beginDate));
        }
        if ($endDate)
        {
            $queryBuilder -> andWhere('t.endDate= :endDate')->setParameter('endDate',new \DateTime($endDate));
        }
        $trips = $queryBuilder->orderBy('t.beginDate', 'ASC')->getQuery()->getResult();
        return $trips;
    }
    public function findConflictsPost(Couriers $courier,)
    {
    }
    //    /**
    //     * @return Trip[] Returns an array of Trip objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Trips
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
