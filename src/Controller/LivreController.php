<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;//+++++
use App\Repository\LivreRepository;//+++++
use App\Entity\Livre;
use Symfony\Component\HttpFoundation\Request;//++++
use App\Form\CommentaireFormType;//++++++++
use App\Entity\Commentaire;//++++++++++++++
use App\Repository\CommentaireRepository;//++++++++++++++++++++++++++
use App\Form\NoteFormType;//++++++++
use App\Entity\Note;//+++++++
use App\Repository\NoteRepository;//++++++++++++++++++++++++++
use App\Entity\Utilisateur;//+++++++++



class LivreController extends AbstractController
{

///////////////////////////////////////////////LIVRE///////////////////////////////////////////////
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



////////////////////////////////////////////////DETAILS/////////////////////////////////////////////////
    #[Route('livre/detail/{livre}', name: 'app_detail')]
    public function detail(Request $request, Livre $livre, EntityManagerInterface $entityManager): Response
    {
                //recuperation dus user
        $user = $this->getUser();
        //             //status lecture
        // $lu = in_array($user,$livre->getUtilisateurlecteur()->toArray());
        // if($lu==false){
        //     //ajouter un livre
        //     $user->addLivrelu($livre);
        //     $livre->addUtilisateurlecteur($user);
        // }else{
        //     //retirer un livre
        //     $user->removeLivrelu($livre);
        //     $livre->removeUtilisateurlecteur($user);
        // }
        // $lu = in_array($user,$livre->getUtilisateurlecteur()->toArray());
        // //sauvegarder dans la bdd
        // $entityManager->persist($livre);
        // $entityManager->persist($user);
        // $entityManager->flush();
         
                //status enregistrement
        // $livre = $entitymanager->getRepository(Livre::class)->findAll();
        $enr_rps = $request->query->get("enr");
        $enr = "false";
        foreach ($user->getLivreenregistre() as $key => $value)
            if($livre->getId() == $value->getId())
                $enr = "true";
        if($enr_rps == "true"){
            $user->addLivreenregistre($livre);
            $enr = "true";
        }else if($enr_rps == "false"){
            $user->removeLivreenregistre($livre);
            $enr = "false";
        }
                //status lecture
        $lu_rps = $request->query->get("lu");
        $lu = "false";
        foreach ($user->getLivreLu() as $key => $value)
            if($livre->getId() == $value->getId())
                $lu = "true";
        if($lu_rps == "true"){
            $user->addLivreLu($livre);
            $lu = "true";
        }else if($lu_rps == "false"){
            $user->removeLivreLu($livre);
            $lu = "false";
        }
        $entityManager->persist($user);
        $entityManager->flush();
        
                //commentaire sur le livre
        $commentaire = new Commentaire();
        $commentaire->setUtilisateur($user);
        $commentaire->setLivre($livre);
        $form = $this->createForm(CommentaireFormType::class, $commentaire);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $entityManager->persist($commentaire);
            $entityManager->flush();
            return $this->redirectToRoute('app_detail',['livre'=>$commentaire->getLivre()->getId()]);
        }
        $comments = $entityManager->getRepository(Commentaire::class)->findAll();

        return $this->render('livre/detail.html.twig', [
                //statut lecture
            'livre' => $livre,
            'lu' => $lu == "true" ? true : false,
            'enr' => $enr == "true" ? true : false,
                //status enregistrement
            //fffffffffffffffffffffffffffffffffffff
                //commentaire sur le livre
            'utilisateur' => $user,
            'comments' => $comments,
            'form' => $form,
        ]);
    }


    // #[Route('livre/marquer_comme_lu/{id}', name: 'app_marquer_comme_lu')]
    // public function marquer_lu(Livre $livre): Response
    // {
    //      //recuperation dus user
    //     $user = $this->getUser();
    //     //ajouter un livre
    //     $user->addLivrelu($livre);
    //     $livre->addUtilisateurlecteur($user);
    //     //sauvegarder dans la bdd
    //     $entityManager->persist($livre);
    //     $entityManager->persist($user);
    //     $entityManager->flush();
    //     $lu = in_array($user,$livre->getUtilisateurlecteur());
    //     // return $this->render('livre/detail.html.twig', [
    //     //     'lu' => $lu
    //     //  ]);
    //     return $this->redirectToRoute('app_detail',['livre'=>$livre->getLivre()->getId(), 'lu'=>$lu]);
    // }
    // #[Route('livre/retirer_comme_lu/{id}', name: 'app_retirer_comme_lu')]
    // public function retirer_lu(Livre $livre): Response
    // {
    //      //recuperation dus user
    //      $user = $this->getUser();
    //     //retirer un livre
    //     $user->removeLivrelu($livre);
    //     $livre->removeUtilisateurlecteur($user);
    //     //sauvegarder dans la bdd
    //     $entityManager->persist($livre);
    //     $entityManager->persist($user);
    //     $entityManager->flush();
    //     // return $this->redirectToRoute('app_detail',['livre'=>$commentaire->getLivre()->getId()]);
    // }
    // #[Route('livre/marquer_comme_enr/{id}', name: 'app_marquer_comme_enr')]
    // public function marquer_enr(): Response
    // {
    //     if($commentaire!=null){
    //         $commentaireRepository->remove($commentaire, true);
    //         return $this->redirectToRoute('app_detail',['livre'=>$commentaire->getLivre()->getId()]);
    //     }
    // }


    #[Route('livre/supprimer_commentaire/{id}', name: 'app_supprimer_commentaire')]
    public function supprimer(Commentaire $commentaire, CommentaireRepository $commentaireRepository): Response
    {
        if($commentaire!=null){
            $commentaireRepository->remove($commentaire, true);
            return $this->redirectToRoute('app_detail',['livre'=>$commentaire->getLivre()->getId()]);
        }
    }




//////////////////////////////////////////////LECTURE//////////////////////////////////////////////
    #[Route('livre/lecture/{livre}', name: 'app_lecture')]
    public function lecture(Request $request, Livre $livre, NoteRepository $noteRepository, EntityManagerInterface $entityManager): Response
    // public function lecture(Livre $livre): Response
    {
        // $livre = $entitymanager->getRepository(Livre::class)->findAll();

        //recuperation du user
        $user = $this->getUser();
            //note sur le livre
        $note = new Note();
        $note->setUtilisateur($user);
        $note->setLivre($livre);
        $noteget = $noteRepository->findNoteByLivreByUtilisateur($livre, $user);
        if($noteget != null){
            $note = $noteget;
        }
        $form = $this->createForm(NoteFormType::class, $note);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $entityManager->persist($note);
            $entityManager->flush();
            // return $this->redirectToRoute('app_lecture');
        }

        return $this->render('livre/lecture.html.twig', [
            'livre' => $livre,
            'form' => $form,
            'note' => $user->getNote(),
        ]);
    }




    // #[Route('livre/prendre_note/{id}', name: 'app_prendre_note')]
    // public function noter(Avis $avis, AvisRepository $avisRepository): Response
    // {
    //     if($avis!=null){
    //         $avisRepository->remove($avis, true);
    //         return $this->redirectToRoute('app_tb');
    //     }
    // }


    #[Route('livre/enregistrer_notes', name: 'app_enregistrer_notes')]
    public function enregistrer_notes(Note $note, NoteRepository $noteRepository): Response
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