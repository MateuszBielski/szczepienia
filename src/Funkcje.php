<?php

namespace App;

class Funkcje
{
    function MiesiaceNaDateInterwalString(integer $ileWszystkichMiesiecy): string
    {
        $ileLat = floor($ileWszystkichMiesiecy/12);
        $ileMiesiecy = $ileWszystkichMiesiecy-12*$ileLa;
        $wynik = '+P'.strval($ileLat).'Y'.strval($ileMiesiecy).'M00DT00H00M00S';
        return $wynik;
    } 
}

