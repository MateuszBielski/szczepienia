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
     * @ORM\OneToMany(targetEntity="App\Entity\Dawka",cascade={"persist", "remove"}, mappedBy="schemat")
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
     * @ORM\OneToOne(targetEntity="App\Entity\Schemat", inversedBy="isSubstitutedBy"), cascade={"persist", "remove"}
     * @ORM\JoinColumn(nullable=true)
     */
    private $substitute;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Schemat", mappedBy="substitute"), cascade={"persist", "remove"}
     */
    private $isSubstitutedBy = null;

    private $prev, $next;

    public function __construct()
    {
        $this->warunek = new ArrayCollection();
        $this->dawki = new ArrayCollection();
        //poniższe utworzone na potrzeby SchematController::newFromCopy i ::new
        $yearNow = (new \DateTime('now'))->format('Y');
        $this->startYear = new \DateTime("$yearNow-01-01");
    }

    public function __toString()
    {
        return "schemat id ".$this->getId();
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
        //$this->substitute->setIsSubstitutedBy($this);
        $lastDayValid = clone $this->startYear;
        $lastDayValid = $lastDayValid->modify('-1 days');
        $this->substitute->setEndYear($lastDayValid);
    }
    public function setSubstitute(?self $substitute): self
    {
        $this->substitute = $substitute;
        /*
        if($substitute != null){
            $this->substitute = $substitute;
            $this->updateCorrectEndDateSubstituted();
        }
        else if($this->substitute != null){
            $this->substitute->setIsSubstitutedBy(null);
            $this->substitute->setEndYearToNull();
            $this->substitute = $substitute;
        }
        */
        return $this;
    }
    
    public function setIsSubstitutedBy(?self $isSubstitutedBy): self
    {
        $this->isSubstitutedBy = $isSubstitutedBy;
        
        // set (or unset) the owning side of the relation if necessary
        /*
        $newSubstitute = $isSubstitutedBy === null ? null : $this;

    
        if ($newSubstitute !== $isSubstitutedBy->getSubstitute()) {
            $isSubstitutedBy->setSubstitute($newSubstitute);
        }
        */
        
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
    public function setSubstToPrevNextAndResetToNull()
    {
        $this->prev = $this->substitute;
        $this->next = $this->isSubstitutedBy;
        $this->substitute = null;
        $this->isSubstitutedBy = null;
    }
    public function weldPrevWithNext()
    {
        $hasPrev = false;
        $hasNext = false;
        if ($this->prev != null) {
            $this->prev->setIsSubstitutedBy(null);
            $this->prev->setEndYearToNull();
            $hasPrev = true;
        }
        if ($this->next != null) {
            $this->next->setSubstitute(null);
            $hasNext = true;
        }
        
        if ($hasPrev && $hasNext) {
            $this->prev->setIsSubstitutedBy($this->next);
            $lastDayValid = clone $this->next->startYear;
            $lastDayValid = $lastDayValid->modify('-1 days');
            $this->prev->setEndYear($lastDayValid);

            $this->next->setSubstitute($this->prev);
        }
        
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
    public function ReplaceDosesFromMySubstituting($doses,$patient)
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
            $madeVaccinationsOfVaccine = $patient->getMadeVaccinationsOfVaccine($this->podawania);
            $numberOfPossibleDoses = $ss->PossibleNextDoses($patient,$buffer,$madeVaccinationsOfVaccine);
            if ($numberOfPossibleDoses) {
                foreach ($buffer as $nextDose) {
                    $doses[]  = $nextDose;
                }
                //usunąć z wykazu dawki przyszłe ze schematu this, ponieważ będą zastąpione.
                //w tablicy doses[] znaleźć indeksy dawek do usunięcia
                $dosesToReplace = $this->FindUnmadeDosesOfMe($doses, $madeVaccinationsOfVaccine);
                foreach($dosesToReplace as $dtr) {
                    unset($doses[$dtr]);
                }
                break;
            }
        }
        //return count($subsequentSupersession);
    }
    //previous name CheckAbilityApplyMyNextDoses
    public function PossibleNextDoses(Pacjent $pacjent, array $buffer, array $madeVacc)
    {
        //bierze dawki już wykonane szczepionki, której dotyczy ten schemat
        //są one zapewne z innego schematu, ale to nie jest ważne.
        //liczy je 
        $countMadeVaccines = count($madeVacc);
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
    public function FindUnmadeDosesOfMe(&$doses, array $madeVacc)
    {
        //doses muszą mieć numerowane indeksy, bo później część będzie usuwana
        $newDoses  = array();
        $j = 0;
        foreach($doses as $d) {
            $newDoses[$j++] = $d;
        }
        $doses = $newDoses;
        $indexes = array();
        $i = 0;
        $k = 0;
        //ze wszystkich szukamy tych, które należą do schematu this
        foreach($doses as $dose){
            if ($dose->getSchemat->getId() == $this->id) {
                $indexes[$k++] = $i;
            }
            $i++;
        }
        //tablica, gdzie kluczami są podane pacjentowi szczepienia tej szczepionki
        $madeVaccKeys = array();
        foreach($madeVacc as $vac) {
            $madeVaccKeys[$vac->getCoPodano()->getId()] = 'true';
        }
        $markToRemove = array();
        $l = 0;
        //oznaczyć indeksy, które odpowiadają za szczepienie już wykonane na danym pacjencie
        foreach($indexes as $ind) {
            $key = $doses[$ind]->getId();
            if ($madeVaccKeys[$key]) {
                $markToRemove[] = $l;
            }
            $l++;
        }
        foreach($markToRemove as $mtr) {
            unset($indexes[$mtr]);
        }
        return $indexes;
    }
}
