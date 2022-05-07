<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\User;
use DateTime;

class LoginTest extends WebTestCase
{

    public function testLogin(): void
    {
        $client = static::createClient();

        $user = new User();
        $user->setFirstName('Jhon');
        $user->setLastName('Doe');
        $user->setEmail('test@example.com');
        $user->setSex('Homme');
        $user->setBirthDate(new DateTime());
        $user->setPhone("070000000");
        $user->setIsVerified(1);
        $user->setPassword('$3CR3T');

        $manager = self::$container->get('doctrine')->getManager();
        $manager->persist($user);
        $manager->flush();

        $client->loginUser($user);

        $client->request('GET', '/mon-profile');

        $this->assertResponseIsSuccessful();

        $client->request('GET', '/logout');

        $this->assertResponseRedirects();

        $client->request('GET', '/login');

        $this->assertSelectorExists('h1','Connexion');
    }
}
