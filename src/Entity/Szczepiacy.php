<?php

namespace App\Entity;
use App\Entity\Osoba;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SzczepiacyRepository")
 */
class Szczepiacy extends Osoba
{
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Szczepienie", mappedBy="szczepiacy")
     */
    private $mojeSzczepienia;

    public function __construct()
    {
        $this->mojeSzczepienia = new ArrayCollection();
    }

    /**
     * @return Collection|Szczepienie[]
     */
    public function getMojeSzczepienia(): Collection
    {
        return $this->mojeSzczepienia;
    }

    public function addMojeSzczepienium(Szczepienie $mojeSzczepienium): self
    {
        if (!$this->mojeSzczepienia->contains($mojeSzczepienium)) {
            $this->mojeSzczepienia[] = $mojeSzczepienium;
            $mojeSzczepienium->setSzczepiacy($this);
        }

        return $this;
    }

    public function removeMojeSzczepienium(Szczepienie $mojeSzczepienium): self
    {
        if ($this->mojeSzczepienia->contains($mojeSzczepienium)) {
            $this->mojeSzczepienia->removeElement($mojeSzczepienium);
            // set the owning side to null (unless already changed)
            if ($mojeSzczepienium->getSzczepiacy() === $this) {
                $mojeSzczepienium->setSzczepiacy(null);
            }
        }

        return $this;
    }
}
