<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Couriers;
use App\Entity\Regions;
use App\Entity\Trips;
use DateTime;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $currentDate = new \DateTime();
        $threeMonthsAgo = clone $currentDate;
        $threeMonthsAgo->modify('-3 months');
        $couriers = $manager->getRepository(Couriers::class)->findAll();
        $regions =$manager->getRepository(Regions::class)->findAll();
        foreach ($couriers as $courier)
        {

            $currentBeginDate = clone $threeMonthsAgo;
            while ($currentBeginDate<$currentDate)
            {
                $downtime = rand(1,3);
                $randomRegion = $regions[array_rand($regions)];
                $endDate= clone $currentBeginDate;
                $endDate->modify('+'.$randomRegion->getDays().' days');
                $trip = new Trips();
                $trip->setCourier($courier);
                $trip->setRegion($randomRegion);
                $trip->setBeginDate(clone $currentBeginDate);
                $trip->setEndDate($endDate);

                $manager->persist($trip);
                $currentBeginDate->modify('+'.($randomRegion->getDays()+$downtime).' days');
                
            }

        }
        
        $manager->flush();
    }
}
