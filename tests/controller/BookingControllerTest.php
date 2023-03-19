<?php
namespace App\Tests\controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\User;
use App\Entity\Reservation;
use APP\Entity\Unavailability;
use App\Entity\Property;
use App\Entity\PropertyType;
use App\Entity\Addresse;
use App\Entity\Image;
use APP\Controller\BookingController;

use DateTime;
use Symfony\Component\HttpFoundation\Request;

class BookingControllerTest extends WebTestCase
{
    static $client;
    static $reservation;
    static $property;
    static $image; 

    protected function setUp() :void
    {
        self::$client = static::createClient();

        $user = new User();
        $user->setFirstName('Jhon');
        $user->setLastName('Doe');
        $user->setEmail('test@example.com');
        $user->setSex('Homme');
        $user->setBirthDate(new DateTime());
        $user->setPhone("070000000");
        $user->setIsVerified(1);
        $user->setPassword('$3CR3T');

        $manager = static::getContainer()->get('doctrine')->getManager();
        $manager->persist($user);
        $manager->flush();
        
        self::$client->loginUser($user);

        $address = new Addresse();
        // Set the street number, street name, city, zip code, and country properties
        $address->setStreetNumber(123);
        $address->setStreetName('Main St');
        $address->setCity('New York');
        $address->setCodeZip('10001');
        $address->setCountry('United States');

        $propertyType = new PropertyType();
        $propertyType->setTitle('Apartment');
        $propertyType->setCreatedAt(DateTime::createFromFormat('Y-m-d', "2023-02-12"));
        $propertyType->setUpdatedAt(DateTime::createFromFormat('Y-m-d', "2023-02-12"));

        $manager->persist($propertyType);
        $manager->flush();


        self::$property = new Property();
        self::$property->setTitle("Cozy Studio Apartment in the Heart of Paris");
        self::$property->setDescription("This charming studio apartment is located in the heart of Paris, close to all the main attractions and public transportation. Perfect for solo travelers or couples, it offers a comfortable and cozy living space.");
        self::$property->setSuperficie(35.5);
        self::$property->setPrice(120);
        self::$property->setCapacity(2);
        self::$property->setRooms(1);
        self::$property->setPieces(2);
        self::$property->setWater(true);
        self::$property->setElectricity(true);
        self::$property->setLiterie("1 double bed, 1 sofa bed");
        self::$property->setSanitaire("1 bathroom with shower, toilet and sink");
        self::$property->setAddresse($address);
        self::$property->setIncludes("Free WiFi, TV, kitchen with fridge, microwave and stove, washing machine");
        self::$property->setPropertyType($propertyType);

        self::$reservation = new Reservation();
        self::$reservation->setReservedProperty(self::$property);
        self::$reservation->setBookNumber('123');
        self::$reservation->setStartDate(DateTime::createFromFormat('Y-m-d', "2023-02-12"));
        self::$reservation->setEndDate(DateTime::createFromFormat('Y-m-d', "2023-02-22"));
        self::$reservation->setFirstName("jhon");
        self::$reservation->setLastName("Doe");
        self::$reservation->setEmail("Jhon.doe@gmail.com");
        self::$reservation->setTel("07678766748");
        self::$reservation->setPriceHT(230);
        self::$reservation->setPaymentMethod("cash");
        self::$reservation->setNbrPersonne(4);

        
        self::$image = new Image();
        self::$image->setPath("toto");
        self::$image->setProperty(self::$property);

        $manager->persist(self::$property);
        $manager->flush();
        $manager->persist(self::$reservation);
        $manager->flush();
        $manager->persist(self::$image);
        $manager->flush();

    }

    public function testIndex(): void
    {
        self::$client->request('GET', '/reservations');

        $this->assertSame(200, self::$client->getResponse()->getStatusCode());
        $this->assertStringContainsString('Vous n\'avez aucune réservation', self::$client->getResponse()->getContent());
    }

    public function testBookDetails()
    {   
        //when
        self::$client->request('GET', '/reservation/'.self::$reservation->getBookNumber());

        // assert that the response is successful
        $this->assertSame(200, self::$client->getResponse()->getStatusCode());

        // assert that the property title and description are displayed in the response
        $this->assertStringContainsString(self::$property->getTitle(),  self::$client->getResponse()->getContent());
        $this->assertStringContainsString(self::$property->getDescription(),  self::$client->getResponse()->getContent());
    }
    

    public function testBook_should_fail_when_booking_id_is_false(): void
    {   
        //given
        $request = new Request([], [
            'dateStart' => '2024-02-12',
            'dateEnd' => '2024-02-22',
            'price' => 100,
            'nights' => 13,
            'capacity' => 2,
        ]);

        //when
        self::$client->request('POST', '/booking/1', [], [], [], json_encode($request->request->all()));
        
        //then
        $this->assertSame(404, self::$client->getResponse()->getStatusCode());
    }

    public function testBook_should_succes_when_user_confirm_booking(): void
    {
        //given
        $request = new Request([], [
            'dateStart' => '2024-02-12',
            'dateEnd' => '2024-02-22',
            'price' => 100,
            'nights' => 13,
            'capacity' => 2,
        ]);

        self::$property->addBooking(self::$reservation);
        self::$property->addImage(self::$image);

        $unavailability = new Unavailability();
        $unavailability->setProperty(self::$property);
        $unavailability->setStartDate(new DateTime('2023-02-12'));
        $unavailability->setEndDate(new DateTime('2023-03-30'));
        self::$property->addUnavailability($unavailability);
        $controller = new BookingController();
        $controller->setContainer(self::getContainer());
        
        //when
        $response = $controller->book(self::$property, $request);

        //then
        $this->assertStringContainsString('Je confirme avoir pris connaissance et accepter les Conditions générales', $response->getContent());
    }

}

