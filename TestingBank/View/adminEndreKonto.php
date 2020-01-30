<?php
include_once 'adminNavigasjon.php';

?>
<script type="text/javascript">
    // kall til hentSaldo.php
    "use strict"; 
    $(function(){
        
        // henter alleKonti
        var url = "../API/adminHentKonti.php";
        $.getJSON(url,function(konti)
        {
            if(konti ==="Feil innlogging")
            {
                $(location).attr('href', 'loggInnAdmin.php');
            }
            var tabell = formaterKontoData(konti);
            $("#endreKonto").html(tabell);
        });
    });
    function formaterKontoData(jsonData){
        var tabell="";
        tabell +="<table class='table table-condensed'>";
        tabell +="<thead><tr><th>Kontonummer</th><th>Saldo</th><th>Type</th><th>Valuta</th>";
        tabell +="<th>Personnummer</th><th>Endre</th><th>Slett</th>";
        tabell +="</thead><tbody>";
        var linje=1;
        $.each(jsonData, function( key, konto) {
            var saldoNum = parseFloat(konto.Saldo);
            saldoNum = saldoNum.toFixed(2);
            tabell+="<tr>";
            tabell+="<td><input type='text' readonly id='kontonummer"+linje+"' size='13' value='"+konto.Kontonummer+"'/></td>";
            tabell+="<td><input type='text' id='saldo"+linje+"' value='"+saldoNum+"' style='text-align:right'/></td>";
            tabell+="<td><input type='text' id='type"+linje+"' value='"+konto.Type+"'/></td>";
            tabell+="<td><input type='text' id='valuta"+linje+"' value='"+konto.Valuta+"'/></td>";
            tabell+="<td><input type='text' readonly id='personnummer"+linje+"' size='12' value='"+konto.Personnummer+"'/></td>";
            tabell+="<td><a class='btn btn-success' onclick='endreKonto("+linje+")'>Endre</button></td>";
            tabell+="<td><a class='btn btn-danger' onclick='slettKonto("+linje+")'>Slett</button></td>";
            tabell+="</tr>";
            linje++;
        });
        tabell +="</tbody></table>";
        return tabell;
    }
    function endreKonto(linje){
        
        var data = {
             kontonummer     : $("#kontonummer"+linje).val(),
             saldo           : $("#saldo"+linje).val(),
             type            : $("#type"+linje).val(),
             valuta          : $("#valuta"+linje).val(), 
             personnummer    : $("#personnummer"+linje).val()
        }
        var url = "../API/adminEndreKonto.php";
        $.post(url,data,function(data)
        {
             
             if(data ==="Feil innlogging")
             {
                 $(location).attr('href', 'loggInnAdmin.php');
             }
             else // OK!
             {
                 $(location).attr('href', 'adminEndreKonto.php');
             } 
        });
    }
    function slettKonto(linje){
         var kontonummer = $("#kontonummer"+linje).val();
         var url = "../API/adminSlettKonto.php?kontonummer="+kontonummer;
         var slettOK = confirm("Slett kunde med kontonummer "+kontonummer);
         if (slettOK)
         {
             $.getJSON(url,function(konto)
             {
                 if(konto ==="Feil innlogging")
                 {
                    $(location).attr('href', 'loggInnAdmin.php');
                 }
                 else
                 {
                    $(location).attr('href', 'adminEndreKonto.php');
                 }
             });
         }
     }
        
</script>

<div class="container">
    <br/><br/>
    <h2>Endre konto</h2>
    <div id="endreKonto"></div>
</div>

