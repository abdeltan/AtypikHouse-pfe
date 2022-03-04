<?php

namespace App\Controller\Backoffice;

use ApiPlatform\Core\DataProvider\PaginatorInterface;
use App\Entity\Contact;
use App\Repository\ContactRepository;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminMessageController extends AbstractController
{
    #[Route('/admin/messages', name: 'admin_message')]
    public function messages(PropertyRepository $propertyRepository): Response
    {
        return $this->render('backoffice/message/index.html.twig', [
            'properties' => $propertyRepository->findBy(['user' => $this->getUser()->getId()]),
        ]);
    }

    #[Route('/admin/contacts', name: 'admin_contact')]
    public function contacts(ContactRepository $contactRepository): Response
    {
        return $this->render('backoffice/contact/index.html.twig', [
            'contacts' => $contactRepository->findBy(['status' => 0]),
        ]);
    }

    #[Route('/admin/contact/{id}/read', name: 'admin_read_contact')]
    public function setAdRead(Contact $contact, Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        $contact->setStatus(1);
        $entityManagerInterface->persist($contact);
        $entityManagerInterface->flush();
        $this->addFlash(
            'success',
            'Défini comme lu avec succès'
        );
        return $this->redirect($request->headers->get('referer'));
    }
}
