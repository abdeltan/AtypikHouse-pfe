<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\EquipmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=EquipmentRepository::class)
 */

#[ApiResource(
    normalizationContext: ['groups' => ['Property'], ['Equipment']],
    denormalizationContext: ['groups' => ['Property'], ['Equipment']]
)]

class Equipment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("Property","Equipment")
     */
    /* #[Assert\NotBlank(message: "Veuillez remplir les champs requis")]
    #[Assert\NotNull(message: "Veuillez remplir les champs requis")]
    #[Assert\Type(type: 'string', message: "Veuillez remplir le champ avec une valeur correcte")] */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity=Property::class, inversedBy="equipments")
     * @Groups("Property","Equipment")
     */
    /* #[Assert\NotBlank(message: "Veuillez remplir les champs requis")]
    #[Assert\NotNull(message: "Veuillez remplir les champs requis")] */
    private $properties;

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
     * @ORM\Column(type="string", length=255)
     */
    /* #[Assert\NotBlank(message: "Veuillez remplir les champs requis")]
    #[Assert\NotNull(message: "Veuillez remplir les champs requis")] */
    private $value;

    /**
     * @ORM\Column(type="boolean")
     */
    /* #[Assert\NotBlank(message: "Veuillez remplir les champs requis")]
    #[Assert\NotNull(message: "Veuillez remplir les champs requis")] */
    private $required;

    public function __construct()
    {
        $this->property = new ArrayCollection();
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

    public function getProperties(): ?Property
    {
        return $this->properties;
    }

    public function setProperties(?Property $properties): self
    {
        $this->properties = $properties;

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

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getRequired(): ?bool
    {
        return $this->required;
    }

    public function setRequired(bool $required): self
    {
        $this->required = $required;

        return $this;
    }
}
