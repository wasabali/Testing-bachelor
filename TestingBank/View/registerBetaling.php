<?php
include_once 'navigasjon.php';
?>
<script type="text/javascript">
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
        
        $("#regBetaling").click(function(){
            var url = "../API/registrerBetaling.php";
            var data = {
                kontoNr     : $("#kontoNr").val(),
                tilKonto    : $("#tilKonto").val(),
                dato        : $("#dato").val(), 
                belop       : $("#belop").val(),
                melding     : $("#melding").val()
            }
            $.post(url,data,function(data)
            {
                if(data ==="Feil innlogging")
                {
                    $(location).attr('href', 'loggInn.php');
                }
                $(location).attr('href', 'utforBetalinger.php');  
            });
           
        });
        // input validering
        $("#tilKonto").change(function(){
            $('#feilTilKontonummer').html("");
            var regex = /[0-9]{11}/;
            var personNr = $("#tilKonto").val();
            if(!regex.test(personNr))
            {
                $('#feilTilKontonummer').html("Kontonummeret må være 11 siffer");
            }
        });
        $("#dato").change(function(){
            $('#feilDato').html("");
            var regex = /[0-9]{4}\-[0-9]{2}\-[0-9]{2}/;
            var personNr = $("#dato").val();
            if(!regex.test(personNr))
            {
                $('#feilDato').html("Dato må være på formatet yyyy-mm-dd");
            }
        });
    });
 </script>       
        
<div class="container">
    <br/><br/>
    <h2>Registrer betalinger</h2>
    <p>Velg konto og andre data for å registrere en regning</p>
        <div class="row">
            <div class="col-md-5">
                <label >Kontonr:</label>
                <div id="selekt"></div>
                <!--<input type="text" class="form-control" id="kontoNr"-->
            </div>
            <div class="col-md-5">
                <label >Til kontonummer:</label>
                <input type="text" class="form-control" id="tilKonto"><span style="color: red" id="feilTilKontonummer"></span>
            </div>
            <div class="col-md-5">
                <label >Betalingsdato:</label>
                <input type="text" class="form-control" id="dato" placeholder="yyyy-mm-dd"><span style="color: red" id="feilDato"></span>
            </div>
            <div class="col-md-5">
                <label >Beløp:</label>
                <input type="text" class="form-control" id="belop">
            </div>
            <div class="col-md-5">
                <label >Melding:</label>
                <input type="text" class="form-control" id="melding">
            </div>
        </div>
        <br/>
        <button class="btn btn-success" id="regBetaling">Registrer betaling</button>
        <br/> <br/>
</div>