<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConditionGeneralDutilisationController extends AbstractController
{
    #[Route('/condition_general_dutilisation', name: 'app_condition_general_dutilisation')]
    public function index(): Response
    {
        return $this->render('condition_general_dutilisation/index.html.twig', [
            'controller_name' => 'ConditionGeneralDutilisationController',
        ]);
    }
}
