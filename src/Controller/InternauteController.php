<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Utilisateur;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Entity\Avis;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class InternauteController extends AbstractController
{
    #[Route('/tb', name: 'app_tb')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {

        $avis_s = $request->query->get("avis_save");

        if(trim($avis_s) != ""){
            $avis = new Avis();
            $avis->setAvis($avis_s);
            $avis->setUtilisateur($this->getUser());
            $entityManager->persist($avis);
            $entityManager->flush();
        }

        return $this->render('internaute/index.html.twig', [
            'avis' => $this->getUser()->getAvis(),
        ]);
    }


    #[Route('/dejalu', name: 'app_dejalu')]
    public function dejalu(): Response
    {
        return $this->render('internaute/dejalu.html.twig', [
            'controller_name' => 'InternauteController',
        ]);
    }


    #[Route('/parametre', name: 'app_parametre')]
    public function parametre(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $password = $form->get('password')->getData();

            if(!preg_match('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/', $password) && trim($password) != "")
                return $this->render('internaute/parametre.html.twig', [
                    'form' => $form->createView(),
                    'error' => "Le mot de passe ne correspond pas"
                ]);
            // encode the plain password
            if(trim($password) != "")
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('password')->getData()
                    )
                );
            else
                $user->setPassword(
                    $this->getUser()->getPassword()
                );

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_accueil');
        }

        return $this->render('internaute/parametre.html.twig', [
            'form' => $form->createView(),
            'error' => ''
        ]);
    }
}
