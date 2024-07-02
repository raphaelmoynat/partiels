<?php

namespace App\Controller;

use App\Entity\Seance;
use App\Form\SeanceType;
use App\Repository\BookingRepository;
use App\Repository\SeanceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SeanceController extends AbstractController
{
    #[Route('/admin/seance/create', name: 'seance_create')]
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        if (!$this->isGranted('ROLE_ADMIN')){
            return $this->redirectToRoute('app_film');
        }
        $seance = new Seance();
        $form = $this->createForm(SeanceType::class, $seance);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $seance->setPrice(7.5);

            $manager->persist($seance);
            $manager->flush();

            return $this->redirectToRoute('seance_show', ['id' => $seance->getId()]);
        }

        return $this->render('seance/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/seance/{id}', name: 'seance_show')]
    public function show($id, SeanceRepository $seanceRepository, BookingRepository $bookingRepository): Response
    {
        $seance = $seanceRepository->find($id);
        $bookings = $bookingRepository->findBy(['seance' => $seance]);

        $plan = $this->generatePlan($seance, $bookings);

        return $this->render('seance/show.html.twig', [
            'seance' => $seance,
            'plan' => $plan,
        ]);
    }

    private function generatePlan(Seance $seance, array $bookings): array
    {
        $salle = $seance->getSalle();
        $sieges = array_fill(1, $salle->getCapacity(), false);

        foreach ($bookings as $booking) {
            $siege = $booking->getSiege();
            $sieges[$siege] = true;
        }

        return $sieges;
    }
}
