<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConditionsGeneralesDeReservationController extends AbstractController
{
    #[Route('/conditions_generales_de_reservation', name: 'app_conditions_generales_de_reservation')]
    public function index(): Response
    {
        return $this->render('conditions_generales_de_reservation/index.html.twig', [
            'controller_name' => 'ConditionsGeneralesDeReservationController',
        ]);
    }
}
