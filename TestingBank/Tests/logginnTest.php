<?php
include_once '../Model/domeneModell.php';
//include_once '../DAL/databaseStub.php';
include_once '../BLL/bankLogikk.php';

class logginnTest extends PHPUnit\Framework\TestCase {


    public function test_passordFeil() {
        $personnummer = "01010110523";
        $passord = "Hei";
        
        $bank=new Bank(new BankDBStub());
        $logginn = $bank->sjekkLoggInn($personnummer, $passord);
        $this->assertEquals("Feil i passord", $logginn);
    }
    
    public function test_personnummerFeil(){
        $personnummer = "0523";
        $passord = "HeiHei";
        
        $bank=new Bank(new BankDBStub());
        $logginn = $bank->sjekkLoggInn($personnummer, $passord);
        $this->assertEquals("Feil i personnummer", $logginn);
    }
    
    public function test_logginn(){
        $personnummer = "01010122344";
        $passord = "HeiHei";
        
        
        $bank=new Bank(new BankDBStub());
        $logginn = $bank->sjekkLoggInn($personnummer, $passord);
        $this->assertEquals("OK", $logginn);
    }
    
    public function test_logginn_feilPassord(){
        $personnummer = "01010122344";
        $passord = "Hehhehe";
        
        
        $bank=new Bank(new BankDBStub());
        $logginn = $bank->sjekkLoggInn($personnummer, $passord);
        $this->assertEquals("Feil", $logginn);
    }
    
    public function test_logginn_feilPersonnummer(){
        $personnummer = "01010134411";
        $passord = "HeiHei";
        
        
        $bank=new Bank(new BankDBStub());
        $logginn = $bank->sjekkLoggInn($personnummer, $passord);
        $this->assertEquals("Feil", $logginn);
    }
    
}