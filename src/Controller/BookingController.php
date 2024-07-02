<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Repository\SeanceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BookingController extends AbstractController
{
    #[Route('/booking', name: 'app_booking')]
    public function index(): Response
    {
        return $this->render('booking/index.html.twig', [
            'controller_name' => 'BookingController',
        ]);
    }

    #[Route('/booking/{id}', name: 'booking_create', methods: ['POST'])]
    public function create($id, Request $request, SeanceRepository $seanceRepository, EntityManagerInterface $manager): Response
    {
        $seance = $seanceRepository->find($id);
        $siege = $request->request->get('siege');
        $user = $this->getUser();

        $booking = new Booking();
        $booking->setSeance($seance);
        $booking->setClient($user);



        $booking->setSiege($siege);
        $manager->persist($booking);

        $manager->flush();

        return $this->redirectToRoute('seance_show', ['id' => $id]);
    }
}
