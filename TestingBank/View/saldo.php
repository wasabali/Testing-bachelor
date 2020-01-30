<?php
include_once 'navigasjon.php';
?>
<script type="text/javascript">
    // kall til hentSaldo.php
    "use strict"; 
    $(function(){
        
        // henter de aktuelle kontonumre for den påloggede personen.
        var url = "../API/hentSaldi.php";
        $.getJSON(url,function(data)
        {
            if(data ==="Feil innlogging")
            {
                $(location).attr('href', 'loggInn.php');
            }
            // formater saldo informasjon
            $("#personNr").html("Saldo for personnummer "+data[0].Personnummer);
            var tabell=formaterSaldoData(data);
            
            $("#listSaldi").html(tabell);   
        });
    }); 
        
    function formaterSaldoData(jsonData){
        var tabell="";
        tabell +="<table class='table table-bordered'>";
        tabell +="<thead><tr><th>Kontonr</th><th>Type</th><th>Saldo</th><th>Valuta</th>";
        tabell +="</thead><tbody>";
        $.each(jsonData, function( key, saldo) {
            tabell+="<tr>";
            tabell+="<td>"+saldo.Kontonummer+"</td>";
            tabell+="<td>"+saldo.Type+"</td>";
            tabell+="<td>"+saldo.Saldo+"</td>";
            tabell+="<td>"+saldo.Valuta+"</td>";
            tabell+="</tr>";
        });
        tabell +="</tbody></table>";
        return tabell;
    }
    
</script>
<div class="container">
    <br/><br/><br>
    <div id="personNr" style="font-size: 30px"></div>
    <div id="listSaldi"></div>
</div>


