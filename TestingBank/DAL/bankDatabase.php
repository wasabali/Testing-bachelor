<?php
include_once '../Model/domeneModell.php';
class BankDB
{
    private $db;
    function __construct()
    {
        $this->db=new mysqli("localhost","root","","bank");
        $this->db->set_charset("utf8");
    }
    
    function hentTransaksjoner($kontonr,$fraDato,$tilDato)
    {
        if($fraDato=="")
        {
            $fraDato="2000-01-01";
        }
        if($tilDato=="")
        {
            $tilDato="2100-01-01";
        }
        $konto = new konto();
        $sql = "Select * from Konto Where Kontonummer = '$kontonr'";
        $resultat = $this->db->query($sql);
        $rad = $resultat->fetch_object();
        $konto->kontonummer = $kontonr;
        $konto->personnummer = $rad->Personnummer;
        $konto->saldo = $rad->Saldo;
        $konto->type = $rad->Type;
        $konto->valuta = $rad->Valuta;
        
        $sql = "SELECT DISTINCT FraTilKontonummer,Belop,Dato,Melding "
                . "FROM Konto, Transaksjon "
                . "WHERE Transaksjon.Kontonummer = '$kontonr' "
                . "AND Transaksjon.Dato >= '$fraDato' "
                . "AND Transaksjon.Dato <= '$tilDato' "
                . "AND Transaksjon.Avventer != 1";
        
        $resultat = $this->db->query($sql);
        $transaksjoner = array();
        while($rad = $resultat->fetch_object())
        {
            $tx = new transaksjon();
            $tx->fraTilKontonummer = $rad->FraTilKontonummer;
            $tx->dato = $rad->Dato;
            $tx->melding=$rad->Melding;
            $tx->transaksjonBelop = $rad->Belop;
            $transaksjoner[]=$tx;
        }
        $konto->transaksjoner=$transaksjoner;
        return $konto;
    }
    function sjekkLoggInn($personnummer,$passord)
    {
        $sql = "Select * from Kunde Where personnummer = '$personnummer' AND "
                . "passord = '$passord'";
        $resultat = $this->db->query($sql);
        $rad = $resultat->fetch_object();
        if($rad==!null)
        {
            return "OK";
        }
        else
        {
            return "Feil";
        }    
    }
    function hentKonti($personnummer)
    {
        $sql = "Select Distinct Kontonummer from Konto Where Personnummer ='$personnummer'";
        $resultat = $this->db->query($sql);
        $konti = array();
        while($rad = $resultat->fetch_object())
        {
            $konti[]=$rad;
        }
        return $konti;
    }
    
    function hentSaldi($personnummer)
    {
        $sql = "Select Distinct * from Konto Where Personnummer ='$personnummer'";
        $resultat = $this->db->query($sql);
        $saldi = array();
        while($rad = $resultat->fetch_object())
        {
            $saldi[]=$rad;
        }
        return $saldi;
    }
    
    function registrerBetaling($kontoNr, $transaksjon)
    {
        $sql = "Insert into Transaksjon (FraTilKontonummer,Belop,Dato,Melding,Kontonummer,Avventer)";
        $sql .= "Values ('$transaksjon->fraTilKontonummer','$transaksjon->belop','$transaksjon->dato','$transaksjon->melding','$kontoNr','1')";
        $resultat = $this->db->query($sql);
        if($this->db->affected_rows==1)
        {
            return "OK";
        }
        else
        {
            return "Feil";
        }
    }
    
    function hentBetalinger($personnummer)
    {
        // hent alle betalinger for kontonummer som avventer betaling (lik 1)
        $sql = "Select * from Transaksjon Join Konto On "
                . "Transaksjon.Kontonummer = Konto.Kontonummer Where "
                . "Personnummer='$personnummer'"
                . "AND Avventer='1' Order By Transaksjon.Kontonummer";
        $resultat = $this->db->query($sql);
        $betalinger = array();
        while($rad = $resultat->fetch_object())
        {
            $betalinger[]=$rad;
        }
        return $betalinger;
    }
    
    function utforBetaling($TxID)
    {
        $this->db->autocommit(false);
        $feil = false;
        // hent Belop og Kontonummer fra Transaksjonenen
        $sql = "Select Belop, Kontonummer from Transaksjon where TxID ='".$TxID."'";
        $resultat = $this->db->query($sql);
        if($this->db->affected_rows!=1)
        {
            $feil = true;
        }
        $rad = $resultat->fetch_object();
        $belop = $rad->Belop;
        $kontonummer = $rad->Kontonummer;
            
        // hent Saldo fra Konto
        $sql = "Select Saldo from Konto where kontonummer ='".$kontonummer."'";
        $resultat = $this->db->query($sql);
        if($this->db->affected_rows!=1)
        {
            $feil = true;
        }
        $rad = $resultat->fetch_object();
        $gammelSaldo = $rad->Saldo;
        $nySaldo = $gammelSaldo - $belop;
        
        if(!$feil)
        {
            // sett "Avventer" på TXiD til 0
            $sql = "Update Transaksjon Set Avventer = '0' Where TxID = '$TxID'";
            $resultat = $this->db->query($sql);
            if($this->db->affected_rows==1)
            {
                // oppdater Saldo på Konto
                $sql = "Update Konto Set Saldo = ".$nySaldo." Where kontonummer = '$kontonummer'";
                $resultat = $this->db->query($sql);
                if($this->db->affected_rows==1)
                {
                    $this->db->commit();
                    return "OK";
                }
            }
        }
        $this->db->rollback();
        return "Feil";
    }
    function endreKundeInfo($kunde)
    {
        $this->db->autocommit(false);
        // Sjekk om nytt postnr ligger i Poststeds-tabellen, dersom ikke legg det inn
        $sql = "Select * from Poststed Where Postnr = '$kunde->postnr'";
        $resultat = $this->db->query($sql);
        if($this->db->affected_rows!=1)
        {
            // ligger ikke i poststedstabellen 
            $sql = "Insert Into Poststed (Postnr, Poststed) Values ('$kunde->postnr','$kunde->poststed')";
            $resultat = $this->db->query($sql);
            if($this->db->affected_rows < 1)
            {
                $this->db->rollback();
                return "Feil";
            }
        }
        // oppdater Kunde-tabellen
        $sql =  "Update Kunde Set Fornavn = '$kunde->fornavn', Etternavn = '$kunde->etternavn',";
        $sql .= " Adresse = '$kunde->adresse', Postnr = '$kunde->postnr',";
        $sql .= " Telefonnr = '$kunde->telefonnr', Passord ='$kunde->passord'";
        $sql .= " Where Personnummer = '$kunde->personnummer'";
        $resultat = $this->db->query($sql);
        $this->db->commit();
        return "OK";
    }
    
    function registrerKunde($kunde)
    {
        $this->db->autocommit(false);
        // Sjekk om nytt postnr ligger i Poststeds-tabellen, dersom ikke legg det inn
        $sql = "Select * from Poststed Where Postnr = '$kunde->postnr'";
        $resultat = $this->db->query($sql);
        if($this->db->affected_rows!=1)
        {
            // ligger ikke i poststedstabellen 
            $sql = "Insert Into Poststed (Postnr, Poststed) Values ('$kunde->postnr','$kunde->poststed')";
            $resultat = $this->db->query($sql);
            if($this->db->affected_rows < 1)
            {
                $this->db->rollback();
                return "Feil";
            }
        }
        
        $sql = "Insert into Kunde (Personnummer,Fornavn,Etternavn,Adresse,Postnr,Telefonnr,Passord)";
        $sql .= "Values ('$kunde->personnummer','$kunde->fornavn','$kunde->etternavn',"
                . "'$kunde->adresse','$kunde->postnr','$kunde->telefonnr','$kunde->passord')";
        $resultat = $this->db->query($sql);
        if($this->db->affected_rows==1)
        {
            $this->db->commit();
            return "OK";
        }
        else
        {
            $this->db->rollback();
            return "Feil";
        }
    }
    
    function slettKunde($personnummer)
    {
        $sql = "Delete From Kunde Where Personnummer = '$personnummer'";
        $resultat = $this->db->query($sql);
        if($this->db->affected_rows==1)
        {
            return "OK";
        }
        else
        {
            return "Feil";
        }    
    }
    
    function hentKundeInfo($personnummer)
    {
        $kunde = new kunde();
        $sql = "Select * from Kunde Where Personnummer = '$personnummer'";
        $resultat = $this->db->query($sql);
        if($this->db->affected_rows!=1)
        {
            return "Feil";
        }
        
        $rad = $resultat->fetch_object();
        $kunde->personnummer = $rad->Personnummer;
        $kunde->fornavn = $rad->Fornavn;
        $kunde->etternavn = $rad->Etternavn;
        $kunde->adresse = $rad->Adresse;
        $kunde->telefonnr = $rad->Telefonnr;
        $kunde->passord = $rad->Passord;
        $kunde->postnr = $rad->Postnr;
        
        $sql = "Select Poststed from Poststed Where Postnr = '$kunde->postnr'";
        $resultat = $this->db->query($sql);
        if($this->db->affected_rows!=1)
        {
            return "Feil";
        }
        $rad = $resultat->fetch_object();
        $kunde->poststed = $rad->Poststed;
        return $kunde;
    }
}