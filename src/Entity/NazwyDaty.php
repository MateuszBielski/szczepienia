<?php

namespace App\Entity;

class NazwyDaty
{
    private $miesiac;
    public function __construct()
    {
        $this->miesiac = array (
            'styczeń',
            'luty',
            'marzec',
            'kwiecień',
            'maj',
            'czerwiec',
            'lipiec',
            'sierpień',
            'wrzesień',
            'październik',
            'listopad',
            'grudzień',
            'inny miesiąc'
        );
    }
    public function Miesiac(int $ktory): string
    {
        if(0 > $ktory || $ktory > 11 )$ktory = 12;
        return $this->miesiac[$ktory];
    }
}