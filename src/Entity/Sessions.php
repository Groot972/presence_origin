<?php

namespace App\Entity;

use App\Repository\SessionsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SessionsRepository::class)
 */
class Sessions
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;



    /**
     * @ORM\ManyToOne(targetEntity=Classes::class, inversedBy="sessions")
     */
    private $classe;

    /**
     * @ORM\OneToMany(targetEntity=Abscences::class, mappedBy="session")
     */
    private $abscences;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $jour;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $heure;

    /**
     * @ORM\ManyToOne(targetEntity=Cours::class, inversedBy="sessions")
     */
    private $cours;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $appel;

    public function __construct()
    {
        $this->abscences = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClasse(): ?Classes
    {
        return $this->classe;
    }

    public function setClasse(?Classes $classe): self
    {
        $this->classe = $classe;

        return $this;
    }

    /**
     * @return Collection<int, Abscences>
     */
    public function getAbscences(): Collection
    {
        return $this->abscences;
    }

    public function addAbscence(Abscences $abscence): self
    {
        if (!$this->abscences->contains($abscence)) {
            $this->abscences[] = $abscence;
            $abscence->setSession($this);
        }

        return $this;
    }

    public function removeAbscence(Abscences $abscence): self
    {
        if ($this->abscences->removeElement($abscence)) {
            // set the owning side to null (unless already changed)
            if ($abscence->getSession() === $this) {
                $abscence->setSession(null);
            }
        }

        return $this;
    }

    public function getJour(): ?string
    {
        return $this->jour;
    }

    public function setJour(string $jour): self
    {
        $this->jour = $jour;

        return $this;
    }

    public function getHeure(): ?string
    {
        return $this->heure;
    }

    public function setHeure(string $heure): self
    {
        $this->heure = $heure;

        return $this;
    }

    public function getCours(): ?Cours
    {
        return $this->cours;
    }

    public function setCours(?Cours $cours): self
    {
        $this->cours = $cours;

        return $this;
    }

    public function getAppel(): ?string
    {
        return $this->appel;
    }

    public function setAppel(string $appel): self
    {
        $this->appel = $appel;

        return $this;
    }
}
