<?php

namespace App\Controller;

use App\Entity\Addresse;
use App\Entity\Contact;
use App\Repository\AddresseRepository;
use App\Repository\PropertyRepository;
use App\Repository\PropertyTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(PropertyRepository $propertyRepository, AddresseRepository $addresseRepository,PropertyTypeRepository $propertyTypeRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'properties' => $propertyRepository->findLastNine(),
            'propertyType' => $propertyTypeRepository->findAll()
        ]);
    }

    #[Route('/contact', name: 'contact')]
    public function contact(): Response
    {
        return $this->render('contact/index.html.twig');
    }

    #[Route('/contact/send', name: 'send-contact')]
    public function sendMessage(Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        if ($request->getMethod() === 'POST') {
            $contact = new Contact();
            $contact->setName($request->request->get("name"));
            $contact->setEmail($request->request->get("email"));
            $contact->setMessage($request->request->get("message"));
            $entityManagerInterface->persist($contact);
            $entityManagerInterface->flush();
            $this->addFlash(
                'success',
                'Message envoyé avec succès'
            );
        }
        return $this->redirect($request->headers->get('referer'));
    }

    #[Route('/api/addresses', name: 'json-addresses')]

    public function getAddresses(PropertyRepository $propertyRepository, AddresseRepository $addresseRepository): Response
    {
        $addresses = [];

        foreach ($propertyRepository->findAll() as $property) {
            $value = $property->getAddresse();
            array_push($addresses, [
                'property' => $property->getTitle(),
                'addresse' => $value->getStreetNumber() . ' ' . $value->getStreetName() . ', ' . $value->getCity() . ', ' . $value->getCountry()
            ]);
        }

        return $this->json($addresses, 200);
    }
}
