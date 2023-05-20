<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;//++++
use Twig\Environment;//+++++
use App\Repository\LivreRepository;//+++++
use App\Entity\Livre;//+++++
use App\Repository\AvisRepository;//+++++
use App\Entity\Avis;//+++++
use Knp\Component\Pager\PaginatorInterface;//+++++

class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(Request $request, EntityManagerInterface $entitymanager, PaginatorInterface $paginator): Response
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


      $pagination = $paginator->paginate(
        $avis,
        $request->query->get('page', 1),
        2
      );


          
      return $this->render('accueil/index.html.twig', [
        'paginationAvis' => $pagination,
                      //LES LIVRES LES PLUS LUS
        'livres' => $livres,
                      //lES AVIS DES INTERNAUTES SUR LE SITE
        'avis' => $avis,
      ]);
    }



    // public function livresLesPlusLus(LivreRepository $livreRepository): Response
    // {
    //     $livres = $livreRepository->findMostReadBooks();
        
    //     return $this->render('livre/livresLesPlusLus.html.twig', [
    //         'livres' => $livres,
    //     ]);
    // }


    // public function livresLesPlusLus(LivreRepository $livreRepository): Response
    // {
    //     // Appel de la méthode qui retourne les livres les plus lus
    //     $livres = $livreRepository->findByNombreDeLecteurs();

    //     // Affichage des résultats dans le template twig
    //     return $this->render('accueil/index.html.twig', [
    //         'livres' => $livres,
    //     ]);
    // }





    
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
