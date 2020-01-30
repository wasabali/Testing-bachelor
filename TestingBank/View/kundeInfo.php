<?php
include_once 'navigasjon.php';
?>
<script type="text/javascript">
    // kall til adminEndreKunde.php
    "use strict"; 
    $(function(){
        
        var url = "../API/hentKundeInfo.php";
        $.getJSON(url,function(kunde)
        {
            if(kunde ==="Feil innlogging")
            {
                $(location).attr('href', 'loggInn.php');
            }
            // formater kunde informasjon
            var heading = "Kundeinformasjon for personnummer "+ kunde.personnummer;
            $("#heading").html(heading);
            $("#fornavn").val(kunde.fornavn);
            $("#etternavn").val(kunde.etternavn);
            $("#adresse").val(kunde.adresse);
            $("#postnr").val(kunde.postnr);
            $("#poststed").val(kunde.poststed);
            $("#telefonnr").val(kunde.telefonnr);
            $("#passord").val(kunde.passord);
        });
        
        $("#endre").click(function(){
           var kunde = {
               fornavn   : $("#fornavn").val(),
               etternavn : $("#etternavn").val(),
               adresse   : $("#adresse").val(),
               postnr    : $("#postnr").val(),
               poststed  : $("#poststed").val(),
               telefonnr : $("#telefonnr").val(),
               passord   : $("#passord").val()
           };
           var url = "../API/endreKundeInfo.php";
           $.post(url,kunde,function(data)
            {
                if(data ==="Feil innlogging")
                {
                    $(location).attr('href', 'loginn.php');
                }
                $(location).attr('href', 'kundeInfo.php');  
            });
        });
    }); 
</script>
<div class="container">
    <br/><br/><br/>
    <div id='heading' style="font-size: 30px"></div>
    <div class="row">
        <div class="col-md-3">
            <label >Fornavn:</label>
            <input type="text" class="form-control" id="fornavn">
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <label >Etternavn:</label>
            <input type="text" class="form-control" id="etternavn">
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <label >Adresse:</label>
            <input type="text" class="form-control" id="adresse">
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <label >Postnr:</label>
            <input type="text" class="form-control" id="postnr">
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <label >Poststed</label>
            <input type="text" class="form-control" id="poststed">
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <label >Telefonnr:</label>
            <input type="text" class="form-control" id="telefonnr">
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <label >Passord:</label>
            <input type="text" class="form-control" id="passord">
        </div>
    </div>
    <br/>
    <a href='saldo.php' class='btn btn-primary'>Tilbake</a>
    <button class="btn btn-success" id="endre">Endre info</button>
</div>
    
        