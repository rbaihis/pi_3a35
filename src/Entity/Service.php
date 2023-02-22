<?php

namespace App\Entity;

use App\Repository\ServiceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServiceRepository::class)]
class Service
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $NomService = null;

    #[ORM\Column(length: 255)]
    private ?string $Proprietaire = null;

    #[ORM\Column(length: 255)]
    private ?string $Role = null;

    #[ORM\Column(length: 255)]
    private ?string $id_service = null;

    #[ORM\ManyToOne(inversedBy: 'services')]
    private ?TypeService $TypeService = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: '0')]
    private ?string $prix = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $Date_Debut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $Date_Fin = null;

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

    public function getProprietaire(): ?string
    {
        return $this->Proprietaire;
    }

    public function setProprietaire(string $Proprietaire): self
    {
        $this->Proprietaire = $Proprietaire;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->Role;
    }

    public function setRole(string $Role): self
    {
        $this->Role = $Role;

        return $this;
    }

    public function getIdService(): ?string
    {
        return $this->id_service;
    }

    public function setIdService(string $id_service): self
    {
        $this->id_service = $id_service;

        return $this;
    }

    public function getTypeService(): ?TypeService
    {
        return $this->TypeService;
    }

    public function setTypeService(?TypeService $TypeService): self
    {
        $this->TypeService = $TypeService;

        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->Date_Debut;
    }

    public function setDateDebut(\DateTimeInterface $Date_Debut): self
    {
        $this->Date_Debut = $Date_Debut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->Date_Fin;
    }

    public function setDateFin(\DateTimeInterface $Date_Fin): self
    {
        $this->Date_Fin = $Date_Fin;

        return $this;
    }
}
