<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DataFormatRepository")
 */
class DataFormat
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $urodziny;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrodziny(): ?\DateTimeInterface
    {
        return $this->urodziny;
    }

    public function setUrodziny(?\DateTimeInterface $urodziny): self
    {
        $this->urodziny = $urodziny;

        return $this;
    }
}
