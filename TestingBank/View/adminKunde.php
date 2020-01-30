<?php
include_once 'adminNavigasjon.php';
?>
<script type="text/javascript">
    // kall til hentSaldo.php
    "use strict"; 
    $(function(){
        
        // henter alle kunder
        var url = "../API/hentAlleKunder.php";
        $.getJSON(url,function(data)
        {
            if(data ==="Feil innlogging")
            {
                $(location).attr('href', 'loggInnAdmin.php');
            }
            // formater kunde-informasjon
            var tabell=formaterKundeData(data);
            
            $("#listKunde").html(tabell);
        });
    }); 
        
    function formaterKundeData(jsonData){
        var tabell="";
        tabell +="<table class='table table-condensed'>";
        tabell +="<thead><tr><th>Personnr</th><th>Fornavn</th><th>Etternavn</th><th>Adresse</th>";
        tabell +="<th>Postnr</th><th>Poststed</th><th>Telefonnr</th><th>Passord</th><th>Endre</th><th>Slett</th>";
        tabell +="</thead><tbody>";
        var linje=1;
        $.each(jsonData, function( key, kunde) {
            tabell+="<tr>";
            tabell+="<td><input type='text' readonly id='personnummer"+linje+"' size='12' value='"+kunde.Personnummer+"'/></td>";
            tabell+="<td><input type='text' id='fornavn"+linje+"' value='"+kunde.Fornavn+"'/></td>";
            tabell+="<td><input type='text' id='etternavn"+linje+"' value='"+kunde.Etternavn+"'/></td>";
            tabell+="<td><input type='text' id='adresse"+linje+"' value='"+kunde.Adresse+"'/></td>";
            tabell+="<td><input type='text' id='postnr"+linje+"' size='4' value='"+kunde.Postnr+"'/></td>";
            tabell+="<td><input type='text' id='poststed"+linje+"' value='"+kunde.Poststed+"'/></td>";
            tabell+="<td><input type='text' id='telefonnr"+linje+"' size='8' value='"+kunde.Telefonnr+"'/></td>";
            tabell+="<td><input type='text' id='passord"+linje+"' value='"+kunde.Passord+"'/></td>";
            tabell+="<td><a class='btn btn-success' onclick='endreKunde("+linje+")'>Endre</button></td>";
            tabell+="<td><a class='btn btn-danger' onclick='slettKunde("+linje+")'>Slett</button></td>";
            tabell+="</tr>";
            linje++;
        });
        tabell +="</tbody></table>";
        return tabell;
    }
    
    function endreKunde(linje)
    {
        var kunde = {
               personnummer : $("#personnummer"+linje).val(),
               fornavn      : $("#fornavn"+linje).val(),
               etternavn    : $("#etternavn"+linje).val(),
               adresse      : $("#adresse"+linje).val(),
               postnr       : $("#postnr"+linje).val(),
               poststed     : $("#poststed"+linje).val(),
               telefonnr    : $("#telefonnr"+linje).val(),
               passord      : $("#passord"+linje).val()
           };
           var url = "../API/adminEndreKunde.php";
           $.post(url,kunde,function(data)
            {
                if(data ==="Feil innlogging")
                {
                    $(location).attr('href', 'loggInnAdmin.php');
                }
                $(location).attr('href', 'adminKunde.php'); 
            });
    }
    
    function slettKunde(linje)
    {
        var persNr = $("#personnummer"+linje).val();
        var slettOK = confirm("Slett kunde med personnummer "+persNr);
        if (slettOK)
        {
            var url = "../API/adminSlettKunde.php?personnummer="+persNr;
            $.getJSON(url,function(data)
            {
                window.location.reload();
            });
        }
    }

</script>
<h2>Endre kunde</h2>
<div id="listKunde" class="table-responsive"></div>
