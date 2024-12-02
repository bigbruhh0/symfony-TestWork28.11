<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\TripsRepository;
class TestController extends AbstractController
{
    #[Route('/', name: 'app_test')]
    public function index(): Response
    {
        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }
    #[Route('/add_trip', name: 'add_trip')]
    public function add_trip(): Response
    {
        return $this->render('test/add_trip.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }
    #[Route('/trips', name: 'show_trips')]
    public function show_trips(TripsRepository $TripsRepository): Response
    {
        $trips = $TripsRepository->findAll();
        return $this->render('test/show_trips.html.twig', [
            'trips' => $trips,
        ]);
    }
}
