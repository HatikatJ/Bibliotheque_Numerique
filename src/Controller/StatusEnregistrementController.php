<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatusEnregistrementController extends AbstractController
{
    #[Route('/status/enregistrement', name: 'app_status_enregistrement')]
    public function index(): Response
    {
        return $this->render('status_enregistrement/index.html.twig', [
            'controller_name' => 'StatusEnregistrementController',
        ]);
    }
}
