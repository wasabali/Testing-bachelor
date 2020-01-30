<?php
    include_once '../Model/domeneModell.php';
    class BankDBStub
    {
        function hentEnKunde($personnummer)
        {
           $enKunde = new kunde();
           $enKunde->personnummer =$personnummer;
           $enKunde->navn = "Per Olsen";
           $enKunde->adresse = "Osloveien 82, 0270 Oslo";
           $enKunde->telefonnr="12345678";
           return $enKunde;
        }
        function hentAlleKunder()
        {
           $alleKunder = array();
           $kunde1 = new kunde();
           $kunde1->personnummer ="01010122344";
           $kunde1->navn = "Per Olsen";
           $kunde1->adresse = "Osloveien 82 0270 Oslo";
           $kunde1->telefonnr="12345678";
           $alleKunder[]=$kunde1;
           $kunde2 = new kunde();
           $kunde2->personnummer ="01010122344";
           $kunde2->navn = "Line Jensen";
           $kunde2->adresse = "Askerveien 100, 1379 Asker";
           $kunde2->telefonnr="92876789";
           $alleKunder[]=$kunde2;
           $kunde3 = new kunde();
           $kunde3->personnummer ="02020233455";
           $kunde3->navn = "Ole Olsen";
           $kunde3->adresse = "Bærumsveien 23, 1234 Bærum";
           $kunde3->telefonnr="99889988";
           $alleKunder[]=$kunde3;
           return $alleKunder;
        }
        function hentTransaksjoner($kontoNr,$fraDato,$tilDato)
        {
            date_default_timezone_set("Europe/Oslo");
            $fraDato = strtotime($fraDato);
            $tilDato = strtotime($tilDato);
            if($fraDato>$tilDato)
            {
                return "Fra dato må være større enn tildato";
            }
            $konto = new konto();
            $konto->personnummer="010101234567";
            $konto->kontonummer=$kontoNr;
            $konto->type="Sparekonto";
            $konto->saldo =2300.34;
            $konto->valuta="NOK";
            if($tilDato < strtotime('2015-03-26'))
            {
                return $konto;
            }
            $dato = $fraDato;
            while ($dato<=$tilDato)
            {
                switch($dato)
                {
                    case strtotime('2015-03-26') :
                        $transaksjon1 = new transaksjon();
                        $transaksjon1->dato='2015-03-26';
                        $transaksjon1->transaksjonBelop=134.4;
                        $transaksjon1->fraTilKontonummer="22342344556";
                        $transaksjon1->melding="Meny Holtet";
                        $konto->transaksjoner[]=$transaksjon1;
                        break;
                    case strtotime('2015-03-27') :
                        $transaksjon2 = new transaksjon();
                        $transaksjon2->dato='2015-03-27';
                        $transaksjon2->transaksjonBelop=-2056.45;
                        $transaksjon2->fraTilKontonummer="114342344556";
                        $transaksjon2->melding="Husleie";
                        $konto->transaksjoner[]=$transaksjon2; 
                        break;
                    case strtotime('2015-03-29') :
                        $transaksjon3 = new transaksjon();
                        $transaksjon3->dato = '2015-03-29';
                        $transaksjon3->transaksjonBelop=1454.45;
                        $transaksjon3->fraTilKontonummer="114342344511";
                        $transaksjon3->melding="Lekeland";
                        $konto->transaksjoner[]=$transaksjon3;
                        break;
                }
                $dato +=(60*60*24); // en dag i tillegg i sekunder
            }
            return $konto;
        }
        
        function sjekkLoggInn($personnummer, $passord){
            $sjekkPersonnummer = "01010122344";
            $passordSjekk = "HeiHei";
            
            if($personnummer == $sjekkPersonnummer){
                if($passord == $passordSjekk){
                    return "OK";
                }
                else{
                    return "Feil";
                }
            }
            else{
                return "Feil";
            }
        }
        function hentKonti($personnummer){
            $konti = array();
            if($personnummer == "01010122355"){
                $kontonummer = "33445533";
                $kontonummer2 = "44554455";
                $konti[] = $kontonummer;
                $konti[] = $kontonummer2;
                return $konti;
            }
            if($personnummer == "01010122344"){
                $kontonummer1 ="55667788";
                $konti[] = $kontonummer1;
                return $konti;
            }
            else{
                $konti [] = " "; 
                return $konti;
            }
            
        }
        function hentSaldi($personnummer){
            $konto = array();
            if($personnummer == "01010122344"){
                $konto [] = "105010123456";
                $konto [] = "01010122344";
                $konto [] = "720";
                $konto [] = "Lønnskonto";
                $konto [] = "NOK";
                return $konto;
            }
            else{
                $konto [] = " ";
                return $konto;
            }
        }
        function registrerBetaling($kontoNr, $transaksjon){
            if($kontoNr == "105010123456"){
                if($transaksjon->belop <= 0){
                    return "Feil";
                }
                else{
                    return "OK";
                }
            }
            else{
                return "Feil";
            }
        }
        
        /*public function hentBetalinger($personnummer){
            $transaksjoner = array();
            if($personnummer == "01010122344"){
                $avventer = 1;
                $transaksjoner [] = "105010123456";
                $transaksjoner [] = ""
            }
            else if($personnummer == "01010122355")
        }*/
}