<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;//+++++
use Symfony\Component\HttpFoundation\Request;//++++
use Twig\Environment;//+++++
use App\Repository\LivreRepository;//+++++
use App\Entity\Livre;//+++++
use App\Repository\AvisRepository;//+++++
use App\Entity\Avis;//+++++

class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(EntityManagerInterface $entitymanager): Response
    {
                      //LES LIVRES LES PLUS LUS
      $livres = $entitymanager->getRepository(Livre::class)->findAll();
      $taille=count($livres);
      for ($i = 1; $i < $taille; ++$i) {
        $elem = $livres[$i];
        for ($j = $i; $j > 0 && count( $livres[$j-1]->getUtilisateurLecteur()) > count($elem->getUtilisateurLecteur()); $j--)
          $livres[$j] =  $livres[$j-1];
        $livres[$j] = $elem;
      }
                      //lES AVIS DES INTERNAUTES SUR LE SITE
      $avis = $entitymanager->getRepository(Avis::class)->findAll();

          
      return $this->render('accueil/index.html.twig', [
                      //LES LIVRES LES PLUS LUS
        'livres' => $livres,
                      //lES AVIS DES INTERNAUTES SUR LE SITE
        'avis' => $avis,
      ]);
    }






    // public function show(Request $request, Environment $twig, LivreRepository $livreRepository, Avis $avis, AvisRepository $avisRepository): Response
    // {
    //                     //livres les plus lus
    //     //ggggggggggggggggggggggggggggggggggggggggggggggggggggggggggg
    //                     //avis
    //     $offset = max(0, $request->query->getInt('offset', 0));//
    //     $paginator = $avisRepository->getAvisPaginator($avis, $offset);//

    //     // return new Response($twig->render('accueil/index.html.twig', [
    //     return $this->render('accueil/index.html.twig', [
    //                     //livres les plus lus
    //         'livres' => $livreRepository->findAll(),
    //         // dd($livres),   //pour tester l'affichage 
    //                     //avis
    //         'avis' => $paginator,
    //         'previous' => $offset - AvisRepository::PAGINATOR_PER_PAGE,//
    //         'next' => min(count($paginator), $offset + AvisRepository::PAGINATOR_PER_PAGE),//
    //     ]);
    // }
}
