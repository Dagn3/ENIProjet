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
        $participant = $participantRepository->find($user->getId());



        return $this->render('listSortie.html.twig',[ 'sorties'=>$SortieRepository->findALl(), 'user'=>$user, "participant"=> $participant

        ]);
    }


    /**
     * @Route("/details/{id}", name="details_sortie")
     */
    public function detail(int $id, SortieRepository $sortieRepository, ParticipantRepository $participantRepository): Response
    {




        $sortie = $sortieRepository->find($id);
        $participant = $participantRepository->find($id);

        return $this->render('details.html.twig', [

            "participant"=>$participant,
            "sortie"=>$sortie
        ]);
    }

    /**
     * @Route("/regParticip/{id}", name="register_participant")
     */
    public function inscrire(int $id, SortieRepository $SortieRepository, ParticipantRepository $participantRepository, UserRepository $userRepository): Response
    {

            $user = $userRepository->findOneByPseudo($this->getUser());



        $participant = $participantRepository->find($this->getUser());

        $sortie = $SortieRepository->find($id);
        $sortie->addParticipant($participant);

        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->persist($sortie);
        $entityManager->flush();




        return $this->redirectToRoute('list_sortie');
    }

    /**
     * @Route("/delParticip/{id}", name="delete_participant")
     */
    public function supprimer(int $id, SortieRepository $SortieRepository, ParticipantRepository $participantRepository, UserRepository $userRepository): Response
    {

        $user = $userRepository->findOneByPseudo($this->getUser());


        $participant = $participantRepository->find($this->getUser());

        $sortie = $SortieRepository->find($id);
        $sortie->removeParticipant($participant);

        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->persist($sortie);
        $entityManager->flush();


        return $this->redirectToRoute('list_sortie');

    }

}