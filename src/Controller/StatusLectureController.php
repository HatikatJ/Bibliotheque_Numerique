<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatusLectureController extends AbstractController
{
    #[Route('/status/lecture', name: 'app_status_lecture')]
    public function index(): Response
    {
        return $this->render('status_lecture/index.html.twig', [
            'controller_name' => 'StatusLectureController',
        ]);
    }
}
