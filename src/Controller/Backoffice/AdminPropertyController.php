<?php

namespace App\Controller\Backoffice;

use App\Entity\Addresse;
use App\Entity\AttributeValue;
use App\Entity\Equipment;
use App\Entity\Image;
use App\Entity\Property;
use App\Entity\Review;
use App\Entity\Unavailability;
use App\Form\AddressType;
use App\Form\EquipmentType;
use App\Form\ImageType;
use App\Form\PropertyType as PropertyFormType;
use App\Form\UnAvailabilityType;
use App\Repository\AttributeRepository;
use App\Repository\EquipmentRepository;
use App\Repository\PropertyRepository;
use App\Repository\ReviewRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use ProxyManager\ProxyGenerator\Util\Properties;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPropertyController extends AbstractController
{
    #[Route('/admin/properties', name: 'ads')]
    public function index(PaginatorInterface $paginator, Request $request, PropertyRepository $propertyRepository): Response
    {
        $properties = $paginator->paginate(
            $propertyRepository->findBy(['user' => $this->getUser()->getId()]),
            $request->query->getInt('page', 1),
            7
        );
        return $this->render('backoffice/property/index.html.twig', [
            'properties' => $properties,
        ]);
    }

    #[Route('/admin/property/add', name: 'new-ad')]
    public function newAd(Request $request, EntityManagerInterface $entityManager): Response
    {
        $property = new Property();
        $form = $this->createForm(PropertyFormType::class, $property);
        $form->handleRequest($request);

        $adresse = ($property->getAddresse()) ? $property->getAddresse() : new Addresse();

        if ($form->isSubmitted() && $form->isValid()) {
            $property->setUser($this->getUser());
            if (!$property->getAddresse()) {
                $adresse->setStreetNumber(0);
                $adresse->setStreetName("à modifier");
                $adresse->setCity("à modifier");
                $adresse->setCodeZip("à modifier");
                $adresse->setCountry("Fr");
                $property->setAddresse($adresse);
                $entityManager->persist($adresse);
            }

            $property->setStatus(0);
            $entityManager->persist($property);
            $entityManager->flush();
            return $this->redirectToRoute("manage-gallery", ['id' => $property->getId()]);
        }
        return $this->render('backoffice/property/EditOrAdd.html.twig', [
            'action' => "add",
            'propertyForm' => $form->createView()
        ]);
    }

    #[Route('/admin/property/{id}/gallery', name: 'manage-gallery')]
    public function manageGallery(Property $property, Request $request, EntityManagerInterface $entityManager): Response
    {
        $image = new Image();
        $imageForm = $this->createForm(ImageType::class, $image);
        $imageForm->handleRequest($request);

        if ($imageForm->isSubmitted() && $imageForm->isValid()) {

            $file = $request->files->get('image')['path'];
            $fileName = md5(uniqid()) . $file->getClientOriginalName();
            $file->move($this->getParameter("gallery_directory"), $fileName);
            $image->setPath($fileName);
            $image->setProperty($property);
            $entityManager->persist($image);
            $entityManager->flush();

            return $this->redirect($request->headers->get('referer'));
        }
        return $this->render('backoffice/property/gallery.html.twig', [
            'action' => "add",
            'property' => $property,
            'imageForm' => $imageForm->createView()
        ]);
    }
    #[Route('/admin/property/gallery/delete/{id}', name: 'remove-gallery')]
    public function deleteGallery(Image $image, Request $request, EntityManagerInterface $entityManager): Response
    {
        try {
            if (file_exists("../public/images/gallery/" . $image->getPath()))
                unlink("../public/images/gallery/" . $image->getPath());

            $entityManager->remove($image);
            $entityManager->flush();
        } catch (\Throwable $th) {
            $this->addFlash(
                'error',
                $th->getMessage()
            );
        }
        return $this->redirect($request->headers->get('referer'));
    }

    #[Route('/admin/property/{id}/equipment', name: 'manage-dynamic-properties')]
    public function manageDynamicEquipements(Property $property, Request $request, EntityManagerInterface $entityManager, EquipmentRepository $equipmentRepository): Response
    {
        if ($request->getMethod() === "POST") {
            foreach ($request->request as $key => $value) {
                $equipment = $equipmentRepository->find($key);
                $equipment->setValue($value);
                $entityManager->persist($equipment);
            }
            $entityManager->flush();
            return $this->redirect($request->headers->get('referer'));
        }

        return $this->render('backoffice/property/equipment.html.twig', [
            'action' => "edit",
            'property' => $property,
        ]);
    }


    #[Route('/admin/property/{id}/adresse', name: 'manage-adresse')]
    public function manageAdresse(Property $property, Request $request, EntityManagerInterface $entityManager): Response
    {
        $adresse = $property->getAddresse();
        $adresseForm = $this->createForm(AddressType::class, $adresse);
        $adresseForm->handleRequest($request);

        if ($adresseForm->isSubmitted() && $adresseForm->isValid()) {

            $entityManager->persist($adresse);
            $entityManager->flush();

            $this->addFlash(
                'success',
                "Terminé avec succès"
            );
            return $this->redirectToRoute("ads");
        }
        return $this->render('backoffice/property/adresse.html.twig', [
            'action' => "add",
            'adresseForm' => $adresseForm->createView()
        ]);
    }


    #[Route('/admin/property/{id}', name: 'manage-ad')]
    public function manageAd(Property $property, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PropertyFormType::class, $property);
        $form->handleRequest($request);

        $adresse = ($property->getAddresse() ?  $property->getAddresse() : new Addresse());
        $adresseForm = $this->createForm(AddressType::class, $adresse);
        $adresseForm->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() || $adresseForm->isSubmitted() && $adresseForm->isValid()) {
            $property->setAddresse($adresse);
            $entityManager->persist($adresse);
            $entityManager->persist($property);
            $entityManager->flush();

            return $this->redirectToRoute("manage-gallery", ['id' => $property->getId()]);
        }
        return $this->render('backoffice/property/EditOrAdd.html.twig', [
            'action' => "edit",
            'propertyForm' => $form->createView(),
            'adresseForm' => $adresseForm->createView(),
        ]);
    }

    #[Route('/admin/property/{id}/hide', name: 'admin_delete_ads')]
    public function hideAd(Property $property, Request $request, EntityManagerInterface $manager, PropertyRepository $propertyRepository): Response
    {
        if ($request->request->get('id') != null) {
            try {
                $property->setStatus(($property->getStatus()) ? 0 : 1);
                $manager->persist($property);
                $manager->flush();
                $this->addFlash(
                    'success',
                    "Changé avec succès"
                );
            } catch (\Throwable $th) {
                $this->addFlash(
                    'error',
                    $th->getMessage()
                );
            }
        }
        return $this->redirect($request->headers->get('referer'));
    }


    #[Route('/admin/property/{id}/availabilities', name: 'admin_availabilities')]
    public function nonAvailabilities(Property $property, Request $request, EntityManagerInterface $entityManager): Response
    {
        $unAvailability = new Unavailability();
        $form = $this->createForm(UnAvailabilityType::class, $unAvailability);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $unAvailability->setProperty($property);
            $entityManager->persist($unAvailability);
            $entityManager->flush();

            $this->addFlash(
                'success',
                "Date ajoutée avec succès"
            );
            return $this->redirect($request->headers->get('referer'));
        }

        return $this->render('backoffice/property/unavailability.html.twig', [
            'property' => $property,
            'unAvailabilityForm' => $form->createView(),
        ]);
    }


    #[Route('/admin/availability/{id}', name: 'admin_delete_availability')]
    public function deleteAvailability(Unavailability $unavailability, Request $request, EntityManagerInterface $manager): Response
    {
        if ($request->request->get('id') != null) {
            try {
                $manager->remove($unavailability);
                $manager->flush();
                $this->addFlash(
                    'success',
                    "Supprimée avec succès"
                );
            } catch (\Throwable $th) {
                $this->addFlash(
                    'error',
                    $th->getMessage()
                );
            }
        }
        return $this->redirect($request->headers->get('referer'));
    }

    #[Route('/admin/reviews', name: 'admin-reviews')]
    public function reviews(Request $request, PaginatorInterface $paginator, PropertyRepository $propertyRepository): Response
    {
        $properties = $paginator->paginate(
            $propertyRepository->findAll(),
            $request->query->getInt('page', 1),
            7
        );
        return $this->render('backoffice/property/reviews.html.twig', [
            'properties' => $properties,
        ]);
    }


    #[Route('/admin/property/{id}/reviews', name: 'admin-property-reviews')]
    public function propertyReviews(Property $property, Request $request, PaginatorInterface $paginator): Response
    {
        $reviews = $paginator->paginate(
            $property->getReviews(),
            $request->query->getInt('page', 1),
            6
        );
        return $this->render('backoffice/property/propertyReviews.html.twig', [
            'reviews' => $reviews,
        ]);
    }

    #[Route('/admin/review/{id}/remove', name: 'admin-remove-review')]
    public function removeReview(Review $review, Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        try {
            $entityManagerInterface->remove($review);
            $entityManagerInterface->flush();
            $this->addFlash(
                'success',
                'Supprimer avec succès'
            );
        } catch (\Throwable $th) {
            $this->addFlash(
                'error',
                $th->getMessage()
            );
        }
        return $this->redirect($request->headers->get('referer'));
    }
}
