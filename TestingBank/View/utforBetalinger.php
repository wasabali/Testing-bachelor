<?php
include_once 'navigasjon.php';
?>
<script type="text/javascript">
    // kall til hentTransaksjoner.php
    "use strict"; 
    $(function(){
        
        // henter de aktuelle registrerte betalinger for alle konti for den påloggende personen personen.
        var url = "../API/hentBetalinger.php";
        $.getJSON(url,function(data)
        {
            if(data ==="Feil innlogging")
            {
                $(location).attr('href', 'loggInn.php');
            }
            var tabell=formaterBetalingsData(data);
            $("#listBetalinger").html(tabell); 
            
            $("button").click(function()
            {
                var txid= $(this).attr('data-txid');
                // oppdater viewet ved å kalle utforBetaling og returner det oppdaterte resultatet
                var url = "../API/utforBetaling.php?TxID="+txid;
                $.getJSON(url,function(data1)
                {
                    if(data1 ==="Feil innlogging")
                    {
                        $(location).attr('href', 'logginn.php');
                    }
                    var tabell=formaterBetalingsData(data1);
                    $("#listBetalinger").html(tabell);
                    window.location.reload();
                });
            });
        });
        
        
    });
    
    function formaterBetalingsData(jsonData){
        var tabell="";
        tabell +="<table class='table table-bordered'>";
        tabell +="<thead><tr><th>Fra kontonr</th><th>Til kontonr</th><th>Dato</th><th>Beløp</th><th>Melding</th></tr>";
        tabell +="</thead><tbody>";
        $.each(jsonData, function( key,betaling) {
            tabell+="<tr>";
            tabell+="<td>"+betaling.Kontonummer+"</td>";
            tabell+="<td>"+betaling.FraTilKontonummer+"</td>";
            tabell+="<td>"+betaling.Dato+"</td>";
            tabell+="<td>"+betaling.Belop+"</td>";
            tabell+="<td>"+betaling.Melding+"</td>";
            tabell+="<td><button class='btn btn-success' data-txid='"+betaling.TxID+"'>Utfør betaling</button></td>";
            tabell+="</tr>";
        });
        tabell +="</tbody></table>";
        return tabell;
    }
    
</script>
<div class="container">
    <br/><br/>
    <h2>Utfør betalinger</h2>
    <div id="listBetalinger"></div>
</div>
