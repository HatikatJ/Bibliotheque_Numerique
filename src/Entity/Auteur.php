<?php

namespace App\Entity;

use App\Repository\AuteurRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AuteurRepository::class)]
class Auteur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_auteur = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nationalite = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $annee_naissance = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description_auteur = null;

    #[ORM\Column(length: 255)]
    private ?string $photo_couverture = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomAuteur(): ?string
    {
        return $this->nom_auteur;
    }

    public function setNomAuteur(string $nom_auteur): self
    {
        $this->nom_auteur = $nom_auteur;

        return $this;
    }

    public function getNationalite(): ?string
    {
        return $this->nationalite;
    }

    public function setNationalite(?string $nationalite): self
    {
        $this->nationalite = $nationalite;

        return $this;
    }

    public function getAnneeNaissance(): ?\DateTimeInterface
    {
        return $this->annee_naissance;
    }

    public function setAnneeNaissance(?\DateTimeInterface $annee_naissance): self
    {
        $this->annee_naissance = $annee_naissance;

        return $this;
    }

    public function getDescriptionAuteur(): ?string
    {
        return $this->description_auteur;
    }

    public function setDescriptionAuteur(?string $description_auteur): self
    {
        $this->description_auteur = $description_auteur;

        return $this;
    }

    public function getPhotoCouverture(): ?string
    {
        return $this->photo_couverture;
    }

    public function setPhotoCouverture(string $photo_couverture): self
    {
        $this->photo_couverture = $photo_couverture;

        return $this;
    }
}
