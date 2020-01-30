<?php
include_once 'adminNavigasjon.php';
?>
<script type="text/javascript">
    "use strict"; 
    $(function(){
       $("#regKonto").click(function(){
            var url = "../API/adminRegistrerKonto.php";
            var data = {
                kontonummer     : $("#kontoNr").val(),
                type            : $("#type").val(),
                valuta          : $("#valuta").val(), 
                personnummer    : $("#personnummer").val()
            }
            $.post(url,data,function(data)
            {
                $("#feilPersonnr").html("");
                if(data === "Feil i personnummer")
                {
                    $("#feilPersonnr").html("Personnummer finnes ikke!");
                }
                else if(data ==="Feil innlogging")
                {
                    $(location).attr('href', 'loggInnAdmin.php');
                }
                else // OK!
                {
                    $(location).attr('href', 'adminKunde.php');
                } 
            });
           
        });
         // input validering
        $("#kontoNr").change(function(){
            $('#feilKontonummer').html("");
            var regex = /[0-9]{11}/;
            var kontoNr = $("#kontoNr").val();
            if(!regex.test(kontoNr))
            {
                $('#feilKontonummer').html("Kontonummeret må være 11 siffer");
            }
        });
        $("#personnummer").change(function(){
            $('#feilPersonnummer').html("");
            var regex = /[0-9]{11}/;
            var personNr = $("#personnummer").val();
            if(!regex.test(personNr))
            {
                $('#feilPersonnummer').html("Personnummeret må være 11 siffer");
            }
        });
    });    
        
</script>
<div class="container">
    <br/><br/>
    <h2>Register konto</h2>
    <div class="row">
            <div class="col-md-5">
                <label >Kontonummer:</label>
                <input type="text" class="form-control" id="kontoNr"><span style="color: red" id="feilKontonummer"></span>
            </div>
            <div class="col-md-5">
                <label >Type: </label>
                <input type="text" class="form-control" id="type">
            </div>
            <div class="col-md-5">
                <label >Valuta:</label>
                <input type="text" class="form-control" id="valuta">
            </div>
            <div class="col-md-5">
                <label >Personnummer:</label>
                <input type="text" class="form-control" id="personnummer"><span style="color: red" id="feilPersonnummer"></span>
            </div>
    </div>
    <br/>
    <button class="btn btn-success" id="regKonto">Registrer konto</button>
    <br/> <br/>
    <div id="feilPersonnr"></div>
</div>


