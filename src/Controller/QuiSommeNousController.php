<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuiSommeNousController extends AbstractController
{
    #[Route('/qui_somme_nous', name: 'app_qui_somme_nous')]
    public function index(): Response
    {
        return $this->render('qui_somme_nous/index.html.twig', [
            'controller_name' => 'QuiSommeNousController',
        ]);
    }
}
