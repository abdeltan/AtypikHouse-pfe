<?php

namespace App\Controller\Backoffice;

use App\Entity\Attribute;
use App\Entity\Equipment;
use App\Entity\Notification;
use App\Entity\PropertyType;
use App\Entity\User;
use App\Form\AddressType;
use App\Form\AdminProfileType;
use App\Form\AdminUserFormType;
use App\Form\AttributeType;
use App\Form\EquipmentType;
use App\Repository\AttributeRepository;
use App\Repository\EquipmentRepository;
use App\Repository\PropertyRepository;
use App\Repository\PropertyTypeRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use \Mailjet\Resources;

class AdminHostController extends AbstractController
{
    #[Route('/admin/host', name: 'admin_host')]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('backoffice/host/index.html.twig', [
            "hosts" => $userRepository->findHosts()
        ]);
    }

    #[Route('/admin/host/{id}/edit', name: 'admin_edit_host')]
    public function editHost(User $user, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AdminUserFormType::class, $user);
        $form->handleRequest($request);

        $adresse = $user->getAddresse();
        $formAdress = $this->createForm(AddressType::class, $adresse);
        $formAdress->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash("success", "Modifié avec succès");

            return $this->redirectToRoute('admin_host');
        }

        if ($formAdress->isSubmitted() && $formAdress->isValid()) {
            $entityManager->persist($adresse);
            $entityManager->flush();

            $this->addFlash("success", "Modifié avec succès");

            return $this->redirectToRoute('admin_host');
        }
        return $this->render('backoffice/host/details.html.twig', [
            'hostForm' => $form->createView(),
            'addressForm' => $formAdress->createView(),
        ]);
    }

    #[Route('/admin/host/crm/', name: 'admin_crm')]
    public function crm(Request $request, EntityManagerInterface $entityManager, PropertyTypeRepository $propertyTypeRepository, PropertyRepository $propertyRepository, EquipmentRepository $equipmentRepository): Response
    {
        if ($request->getMethod() == "POST") {
            $properties = $propertyRepository->findBy(['propertyType' => $request->request->get('propertyType')]);
            foreach ($properties as $property) {
                $equipment = new  Equipment();
                $equipment->setTitle($request->request->get('title'));
                $equipment->setValue("");
                $equipment->setRequired(($request->request->get('required') === 1) ? true : false);
                $equipment->setProperties($property);
                $entityManager->persist($equipment);
                $notification = new Notification();
                $notification->setMessage("Vous avez reçus des nouvelles propriétés pour les annonces de type " . $propertyTypeRepository->find($request->request->get('propertyType'))->getTitle());
                $notification->setStatus(0);
                $notification->setUser($property->getUser());
                $entityManager->persist($notification);

                $this->sendNotification($property->getUser(), $propertyTypeRepository->find($request->request->get('propertyType'))->getTitle());
            }
            $entityManager->flush();
            $this->addFlash("success", "Ajouté avec succès");
            return $this->redirect($request->headers->get('referer'));
        }
        return $this->render('backoffice/crm/index.html.twig', [
            'action' => "edit",
            'types' => $propertyTypeRepository->findAll(),
        ]);
    }


    public function sendNotification(User $user, string $propertyType)
    {
        $mj = new \Mailjet\Client('71ebde5f7e838fe5b9afe08de78245e8', '6fb2a9006bc80e0c025fce7df7d19b8a', true, ['version' => 'v3.1']);
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "elmahdibenbrahim@etudiant.ief2i.fr",
                        'Name' => "AtypikHouse"
                    ],
                    'To' => [
                        [
                            'Email' => $user->getUserIdentifier(),
                            'Name' => $user->getLastName()
                        ]
                    ],
                    'TemplateID' => 3569334,
                    'TemplateLanguage' => true,
                    'Subject' => "nouvelles propriétés",
                    'Variables' => json_decode('{ "propertyType": "' . $propertyType . '" }', true)
                ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
    }
}
