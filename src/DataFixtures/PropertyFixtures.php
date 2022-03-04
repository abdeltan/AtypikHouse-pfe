<?php

namespace App\DataFixtures;

use App\Entity\Addresse;
use App\Entity\Equipment;
use App\Entity\Image;
use App\Entity\Property;
use App\Entity\PropertyType;
use App\Entity\Review;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class PropertyFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 30; $i++) {
            $property = new Property();
            $property->setTitle($faker->title());
            $property->setDescription($faker->text());
            $property->setSuperficie($faker->randomNumber(2));
            $property->setPrice($faker->randomNumber(3));
            $property->setCapacity($faker->randomNumber(1));
            $property->setStatus($faker->boolean(20));
            $property->setRooms($faker->randomNumber(1));
            $property->setPieces($faker->randomNumber(1));
            $property->setWater($faker->boolean(29));
            $property->setElectricity($faker->boolean(25));
            $property->setLiterie($faker->paragraphs(3));
            $property->setSanitaire($faker->paragraphs(3));

            $addresse = new Addresse();
            $addresse->setStreetNumber(26);
            $addresse->setStreetName($faker->streetName());
            $addresse->setCity($faker->city());
            $addresse->setCity($faker->city());
            $addresse->setCountry($faker->country());
            $addresse->setCodeZip($faker->postcode());

            $property->setAddresse($addresse);
            $property->setIncludes($faker->paragraphs(3));
            $property->setActivities($faker->paragraphs(3));

            $equipment = new Equipment();
            $equipment->setTitle($faker->title());
            $equipment->setIcon($faker->imageUrl());
            $equipment->setProperties($property);

            $image = new Image();
            $image->setPath($faker->imageUrl());
            $image->setProperty($property);

            $property->addImage($image);
            $review = new Review();
            $review->setComment($faker->realText(100));
            $review->setProperty($property);
            $review->setRating($faker->numberBetween(0, 5));
            $property->addReview($review);

            $propertyType = new PropertyType();
            $propertyType->setTitle($faker->text(10));
            $propertyType->setIcon($image);
            $property->setPropertyType($propertyType);

            $manager->persist($propertyType);
            $manager->persist($property);
            $manager->persist($addresse);
            $manager->persist($equipment);
            $manager->persist($image);
            $manager->persist($review);
            $manager->flush();
        }
    }
}
