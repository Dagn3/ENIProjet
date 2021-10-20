<?php

namespace App\Controller;

use App\Entity\Campus;
use App\Entity\Lieu;
use App\Entity\Sortie;
use App\Entity\Ville;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeleteSortieController extends AbstractController
{
    /**
     * @Route("/delete/{id}", name="delete_sortie")
     */
    public function delete (Sortie $sortie, Campus $campus, Lieu $lieu, Ville $ville)
    {
        $em = $this->getDoctrine()->getManager();
        $em -> remove($sortie);
        $em -> remove($campus);
        $em -> remove($lieu);
        $em -> remove($ville);


        $em ->flush();

        $this->addFlash('message', 'La sortie a été supprimé !');
        return $this->redirectToRoute('list_sortie');
    }
}
