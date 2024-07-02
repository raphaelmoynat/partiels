<?php

namespace App\Controller;

use App\Entity\Salle;
use App\Form\SalleType;
use App\Repository\SalleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SalleController extends AbstractController
{

    #[Route('/admin/salle', name: 'salle_index')]
    public function index(Request $request, SalleRepository $salleRepository, EntityManagerInterface $manager): Response
    {
        if (!$this->isGranted('ROLE_ADMIN')){
            return $this->redirectToRoute('app_film');
        }
        if (count($salleRepository->findAll()) >= 6) {
            $this->addFlash('error', 'Vous ne pouvez pas créer plus de six salles.');
            return $this->redirectToRoute('salle_index');
        }
        $salle = new Salle();
        $form = $this->createForm(SalleType::class, $salle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($salle);
            $manager->flush();

            return $this->redirectToRoute("salle_index");
        }

        $salles = $salleRepository->findAll();
        return $this->render('salle/index.html.twig', [
            'salles' => $salles,
            'form' => $form->createView(),
        ]);
    }
    #[Route('/admin/salle/edit/{id}', name: 'salle_edit')]
    public function edit(Request $request, Salle $salle, EntityManagerInterface $manager): Response
    {
        if (!$this->isGranted('ROLE_ADMIN')){
            return $this->redirectToRoute('app_film');
        }
        $form = $this->createForm(SalleType::class, $salle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            return $this->redirectToRoute('salle_index');
        }

        return $this->render('salle/edit.html.twig', [
            'form' => $form->createView(),
            'salle' => $salle,
        ]);
    }

    #[Route('/admin/salle/delete/{id}', name: 'salle_delete', methods: ['POST'])]
    public function delete(Request $request, Salle $salle, EntityManagerInterface $manager): Response
    {
        if (!$this->isGranted('ROLE_ADMIN')){
            return $this->redirectToRoute('app_film');
        }
        if (!$this->isGranted('ROLE_ADMIN')){
            return $this->redirectToRoute('app_film');
        }

        $manager->remove($salle);
        $manager->flush();


        return $this->redirectToRoute('salle_index');
    }



}
