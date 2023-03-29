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
}
