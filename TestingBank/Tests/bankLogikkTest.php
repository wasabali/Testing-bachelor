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
    
    public function testHentBetalingerFlere(){
        $personnummer = "01010122344";
        
        $bank = new Bank(new BankDBStub);
        $betaling = $bank->hentBetalinger($personnummer);
        $this->assertEquals("105010123456", $betaling[0]);
        $this->assertEquals("205010123456", $betaling[1]);
    }
    
    public function testHentBetalingerEn(){
        $personnummer = "01010122355";
        
        $bank = new Bank(new BankDBStub);
        $betaling = $bank->hentBetalinger($personnummer);
        $this->assertEquals("505010123456", $betaling[0]);
    }
    
    public function testHentBetalingerBlank(){
        $personnummer = "01010122377";
        
        $bank = new Bank(new BankDBStub);
        $betaling = $bank->hentBetalinger($personnummer);
        $this->assertEquals(" ", $betaling[0]);
    }
    
    public function testUtforBetalingGodkjent(){
        $TxID = "1";
        
        $bank = new Bank(new BankDBStub);
        $utforBetaling = $bank->utforBetaling($TxID);
        $this->assertEquals("OK", $utforBetaling);
    }
    
    public function testUtforBetalingFlereTransaksjoner(){
        $TxID = "2";
        
        $bank = new Bank(new BankDBStub);
        $utforBetaling = $bank->utforBetaling($TxID);
        $this->assertEquals("Feil", $utforBetaling);
    }
    
    public function testUtforBetalingForLitePaaSaldo(){
        $TxID = "3";
        
        $bank = new Bank(new BankDBStub);
        $utforBetaling = $bank->utforBetaling($TxID);
        $this->assertEquals("Feil", $utforBetaling);
    }
    
    public function testUtforBetalingFinnerIkkeTransaksjon(){
        $TxID = "4";
        
        $bank = new Bank(new BankDBStub);
        $utforBetaling = $bank->utforBetaling($TxID);
        $this->assertEquals("Feil", $utforBetaling);
    }
    
    public function testendreKundeInfo(){
        $kunde = new kunde();
        $kunde->fornavn = "Kari";
        $kunde->etternavn = "Hansen";
        $kunde->postnr = "4455";
        
        $bank = new Bank(new BankDBStub);
        $endreKunde = $bank->endreKundeInfo($kunde);
        $this->assertEquals("OK", $endreKunde);
    }
    public function testendreKundeInfoNyttPoststed(){
        $kunde = new kunde();
        $kunde->fornavn = "Kari";
        $kunde->etternavn = "Hansen";
        $kunde->postnr = "2020";
        
        $bank = new Bank(new BankDBStub);
        $endreKunde = $bank->endreKundeInfo($kunde);
        $this->assertEquals("OK", $endreKunde);
    }
    public function testEndreKundeFeil(){
        $kunde = new kunde();
        $kunde->fornavn = "Hans";
        $kunde->etternavn = "Hansen";
        $kunde->postnr = "4455";
        
        $bank = new Bank(new BankDBStub);
        $endreKunde = $bank->endreKundeInfo($kunde);
        $this->assertEquals("Feil", $endreKunde);
    }
    
    public function testHentKundeInfo(){
        $personnummer = "01010122344";
        
        $bank = new Bank(new BankDBStub());
        $kunde = $bank ->hentKundeInfo($personnummer);
        $this->assertEquals("Kari", $kunde->fornavn);
        $this->assertEquals("Hansen", $kunde->etternavn);
    }
    
    public function testHentKundeInfoFeilIPostNr(){
        $personnummer = "01010122355";
        
        $bank = new Bank(new BankDBStub());
        $kunde = $bank ->hentKundeInfo($personnummer);
        $this->assertEquals("Feil", $kunde);
    }
    
    public function testHentKundeInfoFeilIPersonNr(){
        $personnummer = "20010122355";
        
        $bank = new Bank(new BankDBStub());
        $kunde = $bank ->hentKundeInfo($personnummer);
        $this->assertEquals("Feil", $kunde);
    }
}