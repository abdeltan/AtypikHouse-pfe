<?php

namespace App\Controller\Backoffice;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class DashboardController extends AbstractController
{
    #[Route('/admin', name: 'dashboard')]
    public function index(): Response
    {
        return $this->render('backoffice/dashboard/dashboard.html.twig');
    }
}
