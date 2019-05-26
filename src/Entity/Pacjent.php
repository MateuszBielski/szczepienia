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
    
    private $szczepieniaPogrupowane;
    
    private $dataUrodzenia;
    
    private $funkcje;

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
    //przy każdej edycji schematu (dodaniu i usunięciu) należy wywołać dla każdego pacjenta poniższą funkcję
    public function UaktualnijKalendarzStare(Array $wszystkieSzczepionki){
        
        if($this->CzyNieMamKalendarza())$this->UtworzKalendarzDlaMnie();
        $wszystkieObowiazujaceDawki = new ArrayCollection();
        foreach($wszystkieSzczepionki as $szczepionka){
            $schemat = $szczepionka->KtorySchematDlaPacjenta($this);
            if($schemat == null)continue;
            $dawkiSchmatu = $schemat->getDawki();
            foreach($dawkiSchmatu as $dawka){
                $wszystkieObowiazujaceDawki[] = $dawka;
            }
        }
        
        $this->kalendarzSzczepien->setSzczepieniaUtrwalone($wszystkieObowiazujaceDawki);
    }
    public function UaktualnijKalendarz(Array $wszystkieSchematy)
    {
        if($this->CzyNieMamKalendarza())$this->UtworzKalendarzDlaMnie();
        $wszystkieObowiazujaceDawki = new ArrayCollection();
        $schemasMatching = array();
        $schemasNotMatching = array();
        foreach($wszystkieSchematy as $schemat)
        {
            if($schemat->ObowiazujeDla($this)){
                $schemat->DolaczMojeDawkiDo($wszystkieObowiazujaceDawki);
                $schemasMatching[] = $schemat;
            }
            else{
                //$schemat->DolaczMojeDawkiDo
                //niepasujące schematy wrzucić do drugiej grupy i w oddzielnej pętli sprawdzić, czy są jakieś dawki które można jeszcze zastosować
                $schemasNotMatching[] = $schemat;
                //jeśli jakieś jeszcze dawki można zastosować 
            } 
              
        }
        foreach($schemasMatching as $schMatch)
        {
            $schMatch->CompleteDosesFromMySubstituting($wszystkieObowiazujaceDawki,$this);
        }
        $this->kalendarzSzczepien->setSzczepieniaUtrwalone($wszystkieObowiazujaceDawki);
    }
    public function WiekPodaniaSzczepienia(Szczepienie $szczepienie): string
    {
        return $szczepienie->getDataZabiegu()->diff($this->dataUrodzenia)->format('%y lat %m miesięcy %d dni');
    }
    public function DataUrodzeniaDateObject()
    {
        if($this->dataUrodzenia == null)$this->dataUrodzenia = (new NumerPesel($this->pesel))->DateObject();
        return $this->dataUrodzenia;
    }
    
    public function Inicjuj()
    {
        $this->dataUrodzenia = $this->DataUrodzeniaDateObject();
        $this->funkcje = new Funkcje();
    }
    
    public function PogrupujSzczepienia()
    {
        $grupowanie = array();
        $wKtorymSchemacie = array();
        $ktoraWdanymSchemacie = array();
        $mojaNumeracja = array();
        $ktore  = count($this->szczepienia)-1;
        foreach(array_reverse($this->szczepienia->toArray()) as $szczepienie)
        {
            $schematId = $szczepienie->getCoPodano()->getSchemat()->getId();
            $wKtorymSchemacie[$ktore] = $schematId;
            $mojaNumeracja[$szczepienie->getId()] = $ktore;
            $grupowanie[$schematId][] = $ktore;
            $ktoraWdanymSchemacie[$ktore] = count($grupowanie[$schematId])-1;
            $ktore--;
        }
       $this->szczepieniaPogrupowane = [
        'grupowanie' => $grupowanie,
        'wKtorymSchemacie' => $wKtorymSchemacie,
        'ktoraWdanymSchemacie' => $ktoraWdanymSchemacie,
        'mojaNumeracja' => $mojaNumeracja,
       ];
    }
    public function SprawdzenieGrupowania(Szczepienie $szczepienie)
    {
       $ktore = $this->szczepieniaPogrupowane['mojaNumeracja'][$szczepienie->getId()];
       $wKtorymSchemacie = $this->szczepieniaPogrupowane['wKtorymSchemacie'][$ktore];
       $ktoraWdanymSchemacie = $this->szczepieniaPogrupowane['ktoraWdanymSchemacie'][$ktore];
       if($ktoraWdanymSchemacie == 0)return 0;
       $numerSzukanegoSzczepienia = $this->szczepieniaPogrupowane['grupowanie'][$wKtorymSchemacie][$ktoraWdanymSchemacie-1];
       //$ileSchematow = count($this->szczepieniaPogrupowane['grupowanie']); //liczba schematów ok
        return $numerSzukanegoSzczepienia; 
    }
    public function PoprzedniaDawka(Szczepienie $szczepienie)
    {
        $ktore = $this->szczepieniaPogrupowane['mojaNumeracja'][$szczepienie->getId()];
        $wKtorymSchemacie = $this->szczepieniaPogrupowane['wKtorymSchemacie'][$ktore];
        $ktoraWdanymSchemacie = $this->szczepieniaPogrupowane['ktoraWdanymSchemacie'][$ktore];
        if($ktoraWdanymSchemacie == 0)return $szczepienie;
        $numerSzukanegoSzczepienia = $this->szczepieniaPogrupowane['grupowanie'][$wKtorymSchemacie][$ktoraWdanymSchemacie -1];
        return $this->szczepienia[$numerSzukanegoSzczepienia];
    }
    public function OdstepOdPoprzedniejDawki(Szczepienie $biezace): string
    {
        $poprzednie = $this->PoprzedniaDawka($biezace);
        $odstMin = $biezace->getCoPodano()->getOdstepMinInterval();
        $odstMax = $biezace->getCoPodano()->getOdstepMaxInterval();
        $dataMinOdst = clone $poprzednie->getDataZabiegu();
        $dataMinOdst = $dataMinOdst->add($odstMin);
        $dataMaxOdst = clone $poprzednie->getDataZabiegu();
        $dataMaxOdst = $dataMaxOdst->add($odstMax);
        
        $odstep = $biezace->getDataZabiegu()->diff($poprzednie->getDataZabiegu());
        
        $wynik = $odstep->format('%y lat %m miesięcy %d dni (%a dni)');
        
        if($biezace->getDataZabiegu() < $dataMinOdst){
            $zaKrotki = $dataMinOdst->diff($biezace->getDataZabiegu());
            $zaKrotki = $this->funkcje->DateIntervalNaLataTygodnie($zaKrotki);
            $wynik .= ' za krótki o '.$zaKrotki;
        }
        else if($biezace->getDataZabiegu() > $dataMaxOdst){
            $zaDlugi = $biezace->getDataZabiegu()->diff($dataMaxOdst);
            $zaDlugi = $this->funkcje->DateIntervalNaLataTygodnie($zaDlugi);
            $wynik .= ' za długi o '.$zaDlugi;
        }
        else {
            $wynik .= ' odpowieni';
        }
        return $wynik;
    }
    
    //przenieść do szczepienia
    public function WiekPorownanieDoWymaganych(Szczepienie $biezace): string
    {
        $wiekMin = $biezace->getCoPodano()->getWiekPodaniaMin();
        $wiekMax = $biezace->getCoPodano()->getWiekPodaniaMax();
        $dataMinWieku = clone $this->dataUrodzenia;
        $dataMinWieku->add($wiekMin);
        $dataMaxWieku =  clone $this->dataUrodzenia;
        $dataMaxWieku->add($wiekMax);
        $wynik = 'odpowiedni';
         
        if($biezace->getDataZabiegu() > $dataMaxWieku){
            $zaPozno = $biezace->getDataZabiegu()->diff($dataMaxWieku)->format('%y lat %m miesięcy %d dni');
            $wynik = 'podano za późno o '.$zaPozno;//
        }
        if($biezace->getDataZabiegu() < $dataMinWieku){
            $zaWczesnie = $dataMinWieku->diff($biezace->getDataZabiegu())->format('%y lat %m miesięcy %d dni');
            $wynik = 'za wcześnie o'.$zaWczesnie;//
        }
        return $wynik;
    }
    public function getMadeVaccinationsOfVaccine(Szczepionka $vaccine): ?Array
    {
        $result = array();
        foreach($this->szczepienia as $vacc)
        {
            if($vacc->getCoPodano()->getSchemat()->getPodawania() === $vaccine)
            $result[] = $vacc;
        }
        return $result;
    }
}