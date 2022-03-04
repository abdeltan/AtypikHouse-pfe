<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ContactRepository::class)
 */
class Contact
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    /* #[Assert\NotBlank(message: "Veuillez remplir les champs requis")]
    #[Assert\NotNull(message: "Veuillez remplir les champs requis")]
    #[Assert\Type(type: 'string', message: "Veuillez remplir le champ avec une valeur correcte")] */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    /* #[Assert\NotBlank(message: "Veuillez remplir les champs requis")]
    #[Assert\NotNull(message: "Veuillez remplir les champs requis")]
    #[Assert\Type(type: 'string', message: "Veuillez remplir le champ avec une valeur correcte")] */
    private $message;

    /**
     * @ORM\Column(type="string", length=255)
     */
    /* #[Assert\NotBlank(message: "Veuillez remplir les champs requis")]
    #[Assert\NotNull(message: "Veuillez remplir les champs requis")]
    #[Assert\Type(type: 'string', message: "Veuillez remplir le champ avec une valeur correcte")]
    #[Assert\Email(message: "Veuillez remplir le champ avec une valeur correcte")] */
    private $email;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status = 0;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

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

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }
}
