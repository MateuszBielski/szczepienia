<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SzczepKtoreChorobyRepository")
 */
class SzczepKtoreChoroby
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Szczepionka", inversedBy="szczepKtoreChorobies")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_szczepionka;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Choroba")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_choroba;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdSzczepionka(): ?Szczepionka
    {
        return $this->id_szczepionka;
    }

    public function setIdSzczepionka(?Szczepionka $id_szczepionka): self
    {
        $this->id_szczepionka = $id_szczepionka;

        return $this;
    }

    public function getIdChoroba(): ?Choroba
    {
        return $this->id_choroba;
    }

    public function setIdChoroba(?Choroba $id_choroba): self
    {
        $this->id_choroba = $id_choroba;

        return $this;
    }
}
