<?php
include_once 'navigasjon.php';
?>
<script type="text/javascript">
    // kall til hentTransaksjoner.php
    "use strict"; 
    $(function(){
        
        // henter de aktuelle kontonumre for den påloggede personen.
        var url = "../API/hentKonti.php";
        $.getJSON(url,function(data)
        {
            if(data ==="Feil innlogging")
            {
                $(location).attr('href', 'loggInn.php');
            }
            // bygger så en dropdown-meny og legger den ut slik at den kan velges av bruker.
            var dropdown ="<Select id='kontoNr' class='form-control'>";
            $.each(data, function( key, konto) {
                dropdown +="<option>"+konto.Kontonummer+"</option>";
            });
            dropdown +="</Select>";
            $("#selekt").html(dropdown);
        });
        
        
        $("#sok").click(function(){
            var fraDato = $("#fraDato").val();
            var tilDato = $("#tilDato").val();
            var kontoNr = $("#kontoNr").val();
            var url = "../API/hentTransaksjoner.php?fraDato="+fraDato+"&tilDato="+tilDato+"&kontoNr="+kontoNr;
            $.getJSON(url,function(data)
            {
                if(data ==="Feil innlogging")
                {
                    $(location).attr('href', 'loginn.php');
                }
                var tabell=formaterTransaksjonsData(data);
                $("#listTransaksjoner").html(tabell);   
            });
           
        });
    });
    
    function formaterTransaksjonsData(jsonData){
        var tabell="";
        tabell +="<table class='table table-bordered'>";
        tabell +="<thead><tr><th>Dato</th><th>Til kontonr</th><th>Beløp</th><th>Melding</th></tr>";
        tabell +="</thead><tbody>";
        $.each(jsonData.transaksjoner, function( key, transaksjon ) {
            tabell+="<tr>";
            tabell+="<td>"+transaksjon.dato+"</td>";
            tabell+="<td>"+transaksjon.fraTilKontonummer+"</td>";
            tabell+="<td>"+transaksjon.transaksjonBelop+"</td>";
            tabell+="<td>"+transaksjon.melding+"</td>";
            tabell+="</tr>";
        });
        tabell +="</tbody></table>";
        return tabell;
    }
    
</script>
<div class="container">
    <br/><br/>
    <h2>Transaksjoner for konto</h2>
    <p>Velg fra og til dato for å vise transaksjoner fra konto</p>
        <div class="row">
            <div class="col-md-3">
                <label >Kontonr:</label>
                <div id="selekt"></div>
                <!--<input type="text" class="form-control" id="kontoNr"-->
            </div>
            <div class="col-md-3">
                <label >Fra dato:</label>
                <input type="text" class="form-control" id="fraDato" placeholder="yyyy-mm-dd">
            </div>
            <div class="col-md-3">
                <label >Til dato:</label>
                <input type="text" class="form-control" id="tilDato" placeholder="yyyy-mm-dd">
            </div>
        </div>
        <br/>
        <button class="btn btn-success" id="sok">Søk</button>
        <br/> <br/>
    <p>Transaksjoner for valgte datoer:</p>            
    <div id="listTransaksjoner">
    </div>
</div>