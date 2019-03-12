<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TelefonRepository")
 */
class Telefon
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $numer;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Uzytkownik", inversedBy="telefons")
     * @ORM\JoinColumn(nullable=false)
     */
    private $wlasciciel;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumer(): ?int
    {
        return $this->numer;
    }

    public function setNumer(int $numer): self
    {
        $this->numer = $numer;

        return $this;
    }

    public function getWlasciciel(): ?Uzytkownik
    {
        return $this->wlasciciel;
    }

    public function setWlasciciel(?Uzytkownik $wlasciciel): self
    {
        $this->wlasciciel = $wlasciciel;

        return $this;
    }
}
