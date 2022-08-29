<?php

namespace App\Entity;

use App\Repository\CoursRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CoursRepository::class)
 */
class Cours
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="cours")
     */
    private $professeur;

    /**
     * @ORM\ManyToMany(targetEntity=Classes::class, mappedBy="cours")
     */
    private $classes;

    /**
     * @ORM\OneToMany(targetEntity=Sessions::class, mappedBy="cours")
     */
    private $sessions;

    public function __construct()
    {
        $this->professeur = new ArrayCollection();
        $this->classes = new ArrayCollection();
        $this->sessions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getProfesseur(): Collection
    {
        return $this->professeur;
    }

    public function addProfesseur(User $professeur): self
    {
        if (!$this->professeur->contains($professeur)) {
            $this->professeur[] = $professeur;
            $professeur->setCours($this);
        }

        return $this;
    }

    public function removeProfesseur(User $professeur): self
    {
        if ($this->professeur->removeElement($professeur)) {
            // set the owning side to null (unless already changed)
            if ($professeur->getCours() === $this) {
                $professeur->setCours(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Classes>
     */
    public function getClasses(): Collection
    {
        return $this->classes;
    }

    public function addClass(Classes $class): self
    {
        if (!$this->classes->contains($class)) {
            $this->classes[] = $class;
            $class->addCour($this);
        }

        return $this;
    }

    public function removeClass(Classes $class): self
    {
        if ($this->classes->removeElement($class)) {
            $class->removeCour($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Sessions>
     */
    public function getSessions(): Collection
    {
        return $this->sessions;
    }

    public function addSession(Sessions $session): self
    {
        if (!$this->sessions->contains($session)) {
            $this->sessions[] = $session;
            $session->setCours($this);
        }

        return $this;
    }

    public function removeSession(Sessions $session): self
    {
        if ($this->sessions->removeElement($session)) {
            // set the owning side to null (unless already changed)
            if ($session->getCours() === $this) {
                $session->setCours(null);
            }
        }

        return $this;
    }
}
