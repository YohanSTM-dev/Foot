<?php

namespace App\Entity;

use App\Repository\PlayerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlayerRepository::class)]
class Player
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Nom = null;

    #[ORM\Column(length: 255)]
    private ?string $Prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $Photo = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $DateDeNaissance = null;

    #[ORM\ManyToOne(inversedBy: 'players')]
    private ?Level $Niveau = null;

    #[ORM\ManyToOne(inversedBy: 'players')]
    private ?Category $CategorieSportive = null;

    /**
     * @var Collection<int, Review>
     */
    #[ORM\OneToMany(targetEntity: Review::class, mappedBy: 'Joueur')]
    private Collection $reviews;

    public function __construct()
    {
        $this->reviews = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): static
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->Prenom;
    }

    public function setPrenom(string $Prenom): static
    {
        $this->Prenom = $Prenom;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->Photo;
    }

    public function setPhoto(string $Photo): static
    {
        $this->Photo = $Photo;

        return $this;
    }

    public function getDateDeNaissance(): ?\DateTime
    {
        return $this->DateDeNaissance;
    }

    public function setDateDeNaissance(\DateTime $DateDeNaissance): static
    {
        $this->DateDeNaissance = $DateDeNaissance;

        return $this;
    }

    public function getNiveau(): ?Level
    {
        return $this->Niveau;
    }

    public function setNiveau(?Level $Niveau): static
    {
        $this->Niveau = $Niveau;

        return $this;
    }

    public function getCategorieSportive(): ?Category
    {
        return $this->CategorieSportive;
    }

    public function setCategorieSportive(?Category $CategorieSportive): static
    {
        $this->CategorieSportive = $CategorieSportive;

        return $this;
    }

    /**
     * @return Collection<int, Review>
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Review $review): static
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews->add($review);
            $review->setJoueur($this);
        }

        return $this;
    }

    public function removeReview(Review $review): static
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getJoueur() === $this) {
                $review->setJoueur(null);
            }
        }

        return $this;
    }

    public function getCalculeAvis(): float
{
    $reviews = $this->getReviews(); 

    if ($reviews->isEmpty()) {
        return 0; 
    }

    $sum = 0;
    foreach ($reviews as $review) {
        $sum += $review->getNote(); 
    }

    return round($sum / count($reviews), 2); 
}
}
