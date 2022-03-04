<?php

namespace App\Controller\Backoffice;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\Reservation;
use App\Repository\PropertyRepository;
use App\Repository\ReservationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminBookingController extends AbstractController
{
    #[Route('/admin/bookings', name: 'admin_bookings')]
    public function index(PropertyRepository $propertyRepository): Response
    {
        return $this->render('backoffice/booking/index.html.twig', [
            'properties' => $propertyRepository->findBy(['user' => $this->getUser()->getId()]),
        ]);
    }

    #[Route('/admin/booking/{book_number}', name: 'admin_booking')]
    public function booking(Reservation $reservation): Response
    {
        return $this->render('backoffice/booking/details.html.twig', [
            'book' => $reservation,
        ]);
    }

    #[Route('/admin/booking/annulation/{book_number}', name: 'admin_cancel_book')]
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


    #[Route('/admin/booking/facture/{book_number}', name: 'admin_booking_facture')]
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

    #[Route('/facture/{book_number}', name: 'facture')] //for testing
    public function getfacture(Reservation $reservation): Response
    {
        return $this->render('/pdf/facture.html.twig', [
            'reservation' => $reservation,
            'customer' => $reservation->getUser()
        ]);
    }
}
