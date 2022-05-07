<?php

namespace App\Tests;

use Symfony\Component\Panther\PantherTestCase;

class BookingTest extends PantherTestCase
{
    public function testBooking(): void
    {
        //Login
        $client = static::createPantherClient();

        $crawler = $client->request('GET', '/login');

        $this->assertPageTitleContains('Connexion');

        $email = $crawler->filter('input[type=email]');
        $email->sendKeys('abdelilah.tanoti@gmail.com');

        $password = $crawler->filter('input[type=password]');
        $password->sendKeys('password');

        $btn = $crawler->filter('button[type="submit"]')->eq(0)->link();
        $crawler = $client->click($btn);
    }
}
