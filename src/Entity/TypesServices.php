<?php

namespace App\Entity;

use App\Repository\TypesServicesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypesServicesRepository::class)]
class TypesServices
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $NomService = null;

    #[ORM\Column(length: 255)]
    private ?string $DescriptionService = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomService(): ?string
    {
        return $this->NomService;
    }

    public function setNomService(string $NomService): self
    {
        $this->NomService = $NomService;

        return $this;
    }

    public function getDescriptionService(): ?string
    {
        return $this->DescriptionService;
    }

    public function setDescriptionService(string $DescriptionService): self
    {
        $this->DescriptionService = $DescriptionService;

        return $this;
    }
}
