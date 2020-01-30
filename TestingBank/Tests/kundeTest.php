<?php
include_once '../Model/domeneModell.php';
include_once '../DAL/databaseStub.php';
include_once '../BLL/bankLogikk.php';

class kundeTest extends PHPUnit\Framework\TestCase {


    public function test_hentEnKunde(){
        $personnummer = "12345678911";
        $db = new BankDBStub;
        $enKunde = new kunde();
        $enKunde->personnummer =$personnummer;
        $enKunde->navn = "Per Olsen";
        $enKunde->adresse = "Osloveien 82, 0270 Oslo";
        $enKunde->telefonnr="12345678";
        $kunde = $db->hentEnKunde($personnummer);
        $this->assertEquals($kunde, $enKunde); 
    }
    
    public function test_hentAlleKunder(){
        $db = new BankDBStub();
        $kunder = $db->hentAlleKunder();
        
        $this->assertEquals("01010122344", $kunder[0]->personnummer);
        $this->assertEquals("Per Olsen", $kunder[0]->navn);
        $this->assertEquals("Osloveien 82 0270 Oslo", $kunder[0]->adresse);
        $this->assertEquals("12345678", $kunder[0]->telefonnr);
        
        $this->assertEquals("01010122344", $kunder[1]->personnummer);
        $this->assertEquals("Line Jensen", $kunder[1]->navn);
        $this->assertEquals("Askerveien 100, 1379 Asker", $kunder[1]->adresse);
        $this->assertEquals("92876789", $kunder[1]->telefonnr);
        
        $this->assertEquals("02020233455", $kunder[2]->personnummer);
        $this->assertEquals("Ole Olsen", $kunder[2]->navn);
        $this->assertEquals("Bærumsveien 23, 1234 Bærum", $kunder[2]->adresse);
        $this->assertEquals("99889988", $kunder[2]->telefonnr);
    }
}