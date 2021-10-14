<?php

namespace App\Controller;


use App\Entity\Sortie;
use App\Form\CreationsortieType;
use App\Repository\SortieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreationsortieController extends AbstractController
{
    /**
     * @Route("/", name="creationsortie")
     */
    public function creerSortie(): Response
    {
        return $this->render("/extends.html.twig");
    }

    /**
     * @Route ("/create_sortie", name="createform")
     */
    public function creerFormulaire (Request $request, EntityManagerInterface $entityManager):Response
    {

        $sortie = new Sortie();
        $sortieForm = $this->createForm(CreationsortieType::class, $sortie);

        $sortieForm->handleRequest($request);

        if ($sortieForm->isSubmitted()){
           $entityManager->persist($sortie);
           $entityManager->flush();

           $this->addFlash('success', 'Une nouvelle sortie a été créé.');
        }

        return $this ->render("/extends.html.twig", ['sortieForm'=>$sortieForm->createView()
            ]);
        
    }




}
