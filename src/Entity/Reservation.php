<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ReservationRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ReservationRepository::class)
 */
#[ApiResource(
    normalizationContext: ['groups' => ['Property'], ['Reservation']],
    denormalizationContext: ['groups' => ['Property'], ['Reservation']]
)]
class Reservation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     * @Groups("Property","Reservation")
     */
   /*  #[Assert\NotBlank(message: "Veuillez remplir les champs requis")]
    #[Assert\NotNull(message: "Veuillez remplir les champs requis")]
    #[Assert\Date(message: "Veuillez remplir le champ avec une valeur correcte")] */
    private $start_date;

    /**
     * @ORM\Column(type="date")
     * @Groups("Property","Reservation")
     */
    /* #[Assert\NotBlank(message: "Veuillez remplir les champs requis")]
    #[Assert\NotNull(message: "Veuillez remplir les champs requis")]
    #[Assert\Date(message: "Veuillez remplir le champ avec une valeur correcte")] */
    private $end_date;

    /**
     * @ORM\Column(type="json")
     * @Groups("Property","Reservation")
     */
    /* #[Assert\NotBlank(message: "Veuillez remplir les champs requis")]
    #[Assert\NotNull(message: "Veuillez remplir les champs requis")]
    #[Assert\Json(message: "Veuillez remplir le champ avec une valeur correcte")] */
    private $property = [];

    /**
     * @ORM\Column(type="boolean")
     * @Groups("Property","Reservation")
     */
    /* #[Assert\NotBlank(message: "Veuillez remplir les champs requis")]
    #[Assert\NotNull(message: "Veuillez remplir les champs requis")] */
    private $status = 1;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=Property::class, inversedBy="bookings")
     * @ORM\JoinColumn(nullable=false)
     */
    /* #[Assert\NotBlank(message: "Veuillez remplir les champs requis")]
    #[Assert\NotNull(message: "Veuillez remplir les champs requis")] */
    private $reserved_property;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("Property","Reservation")
     */
    /* #[Assert\NotBlank(message: "Veuillez remplir les champs requis")]
    #[Assert\NotNull(message: "Veuillez remplir les champs requis")]
    #[Assert\Type(type: 'string', message: "Veuillez remplir le champ avec une valeur correcte")] */
    private $first_name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("Property","Reservation")
     */
    /* #[Assert\NotBlank(message: "Veuillez remplir les champs requis")]
    #[Assert\NotNull(message: "Veuillez remplir les champs requis")]
    #[Assert\Type(type: 'string', message: "Veuillez remplir le champ avec une valeur correcte")] */
    private $last_name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("Property","Reservation")
     */
    /* #[Assert\NotBlank(message: "Veuillez remplir les champs requis")]
    #[Assert\NotNull(message: "Veuillez remplir les champs requis")]
    #[Assert\Email(message: "Veuillez remplir le champ avec une valeur correcte")] */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    /* #[Assert\NotBlank(message: "Veuillez remplir les champs requis")]
    #[Assert\NotNull(message: "Veuillez remplir les champs requis")]
    #[Assert\Type(type: 'string', message: "Veuillez remplir le champ avec une valeur correcte")] */
    private $tel;

    /**
     * @ORM\Column(type="float")
     * @Groups("Property","Reservation")
     */
    /* #[Assert\NotBlank(message: "Veuillez remplir les champs requis")]
    #[Assert\NotNull(message: "Veuillez remplir les champs requis")]
    #[Assert\Type(type: 'float', message: "Veuillez remplir le champ avec une valeur correcte")] */
    private $priceHT;

    /**
     * @ORM\Column(type="string", length=255)
     */
    /* #[Assert\NotBlank(message: "Veuillez remplir les champs requis")]
    #[Assert\NotNull(message: "Veuillez remplir les champs requis")]
    #[Assert\Type(type: 'string', message: "Veuillez remplir le champ avec une valeur correcte")] */
    private $payment_method;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("Property","Reservation")
     */
    /* #[Assert\NotBlank(message: "Veuillez remplir les champs requis")]
    #[Assert\NotNull(message: "Veuillez remplir les champs requis")]
    #[Assert\Type(type: 'string', message: "Veuillez remplir le champ avec une valeur correcte")] */
    private $book_number;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="reservations")
     */
   /*  #[Assert\NotBlank(message: "Veuillez remplir les champs requis")]
    #[Assert\NotNull(message: "Veuillez remplir les champs requis")] */
    private $user;

    /**
     * @ORM\Column(type="integer")
     */
    /* #[Assert\NotBlank(message: "Veuillez remplir les champs requis")]
    #[Assert\NotNull(message: "Veuillez remplir les champs requis")]
    #[Assert\Type(type: 'integer', message: "Veuillez remplir le champ avec une valeur correcte")] */
    private $nbr_personne;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->start_date;
    }

    public function setStartDate(\DateTimeInterface $start_date): self
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->end_date;
    }

    public function setEndDate(\DateTimeInterface $end_date): self
    {
        $this->end_date = $end_date;

        return $this;
    }

    public function getProperty(): ?array
    {
        return $this->property;
    }

    public function setProperty(array $property): self
    {
        $this->property = $property;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function getReservedProperty(): ?Property
    {
        return $this->reserved_property;
    }

    public function setReservedProperty(?Property $reserved_property): self
    {
        $this->reserved_property = $reserved_property;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): self
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getPriceHT(): ?float
    {
        return $this->priceHT;
    }

    public function setPriceHT(float $priceHT): self
    {
        $this->priceHT = $priceHT;

        return $this;
    }

    public function getPaymentMethod(): ?string
    {
        return $this->payment_method;
    }

    public function setPaymentMethod(string $payment_method): self
    {
        $this->payment_method = $payment_method;

        return $this;
    }

    public function getBookNumber(): ?string
    {
        return $this->book_number;
    }

    public function setBookNumber(string $book_number): self
    {
        $this->book_number = $book_number;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getNbrPersonne(): ?int
    {
        return $this->nbr_personne;
    }

    public function setNbrPersonne(int $nbr_personne): self
    {
        $this->nbr_personne = $nbr_personne;

        return $this;
    }
}
