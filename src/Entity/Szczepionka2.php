<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Szczepionka2Repository")
 */
class Szczepionka2
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
    private $nazwa;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $producent;

    /**
     * @ORM\Column(type="integer")
     */
    private $wiekMin;

    /**
     * @ORM\Column(type="integer")
     */
    private $wiekMax;

    /**
     * @ORM\Column(type="boolean")
     */
    private $czyObowiazkowa;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $zastepuje;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Choroba", mappedBy="szczepionka2")
     */
    private $przeciw;

    public function __construct()
    {
        $this->przeciw = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function setProducent(string $producent): self
    {
        $this->producent = $producent;

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

    public function getCzyObowiazkowa(): ?bool
    {
        return $this->czyObowiazkowa;
    }

    public function setCzyObowiazkowa(bool $czyObowiazkowa): self
    {
        $this->czyObowiazkowa = $czyObowiazkowa;

        return $this;
    }

    public function getZastepuje(): ?int
    {
        return $this->zastepuje;
    }

    public function setZastepuje(?int $zastepuje): self
    {
        $this->zastepuje = $zastepuje;

        return $this;
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
            $przeciw->setSzczepionka2($this);
        }

        return $this;
    }

    public function removePrzeciw(Choroba $przeciw): self
    {
        if ($this->przeciw->contains($przeciw)) {
            $this->przeciw->removeElement($przeciw);
            // set the owning side to null (unless already changed)
            if ($przeciw->getSzczepionka2() === $this) {
                $przeciw->setSzczepionka2(null);
            }
        }

        return $this;
    }
}
