<?php

namespace App\Controller\Backoffice;

use App\Entity\User;
use App\Form\AdminProfileType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminUserController extends AbstractController
{
    #[Route('/admin/users', name: 'admin_user')]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('backoffice/user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/admin/user/{id}', name: 'admin_edit_user')]
    public function editUser(User $user, Request $request, EntityManagerInterface $entityManager, UserRepository $userRepository): Response
    {
        $form = $this->createForm(AdminProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash(
                'success',
                "Modifié avec succès"
            );
            return $this->redirect($request->headers->get('referer'));
        }

        return $this->render('backoffice/user/manage.html.twig', [
            'profileForm' => $form->createView(),
        ]);
    }
}
