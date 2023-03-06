<?php

namespace App\Entity;

use App\Repository\SyrineRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SyrineRepository::class)]
class Syrine
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nomprenom = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomprenom(): ?string
    {
        return $this->nomprenom;
    }

    public function setNomprenom(?string $nomprenom): self
    {
        $this->nomprenom = $nomprenom;

        return $this;
    }
}
