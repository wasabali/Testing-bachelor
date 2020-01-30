<?php
include_once '../Model/domeneModell.php';
//include_once '../DAL/databaseStub.php';
include_once '../BLL/bankLogikk.php';

class hentTransaksjonerTest extends PHPUnit\Framework\TestCase {

    
    public function testDatoFeilTransaksjoner() 
    {
        // arrange
        $kontoNr = "10502023523";
        $fraDato = '2015-03-27';
        $tilDato = '2015-03-22';
        $bank=new Bank(new BankDBStub());
        // act
        $konto= $bank->hentTransaksjoner($kontoNr, $fraDato, $tilDato);
        // assert
        $this->assertEquals("Fra dato må være større enn tildato",$konto); 
    }
    
    public function testIngenTransaksjoner() 
    {
        // arrange
        $kontoNr = "10502023523";
        $fraDato = '2015-03-20';
        $tilDato = '2015-03-22';
        $bank=new Bank(new BankDBStub());
        // act
        $konto= $bank->hentTransaksjoner($kontoNr, $fraDato, $tilDato);
        // assert
        $this->assertEquals("010101234567",$konto->personnummer); 
        $this->assertEquals($kontoNr,$konto->kontonummer);
        $this->assertEquals("Sparekonto",$konto->type);
        $this->assertEquals(2300.34,$konto->saldo); 
        $this->assertEquals("NOK",$konto->valuta); 
        $tomtArray = array();
        $this->assertEquals($tomtArray,$konto->transaksjoner);
    }
     
    public function testEnTransaksjon() 
    {
        // arrange
        $kontoNr = "10502023523";
        $fraDato = '2015-03-26';
        $tilDato = '2015-03-26';
        $bank=new Bank(new BankDBStub());
        // act
        $konto= $bank->hentTransaksjoner($kontoNr, $fraDato, $tilDato);
        // assert
        $this->assertEquals("010101234567",$konto->personnummer); 
        $this->assertEquals($kontoNr,$konto->kontonummer);
        $this->assertEquals("Sparekonto",$konto->type);
        $this->assertEquals(2300.34,$konto->saldo); 
        $this->assertEquals("NOK",$konto->valuta); 
        $this->assertEquals('2015-03-26',$konto->transaksjoner[0]->dato);
        $this->assertEquals(134.4,$konto->transaksjoner[0]->transaksjonBelop);
        $this->assertEquals("22342344556",$konto->transaksjoner[0]->fraTilKontonummer);
        $this->assertEquals("Meny Holtet",$konto->transaksjoner[0]->melding);
    }
    public function testToTransaksjoner() 
    {
        // arrange
        $kontoNr = "10502023523";
        $fraDato = '2015-03-27';
        $tilDato = '2015-03-30';
        $bank=new Bank(new BankDBStub());
        // act
        $konto= $bank->hentTransaksjoner($kontoNr, $fraDato, $tilDato);
        // assert
        $this->assertEquals("010101234567",$konto->personnummer); 
        $this->assertEquals($kontoNr,$konto->kontonummer);
        $this->assertEquals("Sparekonto",$konto->type);
        $this->assertEquals(2300.34,$konto->saldo); 
        $this->assertEquals("NOK",$konto->valuta); 
        $this->assertEquals('2015-03-27',$konto->transaksjoner[0]->dato);
        $this->assertEquals(-2056.45,$konto->transaksjoner[0]->transaksjonBelop);
        $this->assertEquals("114342344556",$konto->transaksjoner[0]->fraTilKontonummer);
        $this->assertEquals("Husleie",$konto->transaksjoner[0]->melding);
        $this->assertEquals('2015-03-29',$konto->transaksjoner[1]->dato);
        $this->assertEquals(1454.45,$konto->transaksjoner[1]->transaksjonBelop);
        $this->assertEquals("114342344511",$konto->transaksjoner[1]->fraTilKontonummer);
        $this->assertEquals("Lekeland",$konto->transaksjoner[1]->melding);
    }
    public function testAlleTransaksjoner() 
    {
        // arrange
        $kontoNr = "10502023523";
        $fraDato = '2015-03-26';
        $tilDato = '2015-03-30';
        $bank=new Bank(new BankDBStub());
        // act
        $konto= $bank->hentTransaksjoner($kontoNr, $fraDato, $tilDato);
        // assert
        $this->assertEquals("010101234567",$konto->personnummer); 
        $this->assertEquals($kontoNr,$konto->kontonummer);
        $this->assertEquals("Sparekonto",$konto->type);
        $this->assertEquals(2300.34,$konto->saldo); 
        $this->assertEquals("NOK",$konto->valuta);
        $this->assertEquals('2015-03-26',$konto->transaksjoner[0]->dato);
        $this->assertEquals(134.4,$konto->transaksjoner[0]->transaksjonBelop);
        $this->assertEquals("22342344556",$konto->transaksjoner[0]->fraTilKontonummer);
        $this->assertEquals("Meny Holtet",$konto->transaksjoner[0]->melding);
        $this->assertEquals('2015-03-27',$konto->transaksjoner[1]->dato);
        $this->assertEquals(-2056.45,$konto->transaksjoner[1]->transaksjonBelop);
        $this->assertEquals("114342344556",$konto->transaksjoner[1]->fraTilKontonummer);
        $this->assertEquals("Husleie",$konto->transaksjoner[1]->melding);
        $this->assertEquals('2015-03-29',$konto->transaksjoner[2]->dato);
        $this->assertEquals(1454.45,$konto->transaksjoner[2]->transaksjonBelop);
        $this->assertEquals("114342344511",$konto->transaksjoner[2]->fraTilKontonummer);
        $this->assertEquals("Lekeland",$konto->transaksjoner[2]->melding);
    }

    
}
