<?php

namespace App\Entity;

use App\Repository\StatusEnregistrementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StatusEnregistrementRepository::class)]
class StatusEnregistrement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?bool $status_enr = null;

    #[ORM\OneToOne(mappedBy: 'statusE', cascade: ['persist', 'remove'])]
    private ?Livre $livre = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isStatusEnr(): ?bool
    {
        return $this->status_enr;
    }

    public function setStatusEnr(?bool $status_enr): self
    {
        $this->status_enr = $status_enr;

        return $this;
    }

    public function getLivre(): ?Livre
    {
        return $this->livre;
    }

    public function setLivre(?Livre $livre): self
    {
        // unset the owning side of the relation if necessary
        if ($livre === null && $this->livre !== null) {
            $this->livre->setStatusE(null);
        }

        // set the owning side of the relation if necessary
        if ($livre !== null && $livre->getStatusE() !== $this) {
            $livre->setStatusE($this);
        }

        $this->livre = $livre;

        return $this;
    }
}
