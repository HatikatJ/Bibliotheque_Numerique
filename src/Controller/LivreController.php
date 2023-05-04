<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;//+++++
use App\Repository\LivreRepository;//+++++
use App\Entity\Livre;


class LivreController extends AbstractController
{
    #[Route('/livre', name: 'app_livre')]
    public function index(): Response
    {
        return $this->render('livre/index.html.twig', [
            'controller_name' => 'LivreController',
        ]);
    }


    #[Route('/detail/{livre}', name: 'app_detail')]
    public function detail(Livre $livre, EntityManagerInterface $entitymanager): Response
    {
        $livre = $entitymanager->getRepository(Livre::class)->findAll();

        return $this->render('livre/detail.html.twig', [
            'livre' => $livre,
        ]);
    }



    // #[Route('/', name: 'app_accueil')]
    // public function index(EntityManagerInterface $entitymanager): Response
    // {
    //                   //LES LIVRES LES PLUS LUS
    //   $livres = $entitymanager->getRepository(Livre::class)->findAll();
    //   $taille=count($livres);
    //   for ($i = 1; $i < $taille; ++$i) {
    //     $elem = $livres[$i];
    //     for ($j = $i; $j > 0 && count( $livres[$j-1]->getUtilisateurLecteur()) > count($elem->getUtilisateurLecteur()); $j--)
    //       $livres[$j] =  $livres[$j-1];
    //     $livres[$j] = $elem;
    //   }
    //                   //lES AVIS DES INTERNAUTES SUR LE SITE
    //   $avis = $entitymanager->getRepository(Avis::class)->findAll();

          
    //   return $this->render('accueil/index.html.twig', [
    //                   //LES LIVRES LES PLUS LUS
    //     'livres' => $livres,
    //                   //lES AVIS DES INTERNAUTES SUR LE SITE
    //     'avis' => $avis,
    //   ]);
    // }




    #[Route('/lecture', name: 'app_lecture')]
    public function lecture(): Response
    {
        return $this->render('livre/lecture.html.twig', [
            'controller_name' => 'LivreController',
        ]);
    }
}
