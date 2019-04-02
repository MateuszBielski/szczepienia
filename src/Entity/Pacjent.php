<?php

namespace App\Entity;

use App\Entity\Osoba;
use App\Entity\NumerPesel;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Validator as SprawdzeniePeselu;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;


/**
 * @ORM\Entity(repositoryClass="App\Repository\PacjentRepository")
 */
class Pacjent extends Osoba
{
    //private $logger;
    /**
     * @ORM\Column(type="string", length=11)
     * @SprawdzeniePeselu\Pesel
     */
    private $pesel;
    
    private $peselObiekt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Szczepienie", mappedBy="pacjent", orphanRemoval=true)
     */
    private $szczepienia;

    public function __construct()
    {
        $logger = new Logger('Mateusz');
        $logger->pushHandler(new StreamHandler('/home/mateusz/symfonyProjekt/szczepienia/var/log/dev.log', Logger::WARNING));
        $logger->warning('konstruktor');
        $this->szczepienia = new ArrayCollection();
        $this->peselObiekt = new NumerPesel();
    }

    public function getPesel(): ?string
    {
        //return $this->peselObiekt->getNumer();//mówi że pusty
        return $this->pesel;
    }

    public function setPesel(string $pesel): self
    {
        $logger = new Logger('Mateusz');
        $logger->pushHandler(new StreamHandler('/home/mateusz/symfonyProjekt/szczepienia/var/log/dev.log', Logger::WARNING));
        $logger->warning('setPesel');
        
        $this->pesel = $pesel;
        $this->peselObiekt->setNumer($pesel);
        return $this;
    }

    /**
     * @return Collection|Szczepienie[]
     */
    public function getSzczepienia(): Collection
    {
        return $this->szczepienia;
    }

    public function addSzczepienium(Szczepienie $szczepienium): self
    {
        if (!$this->szczepienia->contains($szczepienium)) {
            $this->szczepienia[] = $szczepienium;
            $szczepienium->setPacjent($this);
        }

        return $this;
    }

    public function removeSzczepienium(Szczepienie $szczepienium): self
    {
        if ($this->szczepienia->contains($szczepienium)) {
            $this->szczepienia->removeElement($szczepienium);
            // set the owning side to null (unless already changed)
            if ($szczepienium->getPacjent() === $this) {
                $szczepienium->setPacjent(null);
            }
        }

        return $this;
    }
    public function DataUrodzeniaZpeselu()
    {
        $rok = substr ( $this->pesel, 0, 2 );
        $miesiac = '';
        $dzien = '';
        return sprintf('%d %s %d',$dzien,$miesiac,$rok);
    }
}
