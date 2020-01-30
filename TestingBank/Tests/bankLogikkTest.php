<?php
include_once '../Model/domeneModell.php';
include_once '../DAL/databaseStub.php';
include_once '../BLL/bankLogikk.php';

class bankLogikkTest extends PHPUnit\Framework\TestCase {

    public function testHentKontiFlere() {
        $personnummer = "01010122355";
        
        $bank = new Bank(new BankDBStub());
        $konto = $bank->hentKonti($personnummer);
        $this->assertEquals("33445533", $konto[0]);
        $this->assertEquals("44554455", $konto[1]);
    }
    public function testHentKontiEn(){
        $personnummer = "01010122344";
        
        $bank = new Bank(new BankDBStub());
        $konto = $bank->hentKonti($personnummer);
        $this->assertEquals("55667788", $konto[0]);
    }
    
    public function testHentKontiBlank(){
        $personnummer = "12345678911";
        
        $bank = new Bank(new BankDBStub());
        $konto = $bank->hentKonti($personnummer);
        $this->assertEquals(" ", $konto[0]);
    }
}