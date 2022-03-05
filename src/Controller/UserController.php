<?php

namespace App\Controller;

use App\Entity\Addresse;
use App\Entity\User;
use App\Form\AddressType;
use App\Form\ProfileType;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/mon-profile', name: 'my-account')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            "user" => $this->getUser()
        ]);
    }

    #[Route('/mon-profile/adresse/modifier', name: 'edit-address')]
    public function editaddress(Request $request, EntityManagerInterface $entityManager): Response
    {
        $address = ($this->getUser()->getAddresse() !== null) ? $this->getUser()->getAddresse() : new Addresse();
        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);
        $user = $this->getUser();
        $user->setAddresse($address);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($address);
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash("success", "Modifié avec succès");

            return $this->redirectToRoute('my-account');
        }

        return $this->render('user/editAddress.html.twig', [
            'addressForm' => $form->createView(),
        ]);
    }

    #[Route('/mon-profile/modifier', name: 'edit-account')]
    public function updateUser(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash("success", "Modifié avec succès");

            return $this->redirectToRoute('my-account');
        }

        return $this->render('user/editProfile.html.twig', [
            'profileForm' => $form->createView(),
        ]);
    }
}
