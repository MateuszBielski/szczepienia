<?php

namespace App\Entity;

use App\Entity\Osoba;
use App\Entity\NumerPesel;
use App\Funkcje;
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
    /**
     * @ORM\Column(type="string", length=11)
     * @SprawdzeniePeselu\Pesel
     */
    private $pesel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Szczepienie", mappedBy="pacjent", orphanRemoval=true)
     * @ORM\OrderBy({"dataZabiegu" = "DESC"})
     */
    private $szczepienia;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\KalendarzSzczepien", mappedBy="pacjent", cascade={"persist", "remove"})
     */
    private $kalendarzSzczepien;

    public function __construct()
    {
        //$logger = new Logger('Mateusz');
        //$logger->pushHandler(new StreamHandler('/home/mateusz/symfonyProjekt/szczepienia/var/log/dev.log', Logger::WARNING));
        //$logger->warning('konstruktor');
        $this->szczepienia = new ArrayCollection();
        $this->UtworzKalendarzDlaMnie();
    }

    public function getPesel(): ?string
    {
        //return $this->peselObiekt->getNumer();//mówi że pusty
        return $this->pesel;
    }

    public function setPesel(string $pesel): self
    {
        //$logger = new Logger('Mateusz');
        //$logger->pushHandler(new StreamHandler('/home/mateusz/symfonyProjekt/szczepienia/var/log/dev.log', Logger::WARNING));
        //$logger->warning('setPesel');
        
        $this->pesel = $pesel;
        
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
        if(null === $this->pesel)return '';
        $peselObiekt = new NumerPesel($this->pesel);
        $peselObiekt->ObliczRokDzienMiesiac();
        $rok = $peselObiekt->Rok();
        $miesiac = $peselObiekt->Miesiac();
        $dzien = $peselObiekt->Dzien();
        return sprintf('%d %s %d',$dzien,$miesiac,$rok);
    }

    public function getKalendarzSzczepien(): ?KalendarzSzczepien
    {
        return $this->kalendarzSzczepien;
    }

    public function setKalendarzSzczepien(KalendarzSzczepien $kalendarzSzczepien): self
    {
        $this->kalendarzSzczepien = $kalendarzSzczepien;

        // set the owning side of the relation if necessary
        if ($this !== $kalendarzSzczepien->getPacjent()) {
            $kalendarzSzczepien->setPacjent($this);
        }

        return $this;
    }
    
    public function CzyNieMamKalendarza()
    {
        $wynik = (null === $this->kalendarzSzczepien) ? true:false;
        return $wynik;
    }
    public function UtworzKalendarzDlaMnie()
    {
        $this->kalendarzSzczepien = new KalendarzSzczepien();
        $this->kalendarzSzczepien->setPacjent($this);
    }
    //przy każdej edycji shematu (dodaniu i usunięciu) należy wywołać dla każdego pacjenta poniższą funkcję
    public function UaktualnijKalendarz(Array $wszystkieSzczepionki){
        
        if($this->CzyNieMamKalendarza())$this->UtworzKalendarzDlaMnie();
        //$schematyObowiazujace = [];
        //$licznik = 0;
        $wszystkieObowiazujaceDawki = new ArrayCollection();
        foreach($wszystkieSzczepionki as $szczepionka){
            $schemat = $szczepionka->KtorySchematDlaPacjenta($this);
            if($schemat == null)continue;
            $dawkiSchmatu = $schemat->getDawki();
            foreach($dawkiSchmatu as $dawka){
                $wszystkieObowiazujaceDawki[] = $dawka;
            }
            //$schematyObowiazujace[] = 
            //$licznik++;
            //echo $licznik;
        }
        //zastosowanie poniższego sortowania nie wpływa na kolejność dodania do bazy
        /*
        $f = new Funkcje();
        $iterator = $wszystkieObowiazujaceDawki->getIterator();
            $iterator->uasort(function ($a, $b) use ($f){
                //$aInt = $f->MiesiaceDateInterwalNaInt($a->getOdstepMinInterval());
                //$bInt = $f->MiesiaceDateInterwalNaInt($b->getOdstepMinInterval());;
                $aInt = $a->getId();
                $bInt= $b->getId();
                return ($aInt > $bInt) ? -1 : 1;
            });
            //$collection = new ArrayCollection(iterator_to_array($iterator));
        
        $this->kalendarzSzczepien->setSzczepieniaUtrwalone(new ArrayCollection(iterator_to_array($iterator)));
         
        */
        $this->kalendarzSzczepien->setSzczepieniaUtrwalone($wszystkieObowiazujaceDawki);
    }
}