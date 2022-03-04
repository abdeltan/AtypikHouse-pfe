<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\NumericFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\PropertyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PropertyRepository::class)
 */
#[ApiResource(
    normalizationContext: ['groups' => ['Property']],
    denormalizationContext: ['groups' => ['Property']],
    forceEager: false
)]

#[ApiFilter(SearchFilter::class, properties: ["addresse.city", "propertyType.title"])]
#[ApiFilter(NumericFilter::class, properties: ["superficie", "price", "capacity", "rooms", "pieces"])]
#[ApiFilter(RangeFilter::class, properties: ["superficie", "price", "capacity", "rooms", "pieces"])]
#[ApiFilter(DateFilter::class, properties: ["bookings.start_date" => "exact", "bookings.end_date" => "exact"])]

class Property
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("Property")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("Property")
     */
    // #[Assert\NotBlank(message: "Veuillez remplir les champs requis")]
    // #[Assert\NotNull(message: "Veuillez remplir les champs requis")]
    // #[Assert\Type(type: 'string', message: "Veuillez remplir le champ avec une valeur correcte")]
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Groups("Property")
     */
    // #[Assert\NotBlank(message: "Veuillez remplir les champs requis")]
    // #[Assert\NotNull(message: "Veuillez remplir les champs requis")]
    // #[Assert\Type(type: 'string', message: "Veuillez remplir le champ avec une valeur correcte")]
    private $description;

    /**
     * @ORM\Column(type="float")
     * @Groups("Property")
     */
    // #[Assert\NotBlank(message: "Veuillez remplir les champs requis")]
    // #[Assert\NotNull(message: "Veuillez remplir les champs requis")]
    // #[Assert\Type(type: 'float', message: "Veuillez remplir le champ avec une valeur correcte")]
    private $superficie;

    /**
     * @ORM\Column(type="float")
     * @Groups("Property")
     */
    // #[Assert\NotBlank(message: "Veuillez remplir les champs requis")]
    // #[Assert\NotNull(message: "Veuillez remplir les champs requis")]
    // #[Assert\Type(type: 'float', message: "Veuillez remplir le champ avec une valeur correcte")]
    private $price;

    /**
     * @ORM\Column(type="integer")
     * @Groups("Property")
     */
    // #[Assert\NotBlank(message: "Veuillez remplir les champs requis")]
    // #[Assert\NotNull(message: "Veuillez remplir les champs requis")]
    // #[Assert\Type(type: 'integer', message: "Veuillez remplir le champ avec une valeur correcte")]
    private $capacity;

    /**
     * @ORM\Column(type="boolean")
     * @Groups("Property")
     */
    // #[Assert\NotBlank(message: "Veuillez remplir les champs requis")]
    // #[Assert\NotNull(message: "Veuillez remplir les champs requis")]
    private $status = 1;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups("Property")
     */
    // #[Assert\NotBlank(message: "Veuillez remplir les champs requis")]
    // #[Assert\NotNull(message: "Veuillez remplir les champs requis")]
    // #[Assert\Type(type: 'integer', message: "Veuillez remplir le champ avec une valeur correcte")]
    private $rooms;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups("Property")
     */
    // #[Assert\NotBlank(message: "Veuillez remplir les champs requis")]
    // #[Assert\NotNull(message: "Veuillez remplir les champs requis")]
    // #[Assert\Type(type: 'integer', message: "Veuillez remplir le champ avec une valeur correcte")]
    private $pieces;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups("Property")
     */
    // #[Assert\NotBlank(message: "Veuillez remplir les champs requis")]
    // #[Assert\NotNull(message: "Veuillez remplir les champs requis")]
    private $water;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups("Property")
     */
    // #[Assert\NotBlank(message: "Veuillez remplir les champs requis")]
    // #[Assert\NotNull(message: "Veuillez remplir les champs requis")]
    private $electricity;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups("Property")
     */
    // #[Assert\NotBlank(message: "Veuillez remplir les champs requis")]
    // #[Assert\NotNull(message: "Veuillez remplir les champs requis")]
    // #[Assert\Type(type: 'string', message: "Veuillez remplir le champ avec une valeur correcte")]
    private $literie;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups("Property")
     */
    // #[Assert\NotBlank(message: "Veuillez remplir les champs requis")]
    // #[Assert\NotNull(message: "Veuillez remplir les champs requis")]
    // #[Assert\Type(type: 'string', message: "Veuillez remplir le champ avec une valeur correcte")]
    private $sanitaire;

    /**
     * @ORM\OneToOne(targetEntity=Addresse::class, cascade={"persist", "remove"})
     * @Groups("Property")
     * #[ApiSubresource]
     */
    // #[Assert\NotBlank(message: "Veuillez remplir les champs requis")]
    // #[Assert\NotNull(message: "Veuillez remplir les champs requis")]
    private $addresse;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups("Property")
     */
    // #[Assert\NotBlank(message: "Veuillez remplir les champs requis")]
    // #[Assert\NotNull(message: "Veuillez remplir les champs requis")]
    // #[Assert\Type(type: 'string', message: "Veuillez remplir le champ avec une valeur correcte")]
    private $includes;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups("Property")
     */
    // #[Assert\NotBlank(message: "Veuillez remplir les champs requis")]
    // #[Assert\NotNull(message: "Veuillez remplir les champs requis")]
    // #[Assert\Type(type: 'string', message: "Veuillez remplir le champ avec une valeur correcte")]
    private $activities;

    /**
     * @ORM\OneToMany(targetEntity=Equipment::class, mappedBy="properties")
     * @Groups("Property")
     */
    // #[Assert\NotBlank(message: "Veuillez remplir les champs requis")]
    // #[Assert\NotNull(message: "Veuillez remplir les champs requis")]
    private $equipments;

    /**
     * @ORM\OneToMany(targetEntity=Image::class, mappedBy="property")
     * @Groups("Property")
     */
    // #[Assert\NotBlank(message: "Veuillez remplir les champs requis")]
    // #[Assert\NotNull(message: "Veuillez remplir les champs requis")]
    private $images;

    /**
     * @ORM\OneToMany(targetEntity=Review::class, mappedBy="property")
     * @Groups("Property")
     */
    // #[Assert\NotBlank(message: "Veuillez remplir les champs requis")]
    // #[Assert\NotNull(message: "Veuillez remplir les champs requis")]
    private $reviews;

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
     * @ORM\OneToMany(targetEntity=Reservation::class, mappedBy="reserved_property", orphanRemoval=true)
     * @Groups("Property")
     */
    #[ApiSubresource]
    // #[Assert\NotBlank(message: "Veuillez remplir les champs requis")]
    // #[Assert\NotNull(message: "Veuillez remplir les champs requis")]
    private $bookings;

    /**
     * @ORM\ManyToOne(targetEntity=PropertyType::class, inversedBy="properties")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("Property")
     */
    #[ApiSubresource]
    // #[Assert\NotBlank(message: "Veuillez remplir les champs requis")]
    // #[Assert\NotNull(message: "Veuillez remplir les champs requis")]
    private $propertyType;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="properties")
     */
    // #[Assert\NotBlank(message: "Veuillez remplir les champs requis")]
    // #[Assert\NotNull(message: "Veuillez remplir les champs requis")]
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Unavailability::class, mappedBy="property")
     */
    // #[Assert\NotBlank(message: "Veuillez remplir les champs requis")]
    // #[Assert\NotNull(message: "Veuillez remplir les champs requis")]
    private $unavailabilities;

    /**
     * @ORM\OneToMany(targetEntity=AttributeValue::class, mappedBy="property")
     */
    // #[Assert\NotBlank(message: "Veuillez remplir les champs requis")]
    // #[Assert\NotNull(message: "Veuillez remplir les champs requis")]
    private $attributeValues;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="property")
     */
    // #[Assert\NotBlank(message: "Veuillez remplir les champs requis")]
    // #[Assert\NotNull(message: "Veuillez remplir les champs requis")]
    private $messages;

    public function __construct()
    {
        $this->equipments = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->reviews = new ArrayCollection();
        $this->bookings = new ArrayCollection();
        $this->unavailabilities = new ArrayCollection();
        $this->attributeValues = new ArrayCollection();
        $this->messages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getSuperficie(): ?float
    {
        return $this->superficie;
    }

    public function setSuperficie(float $superficie): self
    {
        $this->superficie = $superficie;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): self
    {
        $this->capacity = $capacity;

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

    public function getRooms(): ?int
    {
        return $this->rooms;
    }

    public function setRooms(?int $rooms): self
    {
        $this->rooms = $rooms;

        return $this;
    }

    public function getPieces(): ?int
    {
        return $this->pieces;
    }

    public function setPieces(?int $pieces): self
    {
        $this->pieces = $pieces;

        return $this;
    }

    public function getWater(): ?bool
    {
        return $this->water;
    }

    public function setWater(?bool $water): self
    {
        $this->water = $water;

        return $this;
    }

    public function getElectricity(): ?bool
    {
        return $this->electricity;
    }

    public function setElectricity(?bool $electricity): self
    {
        $this->electricity = $electricity;

        return $this;
    }

    public function getLiterie(): ?string
    {
        return $this->literie;
    }

    public function setLiterie(?string $literie): self
    {
        $this->literie = $literie;

        return $this;
    }

    public function getSanitaire(): ?string
    {
        return $this->sanitaire;
    }

    public function setSanitaire(?string $sanitaire): self
    {
        $this->sanitaire = $sanitaire;

        return $this;
    }

    public function getAddresse(): ?Addresse
    {
        return $this->addresse;
    }

    public function setAddresse(?Addresse $addresse): self
    {
        $this->addresse = $addresse;

        return $this;
    }

    public function getIncludes(): ?string
    {
        return $this->includes;
    }

    public function setIncludes(?string $includes): self
    {
        $this->includes = $includes;

        return $this;
    }

    public function getActivities(): ?string
    {
        return $this->activities;
    }

    public function setActivities(?string $activities): self
    {
        $this->activities = $activities;

        return $this;
    }


    /**
     * @return Collection|Equipment[]
     */
    public function getEquipments(): Collection
    {
        return $this->equipments;
    }

    public function addEquipment(Equipment $equipment): self
    {
        if (!$this->equipments->contains($equipment)) {
            $this->equipments[] = $equipment;
            $equipment->setProperties($this);
        }

        return $this;
    }

    public function removeEquipment(Equipment $equipment): self
    {
        if ($this->equipments->removeElement($equipment)) {
            // set the owning side to null (unless already changed)
            if ($equipment->getProperties() === $this) {
                $equipment->setProperties(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Image[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setProperty($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getProperty() === $this) {
                $image->setProperty(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Review[]
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Review $review): self
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews[] = $review;
            $review->setProperty($this);
        }

        return $this;
    }

    public function removeReview(Review $review): self
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getProperty() === $this) {
                $review->setProperty(null);
            }
        }

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

    /**
     * @return Collection|Reservation[]
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Reservation $booking): self
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings[] = $booking;
            $booking->setReservedProperty($this);
        }

        return $this;
    }

    public function removeBooking(Reservation $booking): self
    {
        if ($this->bookings->removeElement($booking)) {
            // set the owning side to null (unless already changed)
            if ($booking->getReservedProperty() === $this) {
                $booking->setReservedProperty(null);
            }
        }

        return $this;
    }

    public function getPropertyType(): ?PropertyType
    {
        return $this->propertyType;
    }

    public function setPropertyType(?PropertyType $propertyType): self
    {
        $this->propertyType = $propertyType;

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

    /**
     * @return Collection|Unavailability[]
     */
    public function getUnavailabilities(): Collection
    {
        return $this->unavailabilities;
    }

    public function addUnavailability(Unavailability $unavailability): self
    {
        if (!$this->unavailabilities->contains($unavailability)) {
            $this->unavailabilities[] = $unavailability;
            $unavailability->setProperty($this);
        }

        return $this;
    }

    public function removeUnavailability(Unavailability $unavailability): self
    {
        if ($this->unavailabilities->removeElement($unavailability)) {
            // set the owning side to null (unless already changed)
            if ($unavailability->getProperty() === $this) {
                $unavailability->setProperty(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|AttributeValue[]
     */
    public function getAttributeValues(): Collection
    {
        return $this->attributeValues;
    }

    public function addAttributeValue(AttributeValue $attributeValue): self
    {
        if (!$this->attributeValues->contains($attributeValue)) {
            $this->attributeValues[] = $attributeValue;
            $attributeValue->setProperty($this);
        }

        return $this;
    }

    public function removeAttributeValue(AttributeValue $attributeValue): self
    {
        if ($this->attributeValues->removeElement($attributeValue)) {
            // set the owning side to null (unless already changed)
            if ($attributeValue->getProperty() === $this) {
                $attributeValue->setProperty(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setProperty($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getProperty() === $this) {
                $message->setProperty(null);
            }
        }

        return $this;
    }
}
