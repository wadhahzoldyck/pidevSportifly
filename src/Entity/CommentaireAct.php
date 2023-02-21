<?php

namespace App\Entity;

use App\Repository\CommentaireActRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use http\Message;
use Symfony\Component\Validator\Constraints as Asserts;

#[ORM\Entity(repositoryClass: CommentaireActRepository::class)]
class CommentaireAct
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message:"veillez entrer un contenu")]
    private ?string $contenu = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Gedmo\Timestampable]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToOne(inversedBy: 'commentaireActs')]
    private ?Actualite $id_actualite = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
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

}
