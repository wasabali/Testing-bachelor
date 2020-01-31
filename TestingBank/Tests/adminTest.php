<?php
include_once '../Model/domeneModell.php';
include_once '../DAL/adminDatabaseStub.php';
include_once '../BLL/adminLogikk.php';

class adminTest extends PHPUnit\Framework\TestCase {
    
    public function test_hentAlleKunder(){ 
        $db = new AdminDBStub();
        $kunder = $db->hentAlleKunder();
        
        $this->assertEquals("12345678901", $kunder[0]->personnummer);
        $this->assertEquals("Per", $kunder[0]->fornavn);
        $this->assertEquals("Olsen", $kunder[0]->etternavn);
        
        $this->assertEquals("01010110523", $kunder[1]->personnummer);
        $this->assertEquals("Lene", $kunder[1]->fornavn);
        $this->assertEquals("Jensen", $kunder[1]->etternavn);

    }
    
        function test_registrerKunto_OK()
    {
        // arrange
        $kundeLogikk=new Admin(new AdminDBStub());
        $kunde = new kunde();
        $kunde->personnummer = "12345678901";
        $kunde->fornavn = "Per";
        $kunde->etternavn ="Olsen";
        
        // act
        $OK= $kundeLogikk->registrerKunde($kunde);
        // assert
        $this->assertEquals("OK",$OK); 
    }
    
    function test_registrerKunto_DB_Feil()
    {
        // arrange
        $kundeLogikk=new Admin(new AdminDBStub());
        $kunde = new kunde();
        $kunde->ID = "0101012234";
        $kunde->fornavn = "Per";
        $kunde->etternavn ="Olsen";
        
        // act
        $OK= $kundeLogikk->registrerKunde($kunde);
        // assert
        $this->assertEquals("Feil",$OK); 
    }
    
    function test_endreKundeInfo_DB_Feil()
    {
        // arrange
        $kundeLogikk=new Admin(new AdminDBStub());
        $kunde = new kunde();
        $kunde->personnummer = "0101012234";
        $kunde->fornavn = "Per";
        $kunde->etternavn ="Olsen";
        
       
        // act
        $OK= $kundeLogikk->endreKundeInfo($kunde);
        // assert
        $this->assertEquals("Feil",$OK); 
    }
    function test_endreKundeInfo_OK()
    {
        // arrange
        $kundeLogikk=new Admin(new AdminDBStub());
        $kunde = new kunde();
        $kunde->personnummer = "12345678901";
        $kunde->fornavn = "Per";
        $kunde->etternavn ="Olsen";
        
        // act
        $OK= $kundeLogikk->endreKundeInfo($kunde);
        // assert
        $this->assertEquals("OK",$OK); 
    }
    function test_slettKunde_OK()
    {
        // arrange
        $kundeLogikk=new Admin(new AdminDBStub());
        $kunde = new kunde();
        $kunde->personnummer = "12345678901";
        $kunde->fornavn = "Per";
        $kunde->etternavn ="Olsen";
        
        // act
        $OK= $kundeLogikk->slettKunde($kunde);
        // assert
        $this->assertEquals("OK",$OK); 
    }
    function test_slettKunde_DB_Feil()
    {
        // arrange
        $kundeLogikk=new Admin(new AdminDBStub());
        $kunde = new kunde();
        $kunde->personnummer = "0101012234";
        $kunde->fornavn = "Per";
        $kunde->etternavn ="Olsen";
        
       
        // act
        $OK= $kundeLogikk->slettKunde($kunde);
        // assert
        $this->assertEquals("Feil",$OK); 
    }
    
    
    //registerKonto() heter den i databasen, derfor blir det feil
    function test_registrerKonto_OK()
    {
        // arrange
        $kundeLogikk=new Admin(new AdminDBStub());
        $kunde = new kunde();
        $kunde->personnummer = "12345678901";
        $kunde->fornavn = "Per";
        $kunde->etternavn ="Olsen";
        
        // act
        $OK= $kundeLogikk->registrerKonto($kunde);
        // assert
        $this->assertEquals("OK",$OK); 
    }
    //registerKonto() heter den i databasen, derfor blir det feil
    function test_registrerKonto_DB_Feil()
    {
        // arrange
        $kundeLogikk=new Admin(new AdminDBStub());
        $kunde = new kunde();
        $kunde->personnummer = "0101012234";
        // act
        $OK= $kundeLogikk->registrerKonto($kunde);
        // assert
        $this->assertEquals("Feil",$OK); 
    }
    
    function test_endreKonto_OK()
    {
        // arrange
        $kundeLogikk=new Admin(new AdminDBStub());
        $kunde = new kunde();
        $kunde->personnummer = "12345678901";
        // act
        $OK= $kundeLogikk->endreKonto($kunde);
        // assert
        $this->assertEquals("OK",$OK); 
    }
    function test_endreKonto_DB_Feil()
    {
        // arrange
        $kundeLogikk=new Admin(new AdminDBStub());
        $kunde = new kunde();
        $kunde->personnummer = "0101012234";
        $kunde->fornavn = "Per";
        $kunde->etternavn ="Olsen";
        
       
        // act
        $OK= $kundeLogikk->endreKonto($kunde);
        // assert
        $this->assertEquals("Feil",$OK); 
    }
    
    function test_hentAlleKonti()
    {
        $db = new AdminDBStub();
        $konto = $db->hentAlleKonti();

        $this->assertEquals("01010110523", $konto[0]->personnummer);
        $this->assertEquals("12345678901", $konto[1]->personnummer);
        
    }
    
    
}

