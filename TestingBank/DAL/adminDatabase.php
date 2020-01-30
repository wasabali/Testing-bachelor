<?php
include_once '../Model/domeneModell.php';
class AdminDB
{
    private $db;
    function __construct()
    {
        $this->db=new mysqli("localhost","root","","bank");
        $this->db->set_charset("utf8");
    }
    
    function hentAlleKunder()
    {
        $sql = "Select * from Kunde Left Join Poststed On Kunde.postnr = Poststed.postnr ";
        $resultat = $this->db->query($sql);
        $kunder = array();
        while($rad = $resultat->fetch_object())
        {
            $kunder[]=$rad;
        }
        return $kunder;
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
    
    function registerKonto($konto)
    {
        $sql = "Select * from Kunde Where Personnummer = '$konto->personnummer'";
        $resultat = $this->db->query($sql);
        if($this->db->affected_rows!=1)
        {
            echo json_encode("Feil i personnummer");
            die();
        }
        $sql = "Insert into Konto (Personnummer, Kontonummer, Saldo, Type, Valuta)";
        $sql .= "Values ('$konto->personnummer','$konto->kontonummer','$konto->saldo',"
                . "'$konto->type','$konto->valuta')";
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
    
    function endreKonto($konto)
    {
        $sql = "Select * from Kunde Where Personnummer = '$konto->personnummer'";
        $resultat = $this->db->query($sql);
        if($this->db->affected_rows!=1)
        {
            echo json_encode("Feil i personnummer");
            die();
        }
        $sql = "Select * from Konto Where Kontonummer = '$konto->kontonummer'";
        $resultat = $this->db->query($sql);
        if($this->db->affected_rows!=1)
        {
            echo json_encode("Feil i kontonummer");
            die();
        } 
        
        $sql =  "Update Konto Set Personnummer = '$konto->personnummer', "
                . "Kontonummer = '$konto->kontonummer', Type = '$konto->type', "
                . "Saldo = '$konto->saldo', Valuta = '$konto->valuta' "
                . "Where Kontonummer = '$konto->kontonummer'";
        $resultat = $this->db->query($sql);
        return "OK";
    }
    
    function hentAlleKonti()
    {
        $sql = "Select * from Konto";
        $resultat = $this->db->query($sql);
        $konti=array();
        while($rad = $resultat->fetch_object())
        {
            $konti[]=$rad;
        }
        return $konti;
    }
    function slettKonto($kontonummer)
    {
        $sql = "Delete from Konto Where Kontonummer = '$kontonummer'";
        $resultat = $this->db->query($sql);
        if($this->db->affected_rows!=1)
        {
            echo json_encode("Feil kontonummer");
            die();
        }
        return "OK";
    }
}
