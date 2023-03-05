<?php

namespace App\Entity;

use App\Repository\LikeActRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LikeActRepository::class)]
class LikeAct
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'Likes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Actualite $id_actualite = null;

    #[ORM\ManyToOne(inversedBy: 'likeActs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $id_user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdActualite(): ?Actualite
    {
        return $this->id_actualite;
    }

    public function setIdActualite(?Actualite $id_actualite): self
    {
        $this->id_actualite = $id_actualite;

        return $this;
    }

    public function getIdUser(): ?User
    {
        return $this->id_user;
    }

    public function setIdUser(?User $id_user): self
    {
        $this->id_user = $id_user;

        return $this;
    }
}
