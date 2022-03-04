<?php

namespace App\Controller;

use App\Entity\Property;
use App\Entity\Reservation;
use App\Entity\User;
use App\Repository\PropertyRepository;
use App\Repository\ReservationRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Constraints\Date;
use \Mailjet\Resources;
use Dompdf\Dompdf;
use Dompdf\Options;

class BookingController extends AbstractController
{

    #[Route('/reservations', name: 'reservations')]
    /**
     * @Security("is_granted('ROLE_USER')")
     */
    public function index(): Response
    {
        return $this->render('booking/history.html.twig', [
            'reservations' => $this->getUser()->getReservations()
        ]);
    }

    #[Route('/reservation/{book_number}', name: 'reservation_detail')]
    /**
     * @Security("is_granted('ROLE_USER')")
     */
    public function bookDetails(Reservation $reservation): Response
    {
        return $this->render('booking/details.html.twig', [
            'reservation' => $reservation,
            'property' => $reservation->getReservedProperty()
        ]);
    }

    #[Route('/booking/{id}', name: 'book')]
    /**
     * @Security("is_granted('ROLE_USER')")
     */
    public function book(Property $property, Request $request): Response
    {

        $avail = true;
        $bookings = $property->getBookings();
        $unavails = $property->getUnavailabilities();
        foreach ($bookings as $book) {
            if ($book->getStartDate() < new DateTime($request->request->get('dateStart')) && $book->getEndDate() > new DateTime($request->request->get('dateEnd'))) {
                $avail = false;
            }
        }

        foreach ($unavails as $unavail) {
            if ($unavail->getStartDate() <  new DateTime($request->request->get('dateEnd')) && $unavail->getEndDate() >  new DateTime($request->request->get('dateEnd'))) {
                $avail = false;
            }
        }

        if (!$avail) {
            $this->addFlash('error', "Non disponible, veuillez modifier les dates.");
            return $this->redirect($request->headers->get('referer'));
        } else {
            return $this->render('booking/index.html.twig', [
                'book' => $request->request->all(),
                'property' => $property,
                'ttc' => floatval($request->get('price')) + (floatval($request->get('price')) * 0.2),
            ]);
        }
    }

    #[Route('/booking/annulation/{book_number}', name: 'cancel_book')]
    /**
     * @Security("is_granted('ROLE_USER')")
     */
    public function cancelPayment(Reservation $reservation, Request $request): Response
    {
        try {
            $stripe = new \Stripe\StripeClient($this->getParameter('stripe_secret_key'));
            $stripe->refunds->create([
                'charge' => $reservation->getBookNumber(),
            ]);
            $reservation->setStatus(0);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($reservation);
            $manager->flush();
            $this->addFlash('success', 'Réservation annulée avec succès!');
            return $this->redirect($request->headers->get('referer'));
        } catch (\Throwable $th) {
            $this->addFlash('error', $th->getMessage());
            return $this->redirect($request->headers->get('referer'));
        }
    }

    #[Route('/payment', name: 'payment')]
    /**
     * @Security("is_granted('ROLE_USER')")
     */
    public function payment(Request $request, PropertyRepository $propertyRepository, EntityManagerInterface $entityManagerInterface, MailerInterface $mailer): Response
    {
        if ($request->isMethod('POST')) {
            try {
                $token = $request->request->get('stripeToken');
                $ttc = $request->request->get('price') + ($request->request->get('price') * 0.2);
                \Stripe\Stripe::setApiKey($this->getParameter('stripe_secret_key'));
                $result = \Stripe\Charge::create(array(
                    "amount" => ($ttc * 100),
                    "currency" => "eur",
                    "source" => $token,
                    "description" => "Client :" . $this->getUser()->getUserIdentifier()
                ));
                $reservation = new Reservation();
                $reservation->setBookNumber($result->id);
                $reservation->setReservedProperty($propertyRepository->find($request->request->get('id')));
                $reservation->setStartDate(new DateTime($request->request->get('dateStart')));
                $reservation->setEndDate(new DateTime($request->request->get('dateEnd')));
                $reservation->setEndDate(new DateTime($request->request->get('dateEnd')));
                $reservation->setProperty($propertyRepository->findAsArray($request->request->get('id')));
                $reservation->setFirstName($request->request->get('firstName'));
                $reservation->setLastName($request->request->get('lastName'));
                $reservation->setEmail($request->request->get('email'));
                $reservation->setTel($request->request->get('tel'));
                $reservation->setPriceHT($request->request->get('price'));
                $reservation->setPaymentMethod("CB");
                $reservation->setUser($this->getUser());
                $reservation->setNbrPersonne($request->request->get('capacity'));
                $entityManagerInterface->persist($reservation);
                $entityManagerInterface->flush();

                $receipt = file_get_contents($result->receipt_url);

                $this->sendMail($this->getUser(), "RMMH Commande N° " . $result->id, $receipt);
                $this->addFlash('success', 'Commande terminée avec succès!');
                return $this->redirectToRoute('reservations');
            } catch (\Throwable $th) {
                $this->addFlash('error', $th->getMessage());
                return $this->redirect($request->headers->get('referer'));
            }
        }
        $this->addFlash('error', 'GET not allowed');
        return $this->redirect($request->headers->get('referer'));
    }

    public function sendMail(User $to, string $subject, string $html)
    {
        $mj = new \Mailjet\Client('71ebde5f7e838fe5b9afe08de78245e8', '6fb2a9006bc80e0c025fce7df7d19b8a', true, ['version' => 'v3.1']);
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "contact@f2i-dev1-eb-ob-at-km.fr",
                        'Name' => "AtypikHouse"
                    ],
                    'To' => [
                        [
                            'Email' =>  $to->getUserIdentifier(),
                            'Name' => $to->getLastName()
                        ]
                    ],
                    'Subject' => $subject,
                    'HTMLPart' => $html,
                ]
            ]
        ];
        $mj->post(Resources::$Email, ['body' => $body]);
    }

    #[Route('/booking/facture/{book_number}', name: 'booking_facture')]
    public function facture(Reservation $reservation): Response
    {
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        $dompdf = new Dompdf($pdfOptions);

        $html = $this->renderView('/pdf/facture.html.twig', [
            'reservation' => $reservation,
            'customer' => $reservation->getUser()
        ]);

        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();

        $dompdf->stream("facture.pdf", [
            "Attachment" => true
        ]);

        return $this->redirect($request->headers->get('referer'));
    }
}
