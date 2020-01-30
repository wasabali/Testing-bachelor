<?php
include_once 'adminNavigasjon.php';
?>
<script type="text/javascript">
    "use strict"; 
    $(function(){
        
        $("#regKunde").click(function(){
            var url = "../API/adminRegistrerKunde.php";
            var data = {
                personnummer    : $("#personnummer").val(),
                fornavn         : $("#fornavn").val(),
                etternavn       : $("#etternavn").val(), 
                adresse         : $("#adresse").val(),
                postnr          : $("#postnr").val(),
                poststed        : $("#poststed").val(),
                telefonnr       : $("#telefonnr").val(),
                passord         : $("#passord").val()
            }
            $.post(url,data,function(data)
            {
                if(data ==="Feil innlogging")
                {
                    $(location).attr('href', 'logInnAdmin.php');
                }
                $(location).attr('href', 'adminKunde.php');  
            });
           
        });
        // input validering
        $("#personnummer").change(function(){
            $('#feilPersonnummer').html("");
            var regex = /[0-9]{11}/;
            var data = $("#personnummer").val();
            if(!regex.test(data))
            {
                $('#feilPersonnummer').html("Personnummeret må være 11 siffer");
            }
        });
        $("#fornavn").change(function(){
            $('#feilFornavn').html("");
            var regex = /[a-zæøåA-ZÆØÅ.\- ]{2,30}/;
            var data = $("#fornavn").val();
            if(!regex.test(data))
            {
                $('#feilFornavn').html("Fornavnet må være mellom 2 og 30 tegn");
            }
        });
        $("#etternavn").change(function(){
            $('#feilEtternavn').html("");
            var regex = /[a-zæøåA-ZÆØÅ.\- ]{2,30}/;
            var data = $("#etternavn").val();
            if(!regex.test(data))
            {
                $('#feilEtternavn').html("Etternavn må være mellom 2 og 30 tegn");
            }
        });
        $("#adresse").change(function(){
            $('#feilAdresse').html("");
            var regex = /[a-zæøåA-ZÆØÅ0-9.\- ]{2,50}/;
            var personNr = $("#adresse").val();
            if(!regex.test(personNr))
            {
                $('#feilAdresse').html("Adresse må være mellom 2 og 30 tegn");
            }
        });
        $("#postnr").change(function(){
            $('#feilPostnr').html("");
            var regex = /[0-9]{4}/;
            var personNr = $("#postnr").val();
            if(!regex.test(personNr))
            {
                $('#feilPostnr').html("Postnr må være 4 siffer");
            }
        });
        $("#poststed").change(function(){
            $('#feilPoststed').html("");
            var regex = /[a-zæøåA-ZÆØÅ0-9.\- ]{2,30}/;
            var personNr = $("#poststed").val();
            if(!regex.test(personNr))
            {
                $('#feilPoststed').html("Poststed må være mellom 2 og 30 siffer");
            }
        });
        $("#telefonnr").change(function(){
            $('#feilTelefonnr').html("");
            var regex = /[0-9]{8}/;
            var personNr = $("#telefonnr").val();
            if(!regex.test(personNr))
            {
                $('#feilTelefonnr').html("Telefonnr må være 8 siffer");
            }
        });
        
    });
 </script>       
        
<div class="container">
    <br/><br/>
    <h2>Registrer Kunde</h2>
        <div class="row">
            <div class="col-md-5">
                <label >Personnummer:</label>
                <input type="text" class="form-control" id="personnummer">
                <span style="color: red" id="feilPersonnummer"></span>
            </div>
            <div class="col-md-5">
                <label >Fornavn: </label>
                <input type="text" class="form-control" id="fornavn">
                <span style="color: red" id="feilFornavn"></span>
            </div>
            <div class="col-md-5">
                <label >Etternavn:</label>
                <input type="text" class="form-control" id="etternavn">
                <span style="color: red" id="feilEtternavn"></span>
            </div>
            <div class="col-md-5">
                <label >Adresse:</label>
                <input type="text" class="form-control" id="adresse">
                <span style="color: red" id="feilAdresse"></span>
            </div>
            <div class="col-md-5">
                <label >Postnr:</label>
                <input type="text" class="form-control" id="postnr">
                <span style="color: red" id="feilPostnr"></span>
            </div>
            <div class="col-md-5">
                <label >Poststed:</label>
                <input type="text" class="form-control" id="poststed">
                <span style="color: red" id="feilPoststed"></span>
            </div>
            <div class="col-md-5">
                <label >Telefonnr:</label>
                <input type="text" class="form-control" id="telefonnr">
                <span style="color: red" id="feilTelefonnr"></span>
            </div>
            <div class="col-md-5">
                <label >Passord:</label>
                <input type="text" class="form-control" id="passord">
            </div>
        </div>
        <br/>
        <button class="btn btn-success" id="regKunde">Registrer kunde</button>
        <br/> <br/>
</div>