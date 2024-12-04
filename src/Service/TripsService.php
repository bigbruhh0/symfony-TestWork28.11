<?php
namespace App\Service;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Couriers;
use App\Entity\Regions;
use App\Entity\Trips;
class TripsService
{

    public EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }
  
    public function checkConflicts($courierId,$cur_date,$regionId)
    {
        $cur_courier = $this->entityManager->getRepository(Couriers::class)->find($courierId);    
        $cur_region = $this->entityManager->getRepository(Regions::class)->find($regionId);
        $cur_endDate =clone $cur_date;
        $cur_endDate->modify('+'.$cur_region->getDays().' days');
        $conflicts='';
        
        /*
        
        $cur_trips=$this->entityManager->getRepository(Trips::class)->createQueryBuilder('t')
        ->andWhere('t.courier = :courier')
        ->setParameter('courier', $cur_courier)
        ->andWhere('(t.beginDate < :endDate AND t.beginDate > :curDate)')
        ->setParameter('endDate',$cur_endDate)
        ->setParameter('curDate',$cur_date)
        ->getQuery()
        ->getResult();
        if ($cur_trips)
        {
            $trip=$cur_trips[0];
            $conflicts = 'У курьера запланирована поездка : '.$trip->getBeginDate()->format('d-m-Y').' до '.$trip->getEndDate()->format('d-m-Y');
        }

        $cur_trips=$this->entityManager->getRepository(Trips::class)->createQueryBuilder('t')
            ->andWhere('t.courier = :courier')
            ->setParameter('courier', $cur_courier)
            ->andWhere('(t.beginDate <= :curDate AND t.endDate >= :curDate)')
            ->setParameter('curDate',$cur_date)
            ->getQuery()
            ->getResult();
        if ($cur_trips)
        {
            $trip=$cur_trips[0];
            $conflicts = 'Курьер будет в поездке с '.$trip->getBeginDate()->format('d-m-Y').', освободится : '.$trip->getEndDate()->modify('+1 days')->format('d-m-Y');
        }
        */
        $regions = $this->entityManager->getRepository(Regions::class)->findAll();
        $regionsDict = [];
        foreach ($regions as $region) 
            {
                $regionsDict[$region->getId()] = $region->getDays();
            }
        $current_trips=$this->entityManager->getRepository(Trips::class)->findForCourier($cur_courier);
        if ($current_trips)
            {
               
                $date=clone $cur_date;
                $endDate=$date->modify('+'.$regionsDict[$regionId].' days');
                foreach ($current_trips as $trip)
                {
                    if ($trip->getBeginDate()<$endDate and $trip->getBeginDate()>$cur_date)
                    {
                        $conflicts = 'У курьера запланирована поездка : '.$trip->getBeginDate()->format('d-m-Y').' до '.$trip->getEndDate()->format('d-m-Y');
                    }

                    if ($trip->getBeginDate()<=$cur_date and $trip->getEndDate()>=$cur_date)
                    {
                        $conflicts = 'Курьер будет в поездке с '.$trip->getBeginDate()->format('d-m-Y').', освободится : '.$trip->getEndDate()->modify('+1 days')->format('d-m-Y');
                    }

                }
            }
        else
            {
                #
            }
        
        return [$cur_courier,$cur_region,$cur_endDate,$conflicts];
    }
}