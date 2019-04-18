<?php

namespace App\Entity;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use App\Entity\NazwyDaty;

class NumerPesel
{
    private $numer;
    //private $logger;
    private $rok_raw, $miesiac_raw, $dzien_raw;
    private $rok_gotowy, $miesiac_gotowy, $dzien_gotowy;
    
    public function __construct(String $numer)
    {
        //$this->logger = new Logger('NumerPesel');
        //$this->logger->pushHandler(new StreamHandler('/home/mateusz/symfonyProjekt/szczepienia/var/log/dev.log', Logger::WARNING));
        //$this->logger->warning('konstruktor');
        $this->numer = $numer;
        $this->UstawSurowWartosci();
        
    }
   
    public function getNumer(): string
    {
        return $this->numer;
        //$this->logger->warning('getNumer');
    }
    public function setNumer(String $pesel){
        $this->numer = $pesel;
        //$this->logger->warning('setNumer');
    }
    private function UstawSurowWartosci()
    {
        $this->rok_raw = substr ( $this->numer, 0, 2 );
        $this->miesiac_raw = substr ( $this->numer, 2, 2 );
        $this->dzien_raw = substr ( $this->numer, 4, 2 );
    }
     public function ObliczRokDzienMiesiac()
    {
        //czy urodzony po roku 1999
        $miesiacLiczba = intval($this->miesiac_raw);
        $czyPo1999 = ($miesiacLiczba > 20) ? true : false;
        $stulecie = $czyPo1999 ? '20' : '19';
        $this->rok_gotowy =  $stulecie.$this->rok_raw;
        $miesiacLiczba = $czyPo1999 ? $miesiacLiczba-20:$miesiacLiczba;
        $nazwyGenerator = new NazwyDaty();
        $this->miesiac_gotowy = $nazwyGenerator->Miesiac($miesiacLiczba-1);
        //if(preg_match('/0\d/',$this->dzien_raw))
        $this->dzien_gotowy = ltrim($this->dzien_raw, "0");
    }
        public function Rok(): string
    {
        return $this->rok_gotowy;
    }
    public function Miesiac(): string
    {
        return $this->miesiac_gotowy;
    }
    public function Dzien(): string
    {
        return $this->dzien_gotowy;
    }
    
}