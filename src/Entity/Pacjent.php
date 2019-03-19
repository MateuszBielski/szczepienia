<?php

namespace App\Entity;

use App\Entity\Osoba;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PacjentRepository")
 */
class Pacjent extends Osoba
{

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
