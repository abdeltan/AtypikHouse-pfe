<?php

namespace App\DataFixtures;

use App\Entity\Addresse;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $user = new User();
        $user->setFirstName('El Mahdi');
        $user->setLastName('Benbrahim');
        $user->setSex('Homme');
        $user->setPhone('0769242104');
        $user->setEmail('benbrahim.elmahdi@gmail.com');
        $user->setPassword(
            $this->passwordHasher->hashPassword($user, 'benbrahim.elmahdi@gmail.com')
        );
        $user->setRoles(array('ROLE_ADMIN'));
        $user->setStatus(true);

        $addresse = new Addresse();
        $addresse->setStreetNumber(26);
        $addresse->setStreetName($faker->streetName());
        $addresse->setCity($faker->city());
        $addresse->setCity($faker->city());
        $addresse->setCountry($faker->country());
        $addresse->setCodeZip($faker->postcode());

        $user->setAddresse($addresse);
        $manager->persist($addresse);
        $manager->persist($user);
        $manager->flush();
    }
}
