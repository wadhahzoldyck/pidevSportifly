<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
class Utilisateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column]
    private ?int $age = null;

    #[ORM\OneToMany(mappedBy: 'id_user', targetEntity: Activiter::class)]
    private Collection $activiters;

    public function __construct()
    {
        $this->activiters = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    /**
     * @return Collection<int, Activiter>
     */
    public function getActiviters(): Collection
    {
        return $this->activiters;
    }

    public function addActiviter(Activiter $activiter): self
    {
        if (!$this->activiters->contains($activiter)) {
            $this->activiters->add($activiter);
            $activiter->setIdUser($this);
        }

        return $this;
    }

    public function removeActiviter(Activiter $activiter): self
    {
        if ($this->activiters->removeElement($activiter)) {
            // set the owning side to null (unless already changed)
            if ($activiter->getIdUser() === $this) {
                $activiter->setIdUser(null);
            }
        }

        return $this;

    }



}
