<?php

namespace App;



class Funkcje
{
    function MiesiaceNaDateInterwalString(integer $ileWszystkichMiesiecy): string
    {
        $ileLat = floor($ileWszystkichMiesiecy/12);
        $ileMiesiecy = $ileWszystkichMiesiecy-12*$ileLat;
        $wynik = '+P'.strval($ileLat).'Y'.strval($ileMiesiecy).'M00DT00H00M00S';
        return $wynik;
    }
    function MiesiaceDateInterwalNaInt(\DateInterval $interwal): int 
    {
        $ileLat = intval($interwal->format('%y'));
        $ileMiesiecy = intval($interwal->format('%m'));
        
        return 12*$ileLat+$ileMiesiecy;
    }
    
    function DateIntervalNaLataTygodnie(\DateInterval $interwal): string
    {
        /*$ileDni = $interwal->format('%a');
        if($ileDni != 'unknown'){
            $ileDni = intval($ileDni);
            $ileLat = $ileDni/365
        }
        */
        $ileLat = $interwal->format('%y');
        $ileTygodni = intval($interwal->format('%m'))*4;
        $ileDni = intval($interwal->format('%d'));
        if($ileDni >= 7){
            $dodatkoweTygodnie = floor($ileDni/7);
            $pozostaloDni = $ileDni - $dodatkoweTygodnie*7;
            $ileDni = $pozostaloDni;
            $ileTygodni += $dodatkoweTygodnie;
        }
        $wynik = '';
        if(intval($ileLat)) $wynik .= $ileLat.' lat ';
        if($ileTygodni) $wynik .= $ileTygodni.' tygodni ';
        if($ileDni) $wynik .= $ileDni.' dni';
        return $wynik;
    }
}

