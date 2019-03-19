<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SzczepiacyRepository")
 */
class Szczepiacy
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nazwisko;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $imie;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Szczepienie", mappedBy="szczepiacy")
     */
    private $mojeSzczepienia;

    public function __construct()
    {
        $this->mojeSzczepienia = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImieInazwisko(): ?string
    {
        return sprintf('%s %s', $this->imie, $this->nazwisko);
    }
    public function getNazwisko(): ?string
    {
        return $this->nazwisko;
    }

    public function setNazwisko(?string $nazwisko): self
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

    /**
     * @return Collection|Szczepienie[]
     */
    public function getMojeSzczepienia(): Collection
    {
        return $this->mojeSzczepienia;
    }

    public function addMojeSzczepienium(Szczepienie $mojeSzczepienium): self
    {
        if (!$this->mojeSzczepienia->contains($mojeSzczepienium)) {
            $this->mojeSzczepienia[] = $mojeSzczepienium;
            $mojeSzczepienium->setSzczepiacy($this);
        }

        return $this;
    }

    public function removeMojeSzczepienium(Szczepienie $mojeSzczepienium): self
    {
        if ($this->mojeSzczepienia->contains($mojeSzczepienium)) {
            $this->mojeSzczepienia->removeElement($mojeSzczepienium);
            // set the owning side to null (unless already changed)
            if ($mojeSzczepienium->getSzczepiacy() === $this) {
                $mojeSzczepienium->setSzczepiacy(null);
            }
        }

        return $this;
    }
}
