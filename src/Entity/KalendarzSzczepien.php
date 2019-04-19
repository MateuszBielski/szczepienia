<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\KalendarzSzczepienRepository")
 */
class KalendarzSzczepien
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Pacjent", inversedBy="kalendarzSzczepien", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $pacjent;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Dawka", inversedBy="wKtorychKalendarzachJestem")
     */
    private $szczepieniaUtrwalone;

    public function __construct()
    {
        $this->szczepieniaUtrwalone = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPacjent(): ?Pacjent
    {
        return $this->pacjent;
    }

    public function setPacjent(Pacjent $pacjent): self
    {
        $this->pacjent = $pacjent;

        return $this;
    }

    /**
     * @return Collection|Dawka[]
     */
    public function getSzczepieniaUtrwalone(): Collection
    {
        return $this->szczepieniaUtrwalone;
    }
    public function setSzczepieniaUtrwalone(ArrayCollection $dawki)
    {
        $this->szczepieniaUtrwalone = $dawki;
    }

    public function addSzczepieniaUtrwalone(Dawka $szczepieniaUtrwalone): self
    {
        if (!$this->szczepieniaUtrwalone->contains($szczepieniaUtrwalone)) {
            $this->szczepieniaUtrwalone[] = $szczepieniaUtrwalone;
        }

        return $this;
    }

    public function removeSzczepieniaUtrwalone(Dawka $szczepieniaUtrwalone): self
    {
        if ($this->szczepieniaUtrwalone->contains($szczepieniaUtrwalone)) {
            $this->szczepieniaUtrwalone->removeElement($szczepieniaUtrwalone);
        }

        return $this;
    }
}
