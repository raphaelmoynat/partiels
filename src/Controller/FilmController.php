<?php

namespace App\Controller;


use App\Entity\Film;
use App\Entity\Image;

use App\Form\FilmType;
use App\Form\ImageType;

use App\Repository\FilmRepository;
use App\Repository\SeanceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FilmController extends AbstractController
{
    #[Route('/', name: 'app_film')]
    public function index(FilmRepository $filmRepository): Response
    {

        return $this->render('film/index.html.twig', [
            'controller_name' => 'FilmController',
            "films"=>$filmRepository->findAll()
        ]);
    }

    #[Route('/admin/create/film', name: 'app_create_film', priority: 2)]
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        if (!$this->isGranted('ROLE_ADMIN')){
            return $this->redirectToRoute('app_film');
        }

        $film = new Film;
        $form = $this->createForm(FilmType::class, $film);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){

            $manager->persist($film);
            $manager->flush();
            return $this->redirectToRoute("app_film");
        }

        return $this->render('film/create.html.twig', [
            "film"=>$film,
            "form"=>$form->createView(),
            "btnValue"=>"Ajouter"
        ]);
    }

    #[Route('/film/show/{id}', name: 'app_show_film', priority: 2)]
    public function show(Film $film, Request $request, EntityManagerInterface $manager): Response
    {

        return $this->render('film/show.html.twig', [
            "film"=>$film,

        ]);
    }

    #[Route('/admin/film/delete/{id}', name: 'app_delete_film', priority: 3)]
    public function delete(EntityManagerInterface $manager, Film $film):Response
    {

        if (!$this->isGranted('ROLE_ADMIN')){
            return $this->redirectToRoute('app_film');
        }
        $manager->remove($film);
        $manager->flush();
        return $this->redirectToRoute("app_film");
    }

    #[Route('/admin/film/edit/{id}', name: 'app_edit_film', priority: 4)]
    public function edit(Request $request, EntityManagerInterface $manager, Film $film):Response
    {

        if (!$this->isGranted('ROLE_ADMIN')){
            return $this->redirectToRoute('app_product');
        }

        $form = $this->createForm(FilmType::class, $film);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($film);
            $manager->flush();
            return $this->redirectToRoute("app_show_film", ["id" => $film->getId()]);
        }

        return $this->render('film/create.html.twig', [
            "form"=>$form->createView(),
            "btnValue"=>"Editer"
        ]);

    }

    #[Route('/admin/film/images/{id}', name:"film_image", priority: 5)]
    public function addImage(Film $film):Response
    {
        if (!$this->isGranted('ROLE_ADMIN')){
            return $this->redirectToRoute('app_film');
        }
        $image = new Image();
        $formImage = $this->createForm(ImageType::class, $image);

        return $this->render("film/image.html.twig", [
            "film" => $film,
            'formImage' => $formImage->createView()
        ]);
    }

    #[Route('/film//seance/{id}', name: 'seance_film')]
    public function seance(Film $film, SeanceRepository $seanceRepository): Response
    {
        $seances = $seanceRepository->findBy(['film' => $film]);

        return $this->render('film/seance.html.twig', [
            'film' => $film,
            'seances' => $seances,
        ]);
    }
}
