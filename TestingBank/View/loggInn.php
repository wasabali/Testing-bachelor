<?php
include_once 'minNavigasjon.php';
?>
<script type="text/javascript">
    $(function(){
        "use strict"; 
        
        $("#loggInn").click(function(){
            var personNr = $("#personNr").val();
            var passord = $("#passord").val();
            var url = "../API/loggInn.php?personnummer="+personNr+"&passord="+passord;

            $.getJSON(url,function(retur)
            {
                if(retur ==="OK")
                {
                    // dersom innloggingen var vellykket gå til saldo.php
                    $(location).attr('href', 'saldo.php');
                }
                else
                {
                    // dersom innloggingen ikke var vellykket står vi på samme sted
                    $("#feilMelding").html("Feil personnummer / passord!");
                }
            });
        });
        // input validering
        $("#personNr").change(function(){
            $('#feilPersonNr').html("");
            var regex = /[0-9]{11}/;
            var personNr = $("#personNr").val();
            if(!regex.test(personNr))
            {
                $('#feilPersonNr').html("Personnummer nå være 11 siffer");
            }
        });
        
        $("#passord").change(function(){
            $('#feilPassord').html("");
            var regex = /.{6,30}/;
            var passord = $("#passord").val();
            if(!regex.test(passord))
            {
                $('#feilPassord').html("Minimum 6 tegn");
            }
        });
    });
</script>
<div class="container">
    <br/><br/>
    <h2>Logg inn</h2>
    <p>Vennligst oppgi personnummer og passord for å logge inn</p>
    <div class="row">
        <div class="col-md-3">
            <label >Personnummer:</label>
            <input type="text" class="form-control" id="personNr"> 
            <span style="color: red" id="feilPersonNr"></span>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <label >Passord:</label>
            <input type="text" class="form-control" id="passord">
            <span style="color: red" id="feilPassord"></span>
        </div>
    </div>
    <br/>
    <button class="btn btn-success" id="loggInn">Logg inn</button>
    <br/> <br/>
    <div id="feilMelding"></div>
 </div>
     


