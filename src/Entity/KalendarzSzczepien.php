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
    /*
     public function szczepieniaSortujWgIdaj($parametr)
    {
        //$f = new Funkcje();
        $iterator = $this->szczepieniaUtrwalone->getIterator();
        $iterator->uasort(function ($a, $b) use ($parametr){
                $aInt = $a->dajParametr($parametr)->format('%Yy%Dd');
                $bInt= $b->dajParametr($parametr)->format('%Yy%Dd');
                return ($aInt < $bInt) ? -1 : 1;
            });
        return new ArrayCollection(iterator_to_array($iterator));
    }
     * */
    public function UstawSzczepieniomDateUrodzenia()
    {
        $dataUrodzenia = $this->getPacjent()->DataUrodzeniaDateObject();
        foreach($this->szczepieniaUtrwalone as $szczepienie)
        {
            $szczepienie->PrzyjmijDateUrodzenia($dataUrodzenia);
        }
    }
    public function szczepieniaSortujWgFunkcjiIdaj($funkcja)
    {
        $iterator = $this->szczepieniaUtrwalone->getIterator();
        $iterator->uasort(function ($a, $b) use ($funkcja){
            $af = call_user_func(array($a, $funkcja));
            $bf = call_user_func(array($b, $funkcja));
                return ($af < $bf) ? -1 : 1;   
        });
        return new ArrayCollection(iterator_to_array($iterator));
    }
    public function NazwyFunkcjiDawka()
    {
        return Dawka::NazwyFunkcji();
    }
    public function KtoreSczepieniaWykonane()
    {
        //$idPlanowane = array();
        $porownanieIndeksow = array();
        // = array();
        foreach($this->szczepieniaUtrwalone as $planowane)
        {
            $porownanieIndeksow[$planowane->getId()] = -1;
            //$idPlanowane[] = $planowane->getId();
        }
        $indeksWykonanych = 0;
        foreach($this->pacjent->getSzczepienia() as $wyk)
        {
            $id = $wyk->getCoPodano()->getId();
            
            $porownanieIndeksow[$id] = $indeksWykonanych++;
        }
        foreach($this->szczepieniaUtrwalone as $doSprawdzenia)
        {
            $i = $porownanieIndeksow[$doSprawdzenia->getId()];
            if($i > -1){
                $doSprawdzenia->czyPodana = true;
                $doSprawdzenia->przechowanaDataPodania = $this->pacjent->getSzczepienia()[$i]->getDataZabiegu();
            }
        }
        
    }
}
