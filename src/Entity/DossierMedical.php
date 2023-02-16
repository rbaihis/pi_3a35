<?php

namespace App\Entity;

use App\Repository\DossierMedicalRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
#[ORM\Entity(repositoryClass: DossierMedicalRepository::class)]
#[ORM\Table("dossier_medical")]
class DossierMedical
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column(length: 255)]
    #[Assert\NotBlank (message:"le champ est vide")]
    private ?string $firtName ;

    #[ORM\Column(length: 255)]
    private ?string $lastName ;

    #[ORM\Column(length: 255)]
    private ?string $email ;

    #[ORM\Column(length: 255)]
    private ?string $Analyses ;

    #[ORM\Column(length: 255)]
    private ?string $Maladies ;

    #[ORM\Column(length: 255)]
    private ?string $vaccins;

    #[ORM\Column(length: 255)]
    private ?string $intervention_chirurgicale ;

    #[ORM\Column(length: 255)]
    private ?string $date_naissance ;

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getFirtName(): ?string
    {
        return $this->firtName;
    }

    public function setFirtName(string $firtName): self
    {
        $this->firtName = $firtName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

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

    public function getAnalyses(): ?string
    {
        return $this->Analyses;
    }

    public function setAnalyses(?string $Analyses): self
    {
        $this->Analyses = $Analyses;

        return $this;
    }

    public function getMaladies(): ?string
    {
        return $this->Maladies;
    }

    public function setMaladies(string $Maladies): self
    {
        $this->Maladies = $Maladies;

        return $this;
    }

    public function getVaccins(): ?string
    {
        return $this->vaccins;
    }

    public function setVaccins(string $vaccins): self
    {
        $this->vaccins = $vaccins;

        return $this;
    }

    public function getInterventionChirurgicale(): ?string
    {
        return $this->intervention_chirurgicale;
    }

    public function setInterventionChirurgicale(string $intervention_chirurgicale): self
    {
        $this->Intervention_chirurgicale = $intervention_chirurgicale;

        return $this;
    }

    public function getDateNaissance(): ?string
    {
        return $this->date_naissance;
    }

    public function setDateNaissance(string $date_naissance): self
    {
        $this->date_naissance = $date_naissance;

        return $this;
    }
}
