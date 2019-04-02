<?php

namespace App\Entity;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class NumerPesel
{
    private $numer;
    private $logger;
    
    public function __construct()
    {
        $this->logger = new Logger('NumerPesel');
        $this->logger->pushHandler(new StreamHandler('/home/mateusz/symfonyProjekt/szczepienia/var/log/dev.log', Logger::WARNING));
        $this->logger->warning('konstruktor');
            
    }
    
    public function getNumer(): string
    {
        return $this->numer;
        $this->logger->warning('getNumer');
    }
    public function setNumer(String $pesel){
        $this->numer = $pesel;
        $this->logger->warning('setNumer');
    }
}