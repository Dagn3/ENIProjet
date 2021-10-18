<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Entity\Sortie;
use App\Entity\User;
use App\Repository\ParticipantRepository;
use App\Repository\UserRepository;
use mysql_xdevapi\DatabaseObject;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\SortieRepository;
use Symfony\Component\Security\Core\User\UserInterface;

class SortieController extends AbstractController
{
    /**
     * @Route("/sortie", name="list_sortie")
     */
    public function sortie(SortieRepository $SortieRepository, ParticipantRepository $participantRepository){

        $user = $this->get('security.token_storage')->getToken()->getUser();



        return $this->render('listSortie.html.twig',[ 'sorties'=>$SortieRepository->findALl(), 'user'=>$user, "participant"=> $participantRepository->findAll()

        ]);
    }


    /**
     * @Route("/details/{id}", name="details_sortie")
     */
    public function detail(int $id, SortieRepository $sortieRepository): Response
    {
        $sortie = $sortieRepository->find($id);

        return $this->render('details.html.twig', [


            "sortie"=>$sortie
        ]);
    }

    /**
     * @Route("/regSortie/{id}", name="register_sortie")
     */
    public function inscrire(int $id, SortieRepository $SortieRepository, UserRepository $userRepository): Response
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();



        $utilisateur = $userRepository->find($id);

        $participant = new Participant();


        $participant->setNom($utilisateur->getNom());
        $participant->setPrenom($utilisateur->getPrenom());
        $participant->setTelephone($utilisateur->getTelephone());
        $participant->setMail($utilisateur->getMail());
        $participant->setMotPasse($utilisateur->getPassword());
        $participant->setAdministrateur(true);


        $sortie = $SortieRepository->find($id);
        $sortie->addParticipant($participant);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($participant);
        $entityManager->persist($sortie);
        $entityManager->flush();




        return $this->render('listSortie.html.twig', ['sorties' => $SortieRepository->findALl(), 'user' => $user

        ]);
    }
}