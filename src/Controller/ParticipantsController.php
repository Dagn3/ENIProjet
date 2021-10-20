<?php

namespace App\Controller;

use App\Repository\ParticipantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/participants", name="participant_")
 */
class ParticipantsController extends AbstractController
{
    /**
     * @Route("/{id}", name="participants")
     */
    public function detail(int $id, ParticipantRepository $participantRepository): Response
    {


        $participant = $participantRepository->find($id);

        return $this->render('participant.html.twig', [

            "participant"=>$participant,

        ]);
    }


}
