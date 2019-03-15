<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SchematRepository")
 */
class Schemat
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Szczepionka", inversedBy="warunek")
     * @ORM\JoinColumn(nullable=false)
     */
    private $szczepionka;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Warunek", mappedBy="schemat")
     */
    private $warunek;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Dawka", mappedBy="schemat", orphanRemoval=true)
     */
    private $dawki;

    public function __construct()
    {
        $this->warunek = new ArrayCollection();
        $this->dawki = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSzczepionka(): ?Szczepionka
    {
        return $this->szczepionka;
    }

    public function setSzczepionka(?Szczepionka $szczepionka): self
    {
        $this->szczepionka = $szczepionka;

        return $this;
    }

    /**
     * @return Collection|Warunek[]
     */
    public function getWarunek(): Collection
    {
        return $this->warunek;
    }

    public function addWarunek(Warunek $warunek): self
    {
        if (!$this->warunek->contains($warunek)) {
            $this->warunek[] = $warunek;
            $warunek->setSchemat($this);
        }

        return $this;
    }

    public function removeWarunek(Warunek $warunek): self
    {
        if ($this->warunek->contains($warunek)) {
            $this->warunek->removeElement($warunek);
            // set the owning side to null (unless already changed)
            if ($warunek->getSchemat() === $this) {
                $warunek->setSchemat(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Dawka[]
     */
    public function getDawki(): Collection
    {
        return $this->dawki;
    }

    public function addDawki(Dawka $dawki): self
    {
        if (!$this->dawki->contains($dawki)) {
            $this->dawki[] = $dawki;
            $dawki->setSchemat($this);
        }

        return $this;
    }

    public function removeDawki(Dawka $dawki): self
    {
        if ($this->dawki->contains($dawki)) {
            $this->dawki->removeElement($dawki);
            // set the owning side to null (unless already changed)
            if ($dawki->getSchemat() === $this) {
                $dawki->setSchemat(null);
            }
        }

        return $this;
    }
}
