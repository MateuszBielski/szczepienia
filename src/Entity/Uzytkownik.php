<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UzytkownikRepository")
 */
class Uzytkownik
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
    private $imie = 'domyslneImie';

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Grupa", mappedBy="users")
     */
    private $groups;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Telefon", mappedBy="wlasciciel", orphanRemoval=true)
     */
    private $telefons;

    public function __construct()
    {
        $this->groups = new ArrayCollection();
        $this->telefons = new ArrayCollection();
    }
   
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImie(): ?string
    {
        return $this->imie;
    }

    public function setImie(string $imie): self
    {
        $this->imie = $imie;

        return $this;
    }

    /**
     * @return Collection|Grupa[]
     */
    public function getGroups(): Collection
    {
        return $this->groups;
    }

    public function addGroup(Grupa $group): self
    {
        if (!$this->groups->contains($group)) {
            $this->groups[] = $group;
            $group->addUser($this);
        }

        return $this;
    }

    public function removeGroup(Grupa $group): self
    {
        if ($this->groups->contains($group)) {
            $this->groups->removeElement($group);
            $group->removeUser($this);
        }

        return $this;
    }

    /**
     * @return Collection|Telefon[]
     */
    public function getTelefons(): Collection
    {
        return $this->telefons;
    }
    //umożliwia użycie formularza z pojedyńczym polem EntiyType, które generuje pojedyńczy egzemplarz telefon, a obsługa wymaga najwyraźniej metody:
    //setTelefons
    
    public function setTelefons(Telefon $telefon): self
    {
        $this->addTelefon($telefon);
        return $this;
    }
     
    /*poniższe nie zaspokaja obsługi formularza */
    public function setTelefon(Telefon $telefon): self
    {
        $this->addTelefon($telefon);
        return $this;
    }

    public function addTelefon(Telefon $telefon): self
    {
        if (!$this->telefons->contains($telefon)) {
            $this->telefons[] = $telefon;
            $telefon->setWlasciciel($this);
        }

        return $this;
    }

    public function removeTelefon(Telefon $telefon): self
    {
        if ($this->telefons->contains($telefon)) {
            $this->telefons->removeElement($telefon);
            // set the owning side to null (unless already changed)
            if ($telefon->getWlasciciel() === $this) {
                $telefon->setWlasciciel(null);
            }
        }

        return $this;
    }
}
