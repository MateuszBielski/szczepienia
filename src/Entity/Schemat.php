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
     * @ORM\OneToMany(targetEntity="App\Entity\Warunek", mappedBy="schemat")
     */
    private $warunek;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Dawka",cascade="persist", mappedBy="schemat", orphanRemoval=true)
     */
    private $dawki;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Szczepionka", inversedBy="schematy")
     * @ORM\JoinColumn(nullable=false)
     */
    private $podawania;

    public function __construct()
    {
        $this->warunek = new ArrayCollection();
        $this->dawki = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPodawania(): ?Szczepionka
    {
        return $this->podawania;
    }

    public function setPodawania(?Szczepionka $podawania): self
    {
        $this->podawania = $podawania;

        return $this;
    }
    public function DlaMoichDawekUstawMnieIponumeruj()
    {
        $numer = 1;
        foreach($this->dawki->getIterator() as $i => $dawka)
        {
            $dawka->setKtora($numer++);
            $dawka->setSchemat($this);
        }
    }
}
