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
    
    public function testHentSaldi(){
        $personnummer = "01010122344";
        
        $bank = new Bank(new BankDBStub());
        $konto = $bank->hentSaldi($personnummer);
        $this->assertEquals("105010123456", $konto[0]);
        $this->assertEquals("01010122344", $konto[1]);
        $this->assertEquals("720", $konto[2]);
        $this->assertEquals("Lønnskonto", $konto[3]);
        $this->assertEquals("NOK", $konto[4]);
    }
    
    public function testHentSaldiBlank(){
        $personnummer = "01010122355";
        
        $bank = new Bank(new BankDBStub());
        $konto = $bank->hentSaldi($personnummer);
        $this->assertEquals(" ", $konto[0]);
    }
    
    public function testRegistrerBetaling(){
        $kontonummer = "105010123456";
        $transaksjon = new transaksjon;
        $transaksjon -> belop = 20;
        
        $bank = new Bank(new BankDBStub);
        $betaling = $bank->registrerBetaling($kontonummer, $transaksjon);
        $this->assertEquals("OK", $betaling);
    }
    
    public function testRegistrerBetalingBelopFeil(){
        $kontonummer = "105010123456";
        $transaksjon = new transaksjon;
        $transaksjon -> belop = 0;
        
        $bank = new Bank(new BankDBStub);
        $betaling = $bank->registrerBetaling($kontonummer, $transaksjon);
        $this->assertEquals("Feil", $betaling);
    }
    
    public function testRegistrerBetalingKontoNrFeil(){
        $kontonummer = "105010123477";
        $transaksjon = new transaksjon;
        $transaksjon -> belop = 20;
        
        $bank = new Bank(new BankDBStub);
        $betaling = $bank->registrerBetaling($kontonummer, $transaksjon);
        $this->assertEquals("Feil", $betaling);
    }
}