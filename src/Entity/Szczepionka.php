<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SzczepionkaRepository")
 */
class Szczepionka
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $czyZywa;

    /**
     * @ORM\Column(type="boolean")
     */
    private $czyObowiazkowa;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $zastepujeSzczepionke;

    /**
     * @ORM\Column(type="integer")
     */
    private $wiekMin = 1;

    /**
     * @ORM\Column(type="integer")
     */
    private $wiekMax = 65;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nazwa = 'n_szczepionka';

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $producent;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Choroba")
     */
    private $przeciw;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Schemat", mappedBy="szczepionka")
     */
    private $schemat;

    public function __construct()
    {
        $this->przeciw = new ArrayCollection();
        $this->schemat = new ArrayCollection();
    }

    


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCzyZywa(): ?bool
    {
        return $this->czyZywa;
    }

    public function setCzyZywa(bool $czyZywa): self
    {
        $this->czyZywa = $czyZywa;

        return $this;
    }

    public function getCzyObowiazkowa(): ?bool
    {
        return $this->czyObowiazkowa;
    }

    public function setCzyObowiazkowa(bool $czyObowiazkowa): self
    {
        $this->czyObowiazkowa = $czyObowiazkowa;

        return $this;
    }

    public function getZastepujeSzczepionke(): ?int
    {
        return $this->zastepujeSzczepionke;
    }

    public function setZastepujeSzczepionke(?int $zastepujeSzczepionke): self
    {
        $this->zastepujeSzczepionke = $zastepujeSzczepionke;

        return $this;
    }

    public function getWiekMin(): ?int
    {
        return $this->wiekMin;
    }

    public function setWiekMin(int $wiekMin): self
    {
        $this->wiekMin = $wiekMin;

        return $this;
    }

    public function getWiekMax(): ?int
    {
        return $this->wiekMax;
    }

    public function setWiekMax(int $wiekMax): self
    {
        $this->wiekMax = $wiekMax;

        return $this;
    }

    public function getNazwa(): ?string
    {
        return $this->nazwa;
    }

    public function setNazwa(string $nazwa): self
    {
        $this->nazwa = $nazwa;

        return $this;
    }

    public function getProducent(): ?string
    {
        return $this->producent;
    }

    public function setProducent(?string $producent): self
    {
        $this->producent = $producent;

        return $this;
    }

    public function setPrzeciw(Choroba $choroba): self
    {
        return $this->addPrzeciw($choroba);
    }
    /**
     * @return Collection|Choroba[]
     */
    public function getPrzeciw(): Collection
    {
        return $this->przeciw;
    }

    public function addPrzeciw(Choroba $przeciw): self
    {
        if (!$this->przeciw->contains($przeciw)) {
            $this->przeciw[] = $przeciw;
        }

        return $this;
    }

    public function removePrzeciw(Choroba $przeciw): self
    {
        if ($this->przeciw->contains($przeciw)) {
            $this->przeciw->removeElement($przeciw);
        }

        return $this;
    }

    /**
     * @return Collection|Schemat[]
     */
    public function getSchemat(): Collection
    {
        return $this->schemat;
    }

    public function addSchemat(Schemat $schemat): self
    {
        if (!$this->schemat->contains($schemat)) {
            $this->schemat[] = $schemat;
            $schemat->setSzczepionka($this);
        }

        return $this;
    }

    public function removeSchemat(Schemat $schemat): self
    {
        if ($this->schemat->contains($schemat)) {
            $this->schemat->removeElement($schemat);
            // set the owning side to null (unless already changed)
            if ($schemat->getSzczepionka() === $this) {
                $schemat->setSzczepionka(null);
            }
        }

        return $this;
    }

    
}
