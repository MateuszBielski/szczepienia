<?php

namespace App\Entity;

use App\Funkcje;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;



/**
 * @ORM\Entity(repositoryClass="App\Repository\DawkaRepository")
 */
class Dawka
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
    private $ktora;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Schemat", inversedBy="dawki")
     * @ORM\JoinColumn(nullable=false)
     */
    private $schemat;

    /**
     * @ORM\Column(type="dateinterval", nullable=true)
     */
    private $wiekPodaniaMin;

    /**
     * @ORM\Column(type="dateinterval", nullable=true)
     */
    private $wiekPodaniaZglosOpoznienie;

    /**
     * @ORM\Column(type="dateinterval", nullable=true)
     */
    private $wiekPodaniaMax;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\KalendarzSzczepien", mappedBy="szczepieniaUtrwalone")
     */
    private $wKtorychKalendarzachJestem;

    /**
     * @ORM\Column(type="dateinterval")
     */
    private $odstep_min_interval;

    /**
     * @ORM\Column(type="dateinterval")
     */
    private $odstep_max_interval;
    
    public function __construct()
    {
        $this->wKtorychKalendarzachJestem = new ArrayCollection();
        $this->odstep_min_interval = new \DateInterval("P28D");
        $this->odstep_max_interval = new \DateInterval("P56D");
        $this->wiekPodaniaMin = new \DateInterval("P42D");
        $this->wiekPodaniaMax = new \DateInterval("P3Y");
    }

    public function getSkroconeCechyMojeImojejSzczepionki(): ?string
    {
        $sc_nazwa = $this->getNazwaSzczepionki();
        return sprintf('%s %d %s %s %s %d','dawka nr ',$this->ktora, ' szczepionki: ', $sc_nazwa, ' nr schem: ',$this->schemat->getId());
        //return sprintf('%d',$this->odstepMax);
    }
    
    public function getNazwaSzczepionki(): ?string
    {
        return $this->schemat->getPodawania()->getNazwa();
    }
    
    public function dajParametr($parametr)
    {
        switch($parametr)
        {
            case 'odst_min' :
            return $this->odstep_min_interval;
            case 'odst_max' :
            return $this->odstep_max_interval;
            case 'wiek_min' :
            return $this->wiekPodaniaMin;
            case 'wiek_max' :
            return $this->wiekPodaniaMax;
        }
        
    }
    
    public function getSzczepionka(): ?Szczepionka
    {
        return $this->schemat->getPodawania();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getKtora(): ?int
    {
        return $this->ktora;
    }

    public function setKtora(int $ktora): self
    {
        $this->ktora = $ktora;

        return $this;
    }

    /*
    public function getOdstepMin(): ?int
    {
        return $this->odstepMin;
    }

    public function setOdstepMin(int $odstepMin): self
    {
        $this->odstepMin = $odstepMin;

        return $this;
    }

    public function getOdstepMax(): ?int
    {
        return $this->odstepMax;
    }

    public function setOdstepMax(int $odstepMax): self
    {
        $this->odstepMax = $odstepMax;

        return $this;
    }
    */

    public function getSchemat(): ?Schemat
    {
        return $this->schemat;
    }

    public function setSchemat(?Schemat $schemat): self
    {
        $this->schemat = $schemat;

        return $this;
    }

    public function getWiekPodaniaMin(): ?\DateInterval
    {
        if($this->wiekPodaniaMin == null)return new \DateInterval('P11Y');
        return $this->wiekPodaniaMin;
    }

    public function setWiekPodaniaMin(?\DateInterval $wiekPodaniaMin): self
    {
        $this->wiekPodaniaMin = $wiekPodaniaMin;

        return $this;
    }

    public function getWiekPodaniaZglosOpoznienie(): ?\DateInterval
    {
        return $this->wiekPodaniaZglosOpoznienie;
    }

    public function setWiekPodaniaZglosOpoznienie(?\DateInterval $wiekPodaniaZglosOpoznienie): self
    {
        $this->wiekPodaniaZglosOpoznienie = $wiekPodaniaZglosOpoznienie;

        return $this;
    }

    public function getWiekPodaniaMax(): ?\DateInterval
    {
        if($this->wiekPodaniaMax == null)return new \DateInterval('P11Y');
        return $this->wiekPodaniaMax;
    }

    public function setWiekPodaniaMax(?\DateInterval $wiekPodaniaMax): self
    {
        $this->wiekPodaniaMax = $wiekPodaniaMax;

        return $this;
    }

    /**
     * @return Collection|KalendarzSzczepien[]
     */
    public function getWKtorychKalendarzachJestem(): Collection
    {
        return $this->wKtorychKalendarzachJestem;
    }

    public function addWKtorychKalendarzachJestem(KalendarzSzczepien $wKtorychKalendarzachJestem): self
    {
        if (!$this->wKtorychKalendarzachJestem->contains($wKtorychKalendarzachJestem)) {
            $this->wKtorychKalendarzachJestem[] = $wKtorychKalendarzachJestem;
            $wKtorychKalendarzachJestem->addSzczepieniaUtrwalone($this);
        }

        return $this;
    }

    public function removeWKtorychKalendarzachJestem(KalendarzSzczepien $wKtorychKalendarzachJestem): self
    {
        if ($this->wKtorychKalendarzachJestem->contains($wKtorychKalendarzachJestem)) {
            $this->wKtorychKalendarzachJestem->removeElement($wKtorychKalendarzachJestem);
            $wKtorychKalendarzachJestem->removeSzczepieniaUtrwalone($this);
        }

        return $this;
    }

    public function getOdstepMinInterval(): ?\DateInterval
    {
        if($this->odstep_min_interval == null)return new \DateInterval('P11Y');
        return $this->odstep_min_interval;
    }

    public function setOdstepMinInterval(\DateInterval $odstep_min_interval): self
    {
        $this->odstep_min_interval = $odstep_min_interval;

        return $this;
    }

    public function getOdstepMaxInterval(): ?\DateInterval
    {
        if($this->odstep_max_interval == null)return new \DateInterval('P11Y');
        return $this->odstep_max_interval;
    }

    public function setOdstepMaxInterval(\DateInterval $odstep_max_interval): self
    {
        $this->odstep_max_interval = $odstep_max_interval;

        return $this;
    }
    public function PrzeniesOdstepDoInterwalu()
    {
        $f = new Funkcje();
        
        
        if(($this->odstep_max_interval == '+P00Y00M00DT00H00M00S') && ($this->wiekPodaniaMax != null))
        {
            
            $this->setOdstepMaxInterval(new \DateInterval($f->MiesiaceNaDateInterwalString($this->wiekPodaniaMax)));
        }
        if(($this->odstep_min_interval == '+P00Y00M00DT00H00M00S') && ($this->wiekPodaniaMin != null))
        {
            $this->setOdstepMinInterval(new \DateInterval($f->MiesiaceNaDateInterwalString($this->wiekPodaniaMin)));
        }
    }
}
