<?php

namespace App\Entity;

use App\Repository\StatusLectureRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StatusLectureRepository::class)]
class StatusLecture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?bool $status_lec = null;

    #[ORM\OneToOne(mappedBy: 'statusL', cascade: ['persist', 'remove'])]
    private ?Livre $livre = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isStatusLec(): ?bool
    {
        return $this->status_lec;
    }

    public function setStatusLec(?bool $status_lec): self
    {
        $this->status_lec = $status_lec;

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
            $this->livre->setStatusL(null);
        }

        // set the owning side of the relation if necessary
        if ($livre !== null && $livre->getStatusL() !== $this) {
            $livre->setStatusL($this);
        }

        $this->livre = $livre;

        return $this;
    }
}
