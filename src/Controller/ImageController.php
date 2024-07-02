<?php

namespace App\Controller;

use App\Entity\Film;
use App\Entity\Image;

use App\Entity\Product;
use App\Form\ImageType;

use App\Repository\ImageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ImageController extends AbstractController
{
    #[Route('/admin/image/add/{id}', name: 'add_image')]
    public function index($id, Request $request, EntityManagerInterface $manager, ImageRepository $imageRepository): Response
    {
        if (!$this->isGranted('ROLE_ADMIN')){
            return $this->redirectToRoute('app_film');
        }

        $image = new Image();
        $formImage = $this->createForm(ImageType::class, $image);
        $formImage->handleRequest($request);
        if($formImage->isSubmitted() && $formImage->isValid())
        {

            $image->setFilm($manager->getRepository(Film::class)->find($id));
            $manager->persist($image);
            $manager->flush();

        }
        return $this->redirectToRoute("film_image", ["id"=>$id]);

    }

    #[Route('admin//delete/image/{id}', name: 'delete_image')]
    public function delete(EntityManagerInterface $manager, Image $image)
    {
        $manager->remove($image);
        $manager->flush();
        return $this->redirectToRoute("add_image"
        );
    }
}
