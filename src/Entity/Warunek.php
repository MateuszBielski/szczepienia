<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WarunekRepository")
 */
class Warunek
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
    private $okreslenie;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Schemat", inversedBy="warunek")
     */
    private $schemat;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOkreslenie(): ?string
    {
        return $this->okreslenie;
    }

    public function setOkreslenie(?string $okreslenie): self
    {
        $this->okreslenie = $okreslenie;

        return $this;
    }

    public function getSchemat(): ?Schemat
    {
        return $this->schemat;
    }

    public function setSchemat(?Schemat $schemat): self
    {
        $this->schemat = $schemat;

        return $this;
    }
}
