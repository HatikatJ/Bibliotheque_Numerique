<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;//+++++
use App\Repository\LivreRepository;//+++++
use App\Entity\Livre;
use Symfony\Component\HttpFoundation\Request;//++++


class LivreController extends AbstractController
{
    #[Route('/livre', name: 'app_livre')]
    public function index(LivreRepository $livreRepository): Response
    {
            // Récupération de la liste des catégories de livres
        //$genres = $this->getDoctrine()->getRepository(Livre::class)->findAllGenre();
        $genres = $livreRepository->findAllGenre();
            // Récupération de la liste des livres à afficher (par exemple, tous les livres)
        $livres = $livreRepository->findByGenre($genres[0]);

        return $this->render('livre/index.html.twig', [
            // 'controller_name' => 'LivreController',
            'genres' => $genres,
            'livres' => $livres,
            'genre' => ""
        ]);
    }


        /**
     * @Route("/livre/{genre}", name="livre_liste_par_genre")
     */
    #[Route('/livre/{genre}', name: 'app_livre_genre')]
    public function listeParGenre($genre, LivreRepository $livreRepository)
    {
        $genres = $livreRepository->findAllGenre();
        $livres = $livres = $livreRepository->findByGenre($genre);
        
        return $this->render('livre/index.html.twig', [
            'genres' => $genres,
            'livres' => $livres,
            'genre' => $genre
        ]);
    }


    #[Route('livre/detail/{livre}', name: 'app_detail')]
    public function detail(Request $request, Livre $livre, EntityManagerInterface $entityManager): Response
    {
       // $livre = $entitymanager->getRepository(Livre::class)->findAll();
        $lu_rps = $request->query->get("lu");
        $lu = "false";
        foreach ($this->getUser()->getLivreLu() as $key => $value)
            if($livre->getId() == $value->getId())
                $lu = "true";

        $user = $this->getUser();
        if($lu_rps == "true"){
            $user->addLivreLu($livre);
            $lu = "true";
        }else if($lu_rps == "false"){
            $user->removeLivreLu($livre);
            $lu = "false";
        }
        
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->render('livre/detail.html.twig', [
            'livre' => $livre,
            'lu' => $lu == "true" ? true : false
        ]);
    }


    #[Route('livre/lecture/{livre}', name: 'app_lecture')]
    public function lecture(Livre $livre, EntityManagerInterface $entitymanager): Response
    // public function lecture(Livre $livre): Response
    {
        // $livre = $entitymanager->getRepository(Livre::class)->findAll();

        return $this->render('livre/lecture.html.twig', [
           
            'livre' => $livre,
        ]);
    }


    #[Route('livre/enregistrer_notes', name: 'app_enregistrer_notes')]
    public function enregistrer_notes(): Response
    {
        return $this->render('livre/index.html.twig', [
            'controller_name' => 'LivreController',
        ]);
    }


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