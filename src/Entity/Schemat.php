<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SchematRepository")
 */
class Schemat
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Warunek", mappedBy="schemat")
     */
    private $warunek;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Dawka",cascade="persist", mappedBy="schemat", orphanRemoval=true)
     */
    private $dawki;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Szczepionka", inversedBy="schematy")
     * @ORM\JoinColumn(nullable=false)
     */
    private $podawania;

    /**
     * @ORM\Column(type="date")
     */
    private $startYear;

    /**
     * @ORM\Column(type="date")
     * @ORM\JoinColumn(nullable=true)
     */
    private $endYear;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Schemat", inversedBy="isSubstitutedBy", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $substitute;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Schemat", mappedBy="substitute", cascade={"persist", "remove"})
     */
    private $isSubstitutedBy = null;

    public function __construct()
    {
        $this->warunek = new ArrayCollection();
        $this->dawki = new ArrayCollection();
        //poniższe utworzone na potrzeby SchematController::newFromCopy i ::new
        $yearNow = (new \DateTime('now'))->format('Y');
        $this->startYear = new \DateTime("$yearNow-01-01");
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    /**
     * @return Collection|Warunek[]
     */
    public function getWarunek(): Collection
    {
        return $this->warunek;
    }

    public function addWarunek(Warunek $warunek): self
    {
        if (!$this->warunek->contains($warunek)) {
            $this->warunek[] = $warunek;
            $warunek->setSchemat($this);
        }

        return $this;
    }

    public function removeWarunek(Warunek $warunek): self
    {
        if ($this->warunek->contains($warunek)) {
            $this->warunek->removeElement($warunek);
            // set the owning side to null (unless already changed)
            if ($warunek->getSchemat() === $this) {
                $warunek->setSchemat(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Dawka[]
     */
    public function getDawki(): Collection
    {
        return $this->dawki;
    }

    public function addDawki(Dawka $dawki): self
    {
        if (!$this->dawki->contains($dawki)) {
            $this->dawki[] = $dawki;
            $dawki->setSchemat($this);
        }

        return $this;
    }

    public function removeDawki(Dawka $dawki): self
    {
        if ($this->dawki->contains($dawki)) {
            $this->dawki->removeElement($dawki);
            // set the owning side to null (unless already changed)
            if ($dawki->getSchemat() === $this) {
                $dawki->setSchemat(null);
            }
        }

        return $this;
    }

    public function getPodawania(): ?Szczepionka
    {
        return $this->podawania;
    }

    public function setPodawania(?Szczepionka $podawania): self
    {
        $this->podawania = $podawania;

        return $this;
    }
    public function DlaMoichDawekUstawMnieIponumeruj()
    {
        $numer = 1;
        foreach($this->dawki->getIterator() as $i => $dawka)
        {
            $dawka->setKtora($numer++);
            $dawka->setSchemat($this);
        }
    }
    public function DolaczMojeDawkiDo(ArrayCollection $tworzonyZbior)
    {
        foreach($this->dawki as $dawka) $tworzonyZbior[] = $dawka; 
    }
    public function ObowiazujeDla(Pacjent $pacjent)
    {
        $dateOfBirth = $pacjent->DataUrodzeniaDateObject();
        if( $this->startYear > $dateOfBirth) return false;
        if( $this->endYear == null) return true;
        if ($dateOfBirth < $this->endYear) return true;
        return false;
    }

    public function getStartYear(): ?\DateTimeInterface
    {
        return $this->startYear;
    }

    public function setStartYear(\DateTimeInterface $startYear): self
    {
        $this->startYear = $startYear;

        return $this;
    }

    public function getEndYear(): ?\DateTimeInterface
    {
        return $this->endYear;
    }

    public function setEndYear(\DateTimeInterface $endYear): self
    {
        $this->endYear = $endYear;

        return $this;
    }
    public function setEndYearToNull()
    {
        $this->endYear = null;
    }
    public function getSubstitute(): ?self
    {
        return $this->substitute;
    }
    public function updateCorrectEndDateSubstituted()
    {
        if($this->substitute == null)return;
        $this->substitute->setIsSubstitutedBy($this);
        $lastDayValid = clone $this->startYear;
        $lastDayValid = $lastDayValid->modify('-1 days');
        $this->substitute->setEndYear($lastDayValid);
    }
    public function setSubstitute(?self $substitute): self
    {
        
        if($substitute != null){
            $this->substitute = $substitute;
            $this->updateCorrectEndDateSubstituted();
        }
        else if($this->substitute != null){
            $this->substitute->setIsSubstitutedBy(null);
            $this->substitute->setEndYearToNull();
            $this->substitute = $substitute;
        }
        
        return $this;
    }
    public function IsSubstituted()
    {
        $wynik = $this->isSubstitutedBy ? true : false ;
        return $wynik;
    }

    public function getIsSubstitutedBy(): ?self
    {
        return $this->isSubstitutedBy;
    }

    public function setIsSubstitutedBy(?self $isSubstitutedBy): self
    {
        $this->isSubstitutedBy = $isSubstitutedBy;

        // set (or unset) the owning side of the relation if necessary
        /*
        $newSubstitute = $IsSubstitutedBy === null ? null : $this;
        if ($newSubstitute !== $IsSubstitutedBy->getSubstitute()) {
            $IsSubstitutedBy->setSubstitute($newSubstitute);
        }
        */
        return $this;
    }
    public function getVaccineNameAndStartYear(): string
    {
        return $this->podawania->getNazwa().' '.$this->startYear->format('Y');
    }
    public function copyDosesAndVaccineFrom(?self $schemat)
    {
        foreach($schemat->getDawki() as $dose)
        {
            $newDose = new Dawka;
            $newDose->copyFrom($dose);
            $newDose->setSchemat($this);
            $this->dawki[] = $newDose;
        }
        $this->podawania = $schemat->getPodawania();
    }
    //nazwa powinna się zmienić na CompleteDosesFromMySubstituting($wszystkieObowiazujaceDawki);
    public function CompleteDosesFromMySubstituting($doses,$patient)
    {
        $haveNext = true;//($this->isSubstitutedBy != null) ? true : false;
        $subsequentSupersession = Array();
        $currentSchema = $this;
        while($haveNext){
            $nextSupersession = $currentSchema->getIsSubstitutedBy();
            if($nextSupersession == null){
                $haveNext = false;
                break;
            }
            $subsequentSupersession[] =$nextSupersession; 
            $currentSchema = $nextSupersession;
        }
        $newestPossibile = null;
        foreach(array_reverse($subsequentSupersession) as $ss)
        {
            //checking from last 
            $buffer = array();
            $numberOfPossibleDoses = $ss->PossibleNextDoses($patient,$buffer);
            if ($numberOfPossibleDoses) {
                foreach ($buffer as $nextDose) {
                    $doses[]  = $nextDose;
                }
                break;
            }
        }
        //return count($subsequentSupersession);
    }
    //previous name CheckAbilityApplyMyNextDoses
    public function PossibleNextDoses(Pacjent $pacjent, array $buffer)
    {
        //bierze dawki już wykonane szczepionki, której dotyczy ten schemat
        //są one zapewne z innego schematu, ale to nie jest ważne.
        //liczy je 
        $countMadeVaccines = count($pacjent->getMadeVaccinationsOfVaccine($this->podawania));
        //z tego schematu wskazuje dawkę, która mogłaby być kolejną dla danego pacjenta
        $numberMyVaccines = count($this->dawki);
        if ($countMadeVaccines >= $numberMyVaccines) return;
        $nextDose = $this->dawki[$countMadeVaccines];
        if (!$nextDose->ifServeMeIsInAgeFor($pacjent)) return 0;
        $i = $countMadeVaccines;
        while($i < $numberMyVaccines -1) {
            $buffer[] = $this->dawki[$i++];
        }
        //można dodać warunek sprawdzający ze względu na maxymalny odstęp
    }
}
