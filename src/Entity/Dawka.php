<?php

namespace App\Entity;

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
     * @ORM\Column(type="integer")
     */
    private $odstepMin;

    /**
     * @ORM\Column(type="integer")
     */
    private $odstepMax;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Schemat", inversedBy="dawki")
     * @ORM\JoinColumn(nullable=false)
     */
    private $schemat;
    
    /*
    public function __construct(Schemat $schemat)
    {
        $this->schemat = $schemat;
    }*/

    public function getSkroconeCechyMojeImojejSzczepionki(): ?string
    {
        $sc_nazwa = $this->schemat->getPodawania()->getNazwa();
        //return sprintf('%s %d %s %s','dawka nr ',$this->ktora, ' szczepionki: ', $sc_nazwa);
        return sprintf('%d',$this->odstepMax);
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
