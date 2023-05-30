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
use App\Entity\Avis;//+++++++
use App\Repository\AvisRepository;//++++++++++++++++++++++++++
use App\Form\AvisFormType;//++++++++
use App\Form\CommentaireFormType;//++++++++
use App\Entity\Commentaire;//++++++++++++++
use App\Repository\CommentaireRepository;//++++++++++++++++++++++++++
use App\Form\NoteFormType;//++++++++
use App\Entity\Note;//+++++++
use App\Repository\NoteRepository;//++++++++++++++++++++++++++
use App\Entity\Livre;//++++++

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class InternauteController extends AbstractController
{
    
    ////////////////////////tableau de bord////////////////////////////////////////
    #[Route('/tb', name: 'app_tb')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
           //recuperation du user
        $user = $this->getUser();
            //livre enregistre
        $livreEnr = $user->getLivreenregistre();
            //livre lu
        $livreLu = $user->getLivreLu() ;
            //avis sur le site
        $avis = new Avis();
        $avis->setUtilisateur($user);
        $form = $this->createForm(AvisFormType::class, $avis);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $entityManager->persist($avis);
            $entityManager->flush();
            return $this->redirectToRoute('app_tb');
        }
        return $this->render('internaute/index.html.twig', [
            'form' => $form,
            'avis' => $user->getAvis(),
            'livreE' => $livreEnr,
            'livreL' => $livreLu
        ]);
    }
    #[Route('livre/supprimer_avis/{id}', name: 'app_supprimer_avis')]
    public function supprimer(Avis $avis, AvisRepository $avisRepository): Response
    {
        if($avis!=null){
            $avisRepository->remove($avis, true);
            return $this->redirectToRoute('app_tb');
        }
    }





    ////////////////////////////////////deja lu///////////////////////////////////
    #[Route('/dejalu/{livre}', name: 'app_dejalu')]
    public function detaildejalu(Request $request, Livre $livre, EntityManagerInterface $entityManager, NoteRepository $noteRepository): Response
    {
                //recuperation dus user
        $user = $this->getUser();
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
                //note sur le livre
        $note = new Note();
        $note->setUtilisateur($user);
        $note->getLivre($livre);
        $noteget = $noteRepository->findNoteByLivreByUtilisateur($livre, $user);
        if($noteget != null){
            $note = $noteget;
        }
        $form1 = $this->createForm(NoteFormType::class, $note);
        $form1->handleRequest($request);
        if($form1->isSubmitted()){
            $entityManager->persist($note);
            $entityManager->flush();
        }
                //commentaire sur le livre
        $commentaire = new Commentaire();
        $commentaire->setUtilisateur($user);
        $commentaire->setLivre($livre);
        $form = $this->createForm(CommentaireFormType::class, $commentaire);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $entityManager->persist($commentaire);
            $entityManager->flush();
            return $this->redirectToRoute('app_dejalu',['livre'=>$commentaire->getLivre()->getId()]);
        }
        $comments = $entityManager->getRepository(Commentaire::class)->findAll();

        return $this->render('internaute/dejalu.html.twig', [
            'livre' => $livre,
                //statut lecture
            'lu' => $lu == "true" ? true : false,
                //status enregistrement
            'enr' => $enr == "true" ? true : false,
                //note sur le livre
            'form1' => $form1,
                //commentaire sur le livre
            'utilisateur' => $user,
            'comments' => $comments,
            'form' => $form,
        ]);
    }
    #[Route('internaute/supprimer_commentaire/{id}', name: 'app_supprimer_commentaire')]
    public function supprimerC(Commentaire $commentaire, CommentaireRepository $commentaireRepository): Response
    {
        if($commentaire!=null){
            $commentaireRepository->remove($commentaire, true);
            return $this->redirectToRoute('app_dejalu',['livre'=>$commentaire->getLivre()->getId()]);
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
        $note->getLivre($livre);
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





/////////////////////////////////////parametre///////////////////////////////////////////
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
