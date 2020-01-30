<?php
include_once '../DAL/bankDatabase.php';
include_once '../DAL/bankDatabaseStub.php';
class Bank
{
    private $db;
    function __construct($innDb=null)
    {
        if($innDb==null)
        {
            $this->db=new BankDB(); 
        }
        else
        {
            $this->db=$innDb;
        }
    }
    
    function hentTransaksjoner($kontoNr, $fraDato, $tilDato)
    {
        $konto= $this->db->hentTransaksjoner($kontoNr, $fraDato, $tilDato);
        return $konto;
    }
    
    function sjekkLoggInn($personnummer,$passord)
    {
        if(!preg_match("/[0-9]{11}/", $personnummer))
        {
            return "Feil i personnummer";
        }
        
        if(!preg_match("/.{6,30}/", $passord))
        {
            return "Feil i passord";
        }
        
        $OK = $this->db->sjekkLoggInn($personnummer,$passord);
        return $OK;
    }
    
    function hentKonti($personnummer)
    {
        $konti = $this->db->hentKonti($personnummer);
        return $konti;
    }
    
    function hentSaldi($personnummer)
    {
        $saldi = $this->db->hentSaldi($personnummer);
        return $saldi;
    }
    
    function registrerBetaling($kontoNr, $transaksjon)
    {
        $ok = $this->db->registrerBetaling($kontoNr, $transaksjon);
        return $ok;
    }
    
    function hentBetalinger($personnummer)
    {
        $betalinger = $this->db->hentBetalinger($personnummer);
        return $betalinger;
    }
    
    function utforBetaling($TxID)
    {
        $ok = $this->db->utforBetaling($TxID);
        return $ok;
    }
    
    function endreKundeInfo($kunde)
    {
        $OK= $this->db->endreKundeInfo($kunde);
        return $OK;
    }
    
    function hentKundeInfo($personnummer)
    {
        $kunde= $this->db->hentKundeInfo($personnummer);
        return $kunde;
    }
}