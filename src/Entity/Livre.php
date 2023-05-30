<?php

namespace App\Entity;

use App\Repository\LivreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LivreRepository::class)]
class Livre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_publication = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $editeur = null;

    #[ORM\Column(length: 255)]
    private ?string $genre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image_couverture = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description_livre = null;

    #[ORM\Column(length: 255)]
    private ?string $fichier = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $auteur = null;

   

    #[ORM\OneToMany(mappedBy: 'livre', targetEntity: Commentaire::class)]
    private Collection $commentaire;

    #[ORM\ManyToMany(targetEntity: Utilisateur::class, mappedBy: 'livrelu')]
    #[ORM\JoinTable(name: "livre_lecteur")]//ajouté
    private Collection $utilisateurlecteur;

    #[ORM\ManyToMany(targetEntity: Utilisateur::class, mappedBy: 'livreenregistre')]
    #[ORM\JoinTable(name: "livre_enregistreur")]//ajouté
    private Collection $utilisateurenregistreur;

    #[ORM\OneToMany(mappedBy: 'livre', targetEntity: Note::class)]
    private Collection $note;





    public function __construct()
    {
        $this->commentaire = new ArrayCollection();
        $this->utilisateurlecteur = new ArrayCollection();
        $this->utilisateurenregistreur = new ArrayCollection();
        $this->note = new ArrayCollection();
    }

    public function __toString(): string//++++
    {
        return $this->titre;//.' '.$this->year;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDatePublication(): ?\DateTimeInterface
    {
        return $this->date_publication;
    }

    public function setDatePublication(\DateTimeInterface $date_publication): self
    {
        $this->date_publication = $date_publication;

        return $this;
    }

    public function getEditeur(): ?string
    {
        return $this->editeur;
    }

    public function setEditeur(?string $editeur): self
    {
        $this->editeur = $editeur;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getImageCouverture(): ?string
    {
        return $this->image_couverture;
    }

    public function setImageCouverture(?string $image_couverture): self
    {
        $this->image_couverture = $image_couverture;

        return $this;
    }

    public function getDescriptionLivre(): ?string
    {
        return $this->description_livre;
    }

    public function setDescriptionLivre(?string $description_livre): self
    {
        $this->description_livre = $description_livre;

        return $this;
    }

    public function getFichier(): ?string
    {
        return $this->fichier;
    }

    public function setFichier(string $fichier): self
    {
        $this->fichier = $fichier;

        return $this;
    }

  

   

    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommentaire(): Collection
    {
        return $this->commentaire;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaire->contains($commentaire)) {
            $this->commentaire->add($commentaire);
            $commentaire->setLivre($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaire->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getLivre() === $this) {
                $commentaire->setLivre(null);
            }
        }

        return $this;
    }

    // public function getStatusE(): ?StatusEnregistrement
    // {
    //     return $this->statusE;
    // }

    // public function setStatusE(?StatusEnregistrement $statusE): self
    // {
    //     $this->statusE = $statusE;

    //     return $this;_
    // }

    // public function getStatusL(): ?StatusLecture
    // {
    //     return $this->statusL;
    // }

    // public function setStatusL(?StatusLecture $statusL): self
    // {
    //     $this->statusL = $statusL;

    //     return $this;
    // }

    /**
     * @return Collection<int, Utilisateur>
     */
    public function getUtilisateurlecteur(): Collection
    {
        return $this->utilisateurlecteur;
    }

    public function addUtilisateurlecteur(Utilisateur $utilisateurlecteur): self
    {
        if (!$this->utilisateurlecteur->contains($utilisateurlecteur)) {
            $this->utilisateurlecteur->add($utilisateurlecteur);
            $utilisateurlecteur->addLivrelu($this);
        }

        return $this;
    }

    public function removeUtilisateurlecteur(Utilisateur $utilisateurlecteur): self
    {
        if ($this->utilisateurlecteur->removeElement($utilisateurlecteur)) {
            $utilisateurlecteur->removeLivrelu($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Utilisateur>
     */
    public function getUtilisateurenregistreur(): Collection
    {
        return $this->utilisateurenregistreur;
    }

    public function addUtilisateurenregistreur(Utilisateur $utilisateurenregistreur): self
    {
        if (!$this->utilisateurenregistreur->contains($utilisateurenregistreur)) {
            $this->utilisateurenregistreur->add($utilisateurenregistreur);
            $utilisateurenregistreur->addLivreenregistre($this);
        }

        return $this;
    }

    public function removeUtilisateurenregistreur(Utilisateur $utilisateurenregistreur): self
    {
        if ($this->utilisateurenregistreur->removeElement($utilisateurenregistreur)) {
            $utilisateurenregistreur->removeLivreenregistre($this);
        }

        return $this;
    }

    public function getAuteur(): ?string
    {
        return $this->auteur;
    }

    public function setAuteur(?string $auteur): self
    {
        $this->auteur = $auteur;

        return $this;
    }

    /**
     * @return Collection<int, Note>
     */
    public function getNote(): Collection
    {
        return $this->note;
    }

    public function addNote(Note $note): self
    {
        if (!$this->note->contains($note)) {
            $this->note->add($note);
            $note->setLivre($this);
        }

        return $this;
    }

    public function removeNote(Note $note): self
    {
        if ($this->note->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getLivre() === $this) {
                $note->setLivre(null);
            }
        }

        return $this;
    }

}
