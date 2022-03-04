<?php

namespace App\Tests;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\User;
use DateTime;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;

class AuthenticationTest extends ApiTestCase
{
    use ReloadDatabaseTrait;

    public function testLogin(): void
    {
        $client = self::createClient();

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

        // retrieve a token

        $response = $client->request('POST', '/authentication_token', [
            'headers' => ['Content-Type' => 'application/json'],
            'body' => json_encode([
                'email' => 'test@example.com',
                'password' => '$3CR3T',
            ]),
        ]);

        $json = $response->toArray();
        $this->assertResponseIsSuccessful();
        $this->assertArrayHasKey('token', $json);

        // test not authorized
        $client->request('GET', '/greetings');
        $this->assertResponseStatusCodeSame(401);

        // test authorized
        $client->request('GET', '/greetings', ['auth_bearer' => $json['token']]);
        $this->assertResponseIsSuccessful();
    }
}
