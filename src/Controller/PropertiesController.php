<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\Property;
use App\Entity\Review;
use App\Repository\PropertyRepository;
use App\Repository\PropertyTypeRepository;
use App\Repository\ReviewRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\ResultSetMapping;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PropertiesController extends AbstractController
{

    public function __construct()
    {
    }

    #[Route('/properties', name: 'properties')]
    public function index(Request $request, PropertyRepository $propertyRepository, PropertyTypeRepository $propertyTypeRepository, EntityManagerInterface $em): Response
    {

        $properties = $propertyRepository->findBy(['status' => 1]);
        $finales = [];
        foreach ($properties as $propertie) {
            if ($request->query->get('prixMin') != '') {
                if ($propertie->getPrice() >= $request->query->get('prixMin'))
                    array_push($finales, $propertie);
            }

            if ($request->query->get('prixMax') != '') {
                if ($propertie->getPrice() <= $request->query->get('prixMax')) {
                    array_push($finales, $propertie);
                }
            }

            if ($request->query->get('prixMax') != '' && $request->query->get('prixMin') != '') {
                if ($propertie->getPrice() >= $request->query->get('prixMin') && $propertie->getPrice() <= $request->query->get('prixMax')) {
                    array_push($finales, $propertie);
                }
            }

            if ($request->query->get('propertyType') != '') {
                if ($propertie->getPropertyType()->getId() == $request->query->get('propertyType')) {
                    array_push($finales, $propertie);
                }
            }

            if ($request->query->get('city') != '') {
                if ($propertie->getAddresse()->getCity() == $request->query->get('city')) {
                    array_push($finales, $propertie);
                }
            }

            if ($request->query->get('capacity') != '') {
                if ($propertie->getCapacity() === intval($request->query->get('capacity'))) {
                    array_push($finales, $propertie);
                }
            }
        }


        foreach ($finales as $property) {
            foreach ($finales as $index => $dup) {
                if ($property->getId() === $dup->getId())
                    array_slice($finales, $index, 1);
            }
        }

        if (count($finales) == 0)
            $finales = $properties;

        return $this->render('properties/index.html.twig', [
            'menu' => 'properties',
            'properties' => $finales,
            'propertyType' => $propertyTypeRepository->findAll(),
        ]);
    }

    #[Route('/property/{id}', name: 'property')]
    public function property(Property $property): Response
    {
        return $this->render('properties/property.html.twig', [
            'menu' => 'properties',
            'property' => $property,
        ]);
    }

    #[Route('/property/{id}/review/add', name: 'addReview')]
    public function addReview(Property $property, Request $request, ReviewRepository $reviewRepository, EntityManagerInterface $entityManagerInterface): Response
    {
        if (!$reviewRepository->findOneBy(['user' => $this->getUser()->getId(), 'property' => $property->getId()])) {
            $review = new Review();
            $review->setProperty($property);
            $review->setUser($this->getUser());
            $review->setComment($request->request->get("comment"));
            $review->setRating(intval($request->request->get("rating")));
            $entityManagerInterface->persist($review);
            $entityManagerInterface->flush();
            $this->addFlash("success", "Votre avis est pris en compte !");
        } else
            $this->addFlash("error", "Votre avis est déjà pris en compte!");
        return $this->redirect($request->headers->get('referer'));
    }


    #[Route('/property/{id}/message', name: 'property_message')]
    public function sendMessage(Property $property, Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        if ($request->getMethod() === 'POST') {
            $message = new Message();
            $message->setMessage($request->request->get('message'));
            $message->setProperty($property);
            $message->setUser($this->getUser());

            $entityManagerInterface->persist($message);
            $entityManagerInterface->flush();
            $this->addFlash("success", "Message bien envoyé");
        }
        return $this->redirect($request->headers->get('referer'));
    }
}
