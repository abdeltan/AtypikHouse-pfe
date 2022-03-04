<?php

namespace App\Entity;

use App\Repository\HistoryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass=HistoryRepository::class)
 */
class History
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
    private $action;

    /**
     * @ORM\Column(type="json")
     */
    /* #[Assert\NotBlank(message: "Veuillez remplir les champs requis")]
    #[Assert\NotNull(message: "Veuillez remplir les champs requis")]
    #[Assert\Json(message: "Veuillez remplir le champ avec une valeur correcte")] */
    private $data = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAction(): ?string
    {
        return $this->action;
    }

    public function setAction(string $action): self
    {
        $this->action = $action;

        return $this;
    }

    public function getData(): ?array
    {
        return $this->data;
    }

    public function setData(array $data): self
    {
        $this->data = $data;

        return $this;
    }
}
