<?php
include_once '../Model/domeneModell.php';
class AdminDBStub
{
    
function hentAlleKunder()
        {
           $alleKunder = array();
           $kunde1 = new kunde();
           $kunde1->personnummer ="12345678901";
           $kunde1->fornavn = "Per";
           $kunde1->etternavn = "Olsen";
           
           $alleKunder[]=$kunde1;
           $kunde2 = new kunde();
           $kunde2->personnummer ="01010110523";
           $kunde2->fornavn = "Lene";
           $kunde2->etternavn = "Jensen";
           
           $alleKunder[]=$kunde2;
           
           return $alleKunder;
        }
        
        function registrerKunde($kunde)
    {
        if($kunde->personnummer=="12345678901")
        {
            return "OK";
        }
        return "Feil";
    }
    function endreKundeInfo($kunde)
    {
        if($kunde->personnummer=="12345678901")
        {
            
            return "OK";
        }
        return "Feil";
    }
    function slettKunde($personnummer)
    {
        if($personnummer->personnummer=="12345678901")
        {
            
            return "OK";
        }
        return "Feil";
    }
    
    function registerKonto($konto)
    {
        if($konto->personnummer=="12345678901")
        {
            
            return "OK";
        }
        return "Feil";
    }
    
    function endreKonto($konto)
    {
        if($konto->personnummer=="12345678901")
        {
            if($konto->kontonummer == "11221122"){
                return "OK";
            }
            else{
                return "Feil i kontonummer";
            }
        }
        else{
            return "Feil i personnummer";
        }
    }
    
    function hentAlleKonti()
    {
        $alleKonti = array();
           $kunde1 = new konto();
           $kunde1->kontonummer ="01010110523";

           $alleKonti[]=$kunde1;
           
           $kunde2 = new konto();
           $kunde2->kontonummer ="12345678901";
           
           $alleKonti[]=$kunde2;
           
           return $alleKonti;
    }
    
    function slettKonto($kontonummer){
        if($kontonummer != "11221122"){
            return "Feil i kontonummer";
        }
        else{
            return "OK";
        }
    }
    
        
}