<?php

namespace App\Controller;

use App\Entity\Review;
use App\Repository\NotificationRepository;
use App\Repository\PropertyRepository;
use App\Repository\ReservationRepository;
use App\Repository\ReviewRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class MobileController extends AbstractController
{
    #[Route('/api/reservation', name: 'mobile-books')]
    /**
     * @Security("is_granted('ROLE_USER')")
     */
    public function index(PropertyRepository $propertyRepository, Request $request): Response
    {
        $reservations = [];
        $properties = $propertyRepository->findBy(['user' => $this->getUser()->getId()]);

        foreach ($properties as $property) {
            foreach ($property->getBookings() as $books) {
                if ($books->getStatus()) {
                    array_push($reservations, $books);
                }
            }
        }
        return $this->json($reservations, 200);
    }

    #[Route('/api/reservation/cancel', name: 'mobile-cancel-book')]
    /**
     * @Security("is_granted('ROLE_USER')")
     */
    public function cancel(PropertyRepository $propertyRepository, ReservationRepository $reservationRepository, Request $request): Response
    {
        try {
            $reservation = $reservationRepository->findOneBy(['book_number' => $request->query->get('number')]);
            $stripe = new \Stripe\StripeClient($this->getParameter('stripe_secret_key'));
            $stripe->refunds->create([
                'charge' => $reservation->getBookNumber(),
            ]);
            $reservation->setStatus(0);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($reservation);
            $manager->flush();
        } catch (\Throwable $th) {
            return $this->json(["error" => $th->getMessage()], 500);
        }

        $reservations = [];
        $properties = $propertyRepository->findBy(['user' => $this->getUser()->getId()]);

        foreach ($properties as $property) {
            foreach ($property->getBookings() as $books) {
                if ($books->getStatus()) {
                    array_push($reservations, $books);
                }
            }
        }

        return $this->json(["success" => 'Réservation annulée avec succès!', "reservation" => $reservations], 200);
    }


    #[Route('/api/notification', name: 'mobile-notifs')]
    /**
     * @Security("is_granted('ROLE_USER')")
     */
    public function notifications(NotificationRepository $notificationRepository): Response
    {
        $notifications = $notificationRepository->findBy(['user' => $this->getUser(), "status" => 0]);
        return $this->json($notifications, 200);
    }


    #[Route('/api/notification/clear', name: 'mobile-notifs-edit')]
    /**
     * @Security("is_granted('ROLE_USER')")
     */
    public function setReadNotification(NotificationRepository $notificationRepository, Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        $notifications = $this->getUser()->getNotifications();
        foreach ($notifications as $notif) {
            $notif->setStatus(1);
            $entityManagerInterface->persist($notif);
            $entityManagerInterface->flush();
        }
        $notifications = $notificationRepository->findBy(['user' => $this->getUser(), "status" => 0]);
        return $this->json($notifications, 200);
    }

    #[Route('/api/books', name: 'mobile-user-books')]
    /**
     * @Security("is_granted('ROLE_USER')")
     */
    public function getBookings(): Response
    {
        return $this->json($this->getUser()->getReservations(), 200);
    }

    #[Route('/api/property/review/add', name: 'add-book-Review')]
    /**
     * @Security("is_granted('ROLE_USER')")
     */
    public function addReview(Request $request, EntityManagerInterface $entityManagerInterface, PropertyRepository $propertyRepository, ReviewRepository $reviewRepository): Response
    {

        $data = json_decode($request->getContent());
        $property = $propertyRepository->find($data->id);

        if (!$reviewRepository->findOneBy(['user' => $this->getUser()->getId(), 'property' => $property->getId()])) {
            $review = new Review();
            $review->setProperty($property);
            $review->setUser($this->getUser());
            $review->setComment($data->comment);
            $review->setRating(intval($data->rate));
            $entityManagerInterface->persist($review);
            $entityManagerInterface->flush();
            return $this->json("Votre avis est pris en compte !", 200);
        } else
            return $this->json("Votre avis est déjà pris en compte!", 500);
    }
}
