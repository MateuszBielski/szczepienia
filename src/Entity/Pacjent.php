<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PacjentRepository")
 */
class Pacjent
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nazwisko;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $imie;

    /**
     * @ORM\Column(type="integer")
     */
    private $pesel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Szczepienie", mappedBy="pacjent", orphanRemoval=true)
     */
    private $szczepienia;

    public function __construct()
    {
        $this->szczepienia = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNazwisko(): ?string
    {
        return $this->nazwisko;
    }

    public function setNazwisko(string $nazwisko): self
    {
        $this->nazwisko = $nazwisko;

        return $this;
    }

    public function getImie(): ?string
    {
        return $this->imie;
    }

    public function setImie(string $imie): self
    {
        $this->imie = $imie;

        return $this;
    }

    public function getPesel(): ?int
    {
        return $this->pesel;
    }

    public function setPesel(int $pesel): self
    {
        $this->pesel = $pesel;

        return $this;
    }

    /**
     * @return Collection|Szczepienie[]
     */
    public function getSzczepienia(): Collection
    {
        return $this->szczepienia;
    }

    public function addSzczepienium(Szczepienie $szczepienium): self
    {
        if (!$this->szczepienia->contains($szczepienium)) {
            $this->szczepienia[] = $szczepienium;
            $szczepienium->setPacjent($this);
        }

        return $this;
    }

    public function removeSzczepienium(Szczepienie $szczepienium): self
    {
        if ($this->szczepienia->contains($szczepienium)) {
            $this->szczepienia->removeElement($szczepienium);
            // set the owning side to null (unless already changed)
            if ($szczepienium->getPacjent() === $this) {
                $szczepienium->setPacjent(null);
            }
        }

        return $this;
    }
}
