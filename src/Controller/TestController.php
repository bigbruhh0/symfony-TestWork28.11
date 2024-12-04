<?php
namespace App\Controller;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use Symfony\Component\HttpFoundation\JsonResponse;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Trips;
use App\Entity\Couriers;
use App\Entity\Regions;
use App\Repository\TripsRepository;
use App\Repository\CouriersRepository;
use App\Repository\RegionsRepository;
class TestController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'app_test')]
    public function index(): Response
    {
        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }
    #[Route('/add_trip', name: 'add_trip')]
    public function add_trip(CouriersRepository $CouriersRepository,RegionsRepository $RegionsRepository): Response
    {
        $couriers = $CouriersRepository->findAll();
        $regions = $RegionsRepository->findAll();
        return $this->render('test/add_trip.html.twig', [
            'couriers' => $couriers,
            'regions' => $regions,
        ]);
    }
    #[Route('/trips', name: 'show_trips')]
    public function show_trips(TripsRepository $TripsRepository): Response
    {
        $trips = $TripsRepository->findBy(
            [],
            ['beginDate' => 'ASC']
        );
        return $this->render('test/show_trips.html.twig', [
            'trips' => $trips,
        ]);
    }

    #[Route('api/apply_filters', name: 'apply_filters')]
    public function api_apply_filters(Request $request, TripsRepository $TripsRepository): Response
    {
        $beginDate=$request->query->get('beginDate');
        $endDate=$request->query->get('endDate');

        $trips=$TripsRepository->findByFilters($beginDate,$endDate);
        return $this->render('test/table.html.twig', [
            'trips' => $trips,
        ]);
    }

    #[Route('/api/add_trip', name: 'api_add_trip', methods: ['POST'])]
    public function api_add_trip(Request $request, TripsRepository $TripsRepository,CouriersRepository $CouriersRepository,RegionsRepository $RegionsRepository): Response
    {   
        $type = 'green';

        $data = json_decode($request->getContent(), true);

        if (!$data) {
            return new JsonResponse(['error' => 'Invalid JSON data'], 400);
        }

        $courierId = isset($data['courierId']) ? intval($data['courierId']) : null;
        $regionId = isset($data['regionId']) ? $data['regionId'] : null;
        $cur_date = isset($data['date']) ? new \DateTime($data['date']) : null;
        $cur_courier = $CouriersRepository->find($courierId);    
        $cur_region = $RegionsRepository->find($regionId);
        $cur_endDate =clone $cur_date;
        $cur_endDate->modify('+'.$cur_region->getDays().' days');
        
        $current_trips=$TripsRepository->findForCourier($cur_courier);
        $result='Поездка успешно добавлена';
        
        $regions = $RegionsRepository->findAll();
        $regionsDict = [];
        foreach ($regions as $region) 
            {
                $regionsDict[$region->getId()] = $region->getDays();
            }

        if ($current_trips)
            {
               
                $date=clone $cur_date;
                $endDate=$date->modify('+'.$regionsDict[$regionId].' days');
                foreach ($current_trips as $trip)
                {
                    if ($trip->getBeginDate()<$endDate and $trip->getBeginDate()>$cur_date)
                    {
                        $result = 'У курьера запланирована поездка : '.$trip->getBeginDate()->format('d-m-Y').' до '.$trip->getEndDate()->format('d-m-Y');
                    }

                    if ($trip->getBeginDate()<=$cur_date and $trip->getEndDate()>=$cur_date)
                    {
                        $result = 'Курьер будет в поездке с '.$trip->getBeginDate()->format('d-m-Y').', освободится : '.$trip->getEndDate()->modify('+1 days')->format('d-m-Y');
                    }

                }
            }
        else
            {
                #
            }
        if ($result==='Поездка успешно добавлена')
        {
            $trip = new Trips();

           
            
            $trip->setCourier($cur_courier);
            $trip->setRegion($cur_region);
            $trip->setBeginDate($cur_date);
            $trip->setEndDate($cur_endDate);
            
            $this->entityManager->persist($trip);
            $this->entityManager->flush();

        }
        else
        {
            $type='red';
        }

        return $this->render('test/response_add_trip.html.twig', [
            'response'=>$result,
            'type'=>$type,
        ]);
    }
}
