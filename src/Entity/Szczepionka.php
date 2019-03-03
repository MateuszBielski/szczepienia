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
    private $wiekMin;

    /**
     * @ORM\Column(type="integer")
     */
    private $wiekMax;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nazwa;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $producent;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SzczepKtoreChoroby", mappedBy="id_szczepionka", orphanRemoval=true)
     */
    private $szczepKtoreChorobies;

    public function __construct()
    {
        $this->szczepKtoreChorobies = new ArrayCollection();
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

    /**
     * @return Collection|SzczepKtoreChoroby[]
     */
    public function getSzczepKtoreChorobies(): Collection
    {
        return $this->szczepKtoreChorobies;
    }

    public function addSzczepKtoreChoroby(SzczepKtoreChoroby $szczepKtoreChoroby): self
    {
        if (!$this->szczepKtoreChorobies->contains($szczepKtoreChoroby)) {
            $this->szczepKtoreChorobies[] = $szczepKtoreChoroby;
            $szczepKtoreChoroby->setIdSzczepionka($this);
        }

        return $this;
    }

    public function removeSzczepKtoreChoroby(SzczepKtoreChoroby $szczepKtoreChoroby): self
    {
        if ($this->szczepKtoreChorobies->contains($szczepKtoreChoroby)) {
            $this->szczepKtoreChorobies->removeElement($szczepKtoreChoroby);
            // set the owning side to null (unless already changed)
            if ($szczepKtoreChoroby->getIdSzczepionka() === $this) {
                $szczepKtoreChoroby->setIdSzczepionka(null);
            }
        }

        return $this;
    }
}
