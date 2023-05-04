<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InternauteController extends AbstractController
{
    #[Route('/tb', name: 'app_tb')]
    public function index(): Response
    {
        return $this->render('internaute/index.html.twig', [
            'controller_name' => 'InternauteController',
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
    public function parametre(): Response
    {
        return $this->render('internaute/parametre.html.twig', [
            'controller_name' => 'InternauteController',
        ]);
    }
}
