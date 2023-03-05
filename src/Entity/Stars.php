<?php

namespace App\Entity;

use App\Repository\StarsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StarsRepository::class)]
class Stars
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'stars')]
    private ?User $uID = null;

    #[ORM\Column(nullable: true)]
    private ?int $rateIndex = null;

    #[ORM\ManyToOne(inversedBy: 'stars')]
    private ?Offre $offre_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUID(): ?User
    {
        return $this->uID;
    }

    public function setUID(?User $uID): self
    {
        $this->uID = $uID;

        return $this;
    }

    public function getRateIndex(): ?int
    {
        return $this->rateIndex;
    }

    public function setRateIndex(?int $rateIndex): self
    {
        $this->rateIndex = $rateIndex;

        return $this;
    }

    public function getOffreId(): ?Offre
    {
        return $this->offre_id;
    }

    public function setOffreId(?Offre $offre_id): self
    {
        $this->offre_id = $offre_id;

        return $this;
    }
}
