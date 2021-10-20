<?php

namespace App\Controller;

use App\Form\EditProfilType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/profil", name="user_profil")
     */
    public function profil()
    {
        return $this->render('user/profil.html.twig');
    }

    /**
     * @Route("/editProfil", name="user_editProfil")
     */
    public function editProfil(Request $request, EntityManagerInterface $entityManager)
    {
        $user = $this->getUser();
        $editProfilForm = $this->createForm(EditProfilType::class, $user);

        //Traitement du formulaire
        $editProfilForm->handleRequest($request);
        if ($editProfilForm->isSubmitted() && $editProfilForm->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            // Message Flash de confirmation
            $this->addFlash( 'success','Modifications effectuées');

            // Redirection
            return $this->redirectToRoute('user_profil');
        }

        // Send to Twig for display
        return $this->render('user/editProfil.html.twig', [
            'editProfilForm' => $editProfilForm->createView()
        ]);
    }

    /**
     * @Route("/editPassword", name="user_editPassword")
     */
    public function editPassword(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder)
    {
        // Check si method POST du formulaire
        if ($request->isMethod('POST')) {
            $user = $this->getUser();

            // Check si Mot de passe et Confirmation correspondent
            if ($request->request->get('password') == $request->request->get('password2')){

                // Encodage du password
                $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('password')));

                // MàJ DB & confirmation Flash
                $entityManager->flush();
                $this->addFlash('success', 'Modifications effectuées');

                // Redirection
                return $this->redirectToRoute('user_profil');

            }else{
                $this->addFlash('error', 'Le mot de passe et sa confirmation ne correspondent pas');
            }
        }

        // Send to Twig for display
        return $this->render('user/editPassword.html.twig');
    }


}