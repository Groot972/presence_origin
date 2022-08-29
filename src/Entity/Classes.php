<?php

namespace App\Entity;

use App\Repository\ClassesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClassesRepository::class)
 */
class Classes
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
     * @ORM\ManyToMany(targetEntity=Cours::class, inversedBy="classes")
     */
    private $cours;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="classes")
     */
    private $eleves;

    /**
     * @ORM\OneToMany(targetEntity=Sessions::class, mappedBy="classe")
     */
    private $sessions;

    public function __construct()
    {
        $this->cours = new ArrayCollection();
        $this->eleves = new ArrayCollection();
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
     * @return Collection<int, Cours>
     */
    public function getCours(): Collection
    {
        return $this->cours;
    }

    public function addCour(Cours $cour): self
    {
        if (!$this->cours->contains($cour)) {
            $this->cours[] = $cour;
        }

        return $this;
    }

    public function removeCour(Cours $cour): self
    {
        $this->cours->removeElement($cour);

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getEleves(): Collection
    {
        return $this->eleves;
    }

    public function addElefe(User $elefe): self
    {
        if (!$this->eleves->contains($elefe)) {
            $this->eleves[] = $elefe;
            $elefe->setClasses($this);
        }

        return $this;
    }

    public function removeElefe(User $elefe): self
    {
        if ($this->eleves->removeElement($elefe)) {
            // set the owning side to null (unless already changed)
            if ($elefe->getClasses() === $this) {
                $elefe->setClasses(null);
            }
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
            $session->setClasse($this);
        }

        return $this;
    }

    public function removeSession(Sessions $session): self
    {
        if ($this->sessions->removeElement($session)) {
            // set the owning side to null (unless already changed)
            if ($session->getClasse() === $this) {
                $session->setClasse(null);
            }
        }

        return $this;
    }
}
