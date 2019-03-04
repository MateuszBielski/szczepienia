<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ChorobaRepository")
 */
class Choroba
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Szczepionka2", inversedBy="przeciw")
     */
    private $szczepionka2;

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

    public function getSzczepionka2(): ?Szczepionka2
    {
        return $this->szczepionka2;
    }

    public function setSzczepionka2(?Szczepionka2 $szczepionka2): self
    {
        $this->szczepionka2 = $szczepionka2;

        return $this;
    }
}
