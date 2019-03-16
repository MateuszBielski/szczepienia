<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SzczepienieRepository")
 */
class Szczepienie
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Pacjent", inversedBy="szczepienia")
     * @ORM\JoinColumn(nullable=false)
     */
    private $pacjent;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Szczepiacy", inversedBy="mojeSzczepienia")
     * @ORM\JoinColumn(nullable=false)
     */
    private $szczepiacy;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Dawka")
     * @ORM\JoinColumn(nullable=false)
     */
    private $coPodano;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPacjent(): ?Pacjent
    {
        return $this->pacjent;
    }

    public function setPacjent(?Pacjent $pacjent): self
    {
        $this->pacjent = $pacjent;

        return $this;
    }

    public function getSzczepiacy(): ?Szczepiacy
    {
        return $this->szczepiacy;
    }

    public function setSzczepiacy(?Szczepiacy $szczepiacy): self
    {
        $this->szczepiacy = $szczepiacy;

        return $this;
    }

    public function getCoPodano(): ?Dawka
    {
        return $this->coPodano;
    }

    public function setCoPodano(?Dawka $coPodano): self
    {
        $this->coPodano = $coPodano;

        return $this;
    }
}