<?php

namespace App\Entity;

use App\Repository\ReviewRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReviewRepository::class)]
class Review
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $Note = null;

    #[ORM\Column(length: 255)]
    private ?string $Commentaire = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $DateCreation = null;

    #[ORM\ManyToOne(inversedBy: 'reviews')]
    private ?User $Utilisateur = null;

    #[ORM\ManyToOne(inversedBy: 'reviews')]
    private ?Player $Joueur = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?float
    {
        return $this->Note;
    }

    public function setNote(float $Note): static
    {
        $this->Note = $Note;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->Commentaire;
    }

    public function setCommentaire(string $Commentaire): static
    {
        $this->Commentaire = $Commentaire;

        return $this;
    }

    public function getDateCreation(): ?\DateTime
    {
        return $this->DateCreation;
    }

    public function setDateCreation(\DateTime $DateCreation): static
    {
        $this->DateCreation = $DateCreation;

        return $this;
    }

    public function getUtilisateur(): ?User
    {
        return $this->Utilisateur;
    }

    public function setUtilisateur(?User $Utilisateur): static
    {
        $this->Utilisateur = $Utilisateur;

        return $this;
    }

    public function getJoueur(): ?Player
    {
        return $this->Joueur;
    }

    public function setJoueur(?Player $Joueur): static
    {
        $this->Joueur = $Joueur;

        return $this;
    }

//     public function getCalculeAvis(?Player $j): float
// {
//     $reviews = $this->getNote();

//     if ($reviews->isEmpty()) {
//         return 0; // aucun avis
//     }
//     $sum = 0;
//     foreach ($reviews as $review) {
//         $sum += $review->getNote(); 
//     }
//     $res = $sum / count($reviews); 
//     return round($res, 2); 
// }

}
