<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use \Mailjet\Resources;

class MailerController extends AbstractController
{
    #[Route('/email', name: 'email')]
    public function sendEmail(): Response
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
                            'Email' => "benbrahim.elmahdi@gmail.com",
                            'Name' => "El Mahdi"
                        ]
                    ],
                    'Subject' => "Greetings from Mailjet.",
                    'TextPart' => "My first Mailjet email",
                    'HTMLPart' => "<h3>Dear passenger 1, welcome to <a href='https://www.mailjet.com/'>Mailjet</a>!</h3><br />May the delivery force be with you!",
                    'CustomID' => "AppGettingStartedTest"
                ]
            ]
        ];
        $mj->post(Resources::$Email, ['body' => $body]);
        return $this->redirectToRoute('home');
    }
}
