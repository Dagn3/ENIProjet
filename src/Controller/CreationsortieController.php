<?php

namespace App\Controller;


use App\Entity\Campus;
use App\Entity\Lieu;
use App\Entity\Sortie;
use App\Entity\Ville;
use App\Form\CampusType;
use App\Form\CreationsortieType;
use App\Form\LieuType;
use App\Form\VilleType;
use App\Repository\ParticipantRepository;
use App\Repository\SortieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreationsortieController extends AbstractController
{


    /**
     * @Route ("/accueil", name="accueil")
     */
    public function sortie(): Response
    {



        return $this->render('success.html.twig',[
        ]);
    }



    /**
     * @Route ("/create_sortie", name="createform")
     */
    public function creerFormulaire(Request $request, EntityManagerInterface $entityManager, ParticipantRepository $participantRepository): Response
    {
        $campus = new Campus();
        $sortie = new Sortie();
        $lieu = new Lieu();
        $ville = new Ville();
        $sortieForm = $this->createForm(CreationsortieType::class, $sortie);
        $campusForm = $this->createForm(CampusType::class, $campus);
        $lieuForm = $this->createForm(LieuType::class, $lieu);
        $villeForm = $this->createForm(VilleType::class, $ville);

        $sortieForm->handleRequest($request);
        $campusForm->handleRequest($request);
        $lieuForm->handleRequest($request);
        $villeForm->handleRequest($request);

        if ($sortieForm && $campusForm && $lieuForm && $villeForm->isSubmitted()) {

            $sortie->setCampus($campus);
            $lieu->setVille($ville);
            $sortie->setLieu($lieu);

            $user = $this->get('security.token_storage')->getToken()->getUser();
            $participant = $participantRepository->find($user->getId());
            $sortie->setOrganisateur($participant);
            $sortie->addParticipant($participant);


            $entityManager->persist($campus);
            $entityManager->persist($ville);
            $entityManager->persist($lieu);
            $entityManager->persist($sortie);

            $entityManager->flush();

//            if ($campusForm->isSubmitted()) {
//                $entityManager->persist($campus);
//               // $entityManager->flush();
//
//                if ($lieuForm->isSubmitted()) {
//                    $entityManager->persist($lieu);
//                   // $entityManager->flush();
//
//                    if ($villeForm->isSubmitted()) {
//                        $entityManager->persist($ville);
//                       $entityManager->flush();

                        $this->addFlash('success', 'Une nouvelle sortie a été créé.');
                        return $this->redirectToRoute('list_sortie');




        }

                return $this->render("/extends.html.twig", ['sortieForm' => $sortieForm->createView(),
                    'campusForm' => $campusForm->createView(), 'lieuForm' =>$lieuForm->createView(),
                    'villeForm' => $villeForm->createView()

                ]);


    }




}

