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

use App\Service\TripsService;
use App\Entity\Trips;
use App\Entity\Couriers;
use App\Entity\Regions;
use App\Repository\TripsRepository;
use App\Repository\CouriersRepository;
use App\Repository\RegionsRepository;
class TestController extends AbstractController
{

    #[Route('/', name: 'app_test')]
    public function index(): Response
    {
        return $this->render('test/index.html.twig', [
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
    public function api_add_trip(Request $request,TripsService $TripService, TripsRepository $TripsRepository,CouriersRepository $CouriersRepository,RegionsRepository $RegionsRepository): Response
    {   
       

        $data = json_decode($request->getContent(), true);

        if (!$data) {
            return new JsonResponse(['error' => 'Invalid JSON data'], 400);
        }

        $courierId = isset($data['courierId']) ? intval($data['courierId']) : null;
        $regionId = isset($data['regionId']) ? $data['regionId'] : null;
        $cur_date = isset($data['date']) ? new \DateTime($data['date']) : null;
        
        
        [$cur_courier, $cur_region, $cur_endDate, $conflicts] = $TripService->checkConflicts($courierId,$cur_date,$regionId);
        
        if ($conflicts==="")
        {
            $trip = new Trips();

           
            
            $trip->setCourier($cur_courier);
            $trip->setRegion($cur_region);
            $trip->setBeginDate($cur_date);
            $trip->setEndDate($cur_endDate);
            
            $TripService->entityManager->persist($trip);
            $TripService->entityManager->flush();
            $result="Поездка успешно добавлена! "."с ".$cur_date->format('d-m-Y')." до ".$cur_endDate->format('d-m-Y');
            $type = 'green';
        }
        else
        {
            $result=$conflicts;
            $type='red';
        }

        return $this->render('test/response_add_trip.html.twig', [
            'response'=>$result,
            'type'=>$type,
        ]);
    }
}
