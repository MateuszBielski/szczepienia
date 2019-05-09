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

    /**
     * @ORM\Column(type="date")
     */
    private $startYear;

    /**
     * @ORM\Column(type="date")
     * @ORM\JoinColumn(nullable=false)
     */
    private $endYear;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Schemat", inversedBy="isSubstitutedBy", cascade={"persist", "remove"})
     */
    private $substitute = null;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Schemat", mappedBy="substitute", cascade={"persist", "remove"})
     */
    private $isSubstitutedBy = null;

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
    public function DolaczMojeDawkiDo(ArrayCollection $tworzonyZbior)
    {
        foreach($this->dawki as $dawka) $tworzonyZbior[] = $dawka; 
    }
    public function ObowiazujeDla(Pacjent $pacjent)
    {
        return true;
    }

    public function getStartYear(): ?\DateTimeInterface
    {
        return $this->startYear;
    }

    public function setStartYear(\DateTimeInterface $startYear): self
    {
        $this->startYear = $startYear;

        return $this;
    }

    public function getEndYear(): ?\DateTimeInterface
    {
        return $this->endYear;
    }

    public function setEndYear(\DateTimeInterface $endYear): self
    {
        $this->endYear = $endYear;

        return $this;
    }

    public function getSubstitute(): ?self
    {
        return $this->substitute;
    }

    public function setSubstitute(?self $substitute): self
    {
        $this->substitute = $substitute;

        return $this;
    }

    public function getIsSubstitutedBy(): ?self
    {
        return $this->IsSubstitutedBy;
    }

    public function setIsSubstitutedBy(?self $IsSubstitutedBy): self
    {
        $this->IsSubstitutedBy = $IsSubstitutedBy;

        // set (or unset) the owning side of the relation if necessary
        $newSubstitute = $IsSubstitutedBy === null ? null : $this;
        if ($newSubstitute !== $IsSubstitutedBy->getSubstitute()) {
            $IsSubstitutedBy->setSubstitute($newSubstitute);
        }

        return $this;
    }
    public function getVaccineNameAndStartYear(): string
    {
        return $this->podawania->getNazwa().' '.$this->startYear->format('Y');
    }
}
