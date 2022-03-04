<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;

class HostController extends AbstractController
{
    #[Route('/host', name: 'host')]
    /**
     * @Security("is_granted('ROLE_USER')")
     */
    public function index(Request $request): Response
    {
        if (in_array("ROLE_ADMIN", $this->getUser()->getRoles())) {
            $this->addFlash("error", "Vous êtes déjà un hébergeur chez nous !");
            return $this->redirect($request->headers->get('referer'));
        }
        return $this->render('host/index.html.twig');
    }

    #[Route('/host/join', name: 'be-host')]
    /**
     * @Security("is_granted('ROLE_USER')")
     */
    public function beHost(Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        $user = $this->getUser();
        $user->setRoles(['ROLE_ADMIN']);
        $entityManagerInterface->persist($user);
        $entityManagerInterface->flush();
        $this->addFlash("success", "Bienvenue, vous êtes devenu un hébergeur chez nous !");
        return $this->redirect($request->headers->get('referer'));
    }
}
