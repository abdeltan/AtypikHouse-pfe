<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass=ImageRepository::class)
 */
#[ApiResource(
    normalizationContext: ['groups' => ['Property'], ['Image']],
    denormalizationContext: ['groups' => ['Property'], ['Image']],
)]
class Image
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("Property","Image")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("Property","Image")
     */
    /* #[Assert\NotBlank(message: "Veuillez remplir les champs requis")]
    #[Assert\NotNull(message: "Veuillez remplir les champs requis")]
    #[Assert\Type(type: 'string', message: "Veuillez remplir le champ avec une valeur correcte")] */
    private $path;

    /**
     * @ORM\ManyToOne(targetEntity=Property::class, inversedBy="images")
     */
    /* #[Assert\NotBlank(message: "Veuillez remplir les champs requis")]
    #[Assert\NotNull(message: "Veuillez remplir les champs requis")] */
    private $property;

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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getProperty(): ?Property
    {
        return $this->property;
    }

    public function setProperty(?Property $property): self
    {
        $this->property = $property;

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
}
