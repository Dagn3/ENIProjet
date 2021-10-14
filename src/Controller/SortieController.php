<?php

namespace App\Controller;

use App\Entity\Sortie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\SortieRepository;
class SortieController extends AbstractController
{
    /**
     * @Route("/sortie", name="list_sortie")
     */
    public function sortie(SortieRepository $SortieRepository){

        $sortie = new Sortie();

        return $this->render('listSortie.html.twig',[ 'sorties'=>$SortieRepository->findALl()]);
    }

}