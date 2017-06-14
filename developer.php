<?php
//page variables
$pagename = "developer";

include("php/core.php");
include("php/layout/header.php");
?>
<main>
    <div class="row expanded">
        <div class="columns medium-2">
            <div class="row column">
                <ul class="vertical menu" data-accordion-menu>
                    <li>
                        <a href="#">Veiling</a>
                        <ul class="menu vertical nested">
                            <li><a id="veilingInfo">Veiling Info</a></li>
                            <li><a id="veilingAanmaken">Veiling Aanmaken</a></li>
                            <li><a id="veilingSluiten">Veilingen Sluiten</a></li>
                            <li><a id="trending">Trending</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">Gebruiker</a>
                        <ul class="menu vertical nested">
                            <li><a id="gebruikersGegevens">Gebruikersgegevens</a></li>
                            <li><a id="wachtwoordReset">Wachtwoord Reset</a></li>
                            <li><a id="gegevensAanpassen">Gegevens Aanpassen</a></li>
                            <li><a id="wachtwoordVeranderen">Wachtwoord Veranderen</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">Admin</a>
                        <ul class="menu vertical nested">
                            <li><a id="veilingVerplaatsen">Veiling Verplaatsen</a></li>
                            <li><a id="veilingVerwijderen">Veiling Verwijderen</a></li>
                            <li><a id="veilingBeeindigen">Veiling Beëindigen</a></li>
                            <li><a id="adminStatus">Admin Status</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <div class="columns medium-10">
            <div id="reference"></div>
        </div>
    </div>
</main>


<?php include("php/layout/footer.html"); ?>
<script>

     function changeContent(veilingInfo, parameters){
         $("#reference").empty();

         var tabelContent = "";
         for (i = 0; i < parameters.length; i++) {
            tabelContent += "<tr><td>"+parameters[i].parameter+"</td><td>"+parameters[i].default+"</td><td>"+parameters[i].description+"</td></tr>";
         }

        $("#reference").append(  "<div class='row column'>"+
                                    "<h2>"+veilingInfo.titel+"</h2>"+
                                    "<h6 class='subheader'>"+veilingInfo.beschrijving+"</h6>"+
                                "</div>"+
                                "<div class='row column'>"+
                                    "<h4>HTTP REQUEST</h4>"+
                                    "<code>POST "+veilingInfo.request+"</code>"+
                                "</div>"+

                                "<div class='row column'>"+
                                    "<table class='hover stack'>"+
                                        "<thead>"+
                                            "<tr>"+
                                                "<th>Parameter</th>"+
                                                "<th>Default</th>"+
                                                "<th>Description</th>"+
                                            "</tr>"+
                                        "</thead>"+
                                        "<tbody>"+
                                            tabelContent+
                                        "</tbody>"+
                                    "</table>"+
                                "</div>"+
                                
                                "<div class='row column'>"+
                                    "<h4><strong>Response:</strong></h4>"+
                                    "<div><code>Response messages</code></div>"+
                                "</div>"+
                                "<div class='row column'>"+
                                    "<h4><strong>Errors:</strong></h4>"+
                                    "<table class='hover stack'>"+
                                        "<thead>"+
                                            "<tr>"+
                                                "<th>Code</th>"+
                                                "<th>Message</th>"+
                                                "<th>Voorbeeld</th>"+
                                            "</tr>"+
                                        "</thead>"+
                                        "<tbody>"+
                                            "<tr>"+
                                                "<td>0</td><td>succes</td>"+
                                            "</tr>"+
                                            "<tr>"+
                                                "<td>1</td><td>User error</td><td>Ongeldige gebruikersnaam, Te grote afbeelding, Verkeerd bestandstype</td>"+
                                            "</tr>"+
                                            "<tr>"+
                                                "<td>2</td><td>Internal error</td><td>Foutieve querie, Bestanden worden niet verplaatst</td>"+
                                            "</tr>"+
                                        "</tbody>"+
                                    "</table>"+
                                "</div>");
     }
     //////////////////////////////////////
     ///            Veiling             ///
     //////////////////////////////////////
      $("#veilingInfo").click(function(){
        var veilingInfo = {titel:"Get Veiling Info",beschrijving:"This endpoint retrieves all veiling info.",request:"http://iproject34.icasites.nl/api.php?action=getVeilingInfo"};
        var parameters = [{parameter:"veilingId",default:"No Default",description:"Veiling Id is the Id of the veiling"}];
        changeContent(veilingInfo, parameters);        
     });
     $("#veilingAanmaken").click(function(){
         var veilingInfo = {
             titel: "Create New Veiling",
             beschrijving: "This endpoint creates a new veiling.",
             request: "http://iproject34.icasites.nl/securedApi.php?action=maakVeilingAan"
         };
        var parameters = [{parameter:"?",default:"?",description:"?"}];
        changeContent(veilingInfo, parameters);        
     });
     $("#veilingSluiten").click(function(){
         var veilingInfo = {
             titel: "End Veilingen",
             beschrijving: "This endpoint closes all veilingen where the date has expired.",
             request: "http://iproject34.icasites.nl/securedApi.php?action=sluitVeilingen"
         };
        var parameters = [{parameter:"No parameter"}];
        changeContent(veilingInfo, parameters);        
     });
     $("#trending").click(function(){
        var veilingInfo = {titel:"Get trending veilingen",beschrijving:"This endpoint retrieves all trending veilingen",request:"http://iproject34.icasites.nl/api.php?action=trending"};
        var parameters = [{parameter:"No parameter"}];
        changeContent(veilingInfo, parameters);        
     });
     //////////////////////////////////////
     ///           Gebruiker            ///
     //////////////////////////////////////
     $("#gebruikersGegevens").click(function(){
         var veilingInfo = {
             titel: "Get Gebruikers Info",
             beschrijving: "This endpoint retrieves all user info.",
             request: "http://iproject34.icasites.nl/securedApi.php?action=getGebruikersgegevens"
         };
        var parameters = [{parameter:"?",default:"?",description:"?"}];
        changeContent(veilingInfo, parameters);        
     });
    $("#wachtwoordReset").click(function(){
        var veilingInfo = {titel:"Reset Wachtwoord",beschrijving:"This endpoint sends mail to reset your password.",request:"http://iproject34.icasites.nl/api.php?action=resetWachtwoord"};
        var parameters = [{parameter:"gebruikersnaam",default:"No Default",description:"gebruikersnaam is de inlognaam van de gebruiker"}];
        changeContent(veilingInfo, parameters);        
    });
    $("#gegevensAanpassen").click(function(){
        var veilingInfo = {
            titel: "Aanpassen gegevens",
            beschrijving: "This endpoint changes the user information.",
            request: "http://iproject34.icasites.nl/securedApi.php?action=aanpassenGegevens"
        };
        var parameters = [{parameter:"gebruikersnaam",default:"No Default",description:"gebruikersnaam is de inlognaam van de gebruiker"}];
        changeContent(veilingInfo, parameters);        
    });
    $("#wachtwoordVeranderen").click(function(){
        var veilingInfo = {
            titel: "Verander Wachtwoord",
            beschrijving: "This endpoint changes your password",
            request: "http://iproject34.icasites.nl/api.php?action=veranderWachtwoord"
        };
        var parameters = [{parameter:"?",default:"?",description:"?"}];
        changeContent(veilingInfo, parameters);        
    });
     //////////////////////////////////////
     ///             Admin              ///
     //////////////////////////////////////
    $("#veilingVerplaatsen").click(function(){
        var veilingInfo = {
            titel: "Veiling Verplaatsen",
            beschrijving: "This endpoint changes the categorie of a veiling.",
            request: "http://iproject34.icasites.nl/api.php?action=verplaatsVeiling"
        };
        var parameters = [{parameter:"veilingId",default:"No Default",description:"Veiling Id is the Id of the veiling"},{parameter:"categorieId",default:"No Default",description:"categorieId is the Id of a categorie"}];
        changeContent(veilingInfo, parameters);        
    });
    $("#veilingVerwijderen").click(function(){
        var veilingInfo = {
            titel: "Veiling Verwijderen",
            beschrijving: "This endpoint removes a veiling.",
            request: "http://iproject34.icasites.nl/securedApi.php?action=verwijderVeiling"
        };
        var parameters = [{parameter:"veilingId",default:"No Default",description:"Veiling Id is the Id of the veiling"}];
        changeContent(veilingInfo, parameters);        
    });
    $("#veilingBeeindigen").click(function(){
        var veilingInfo = {
            titel: "Veiling beëindigen",
            beschrijving: "This endpoint ends a veiling.",
            request: "http://iproject34.icasites.nl/securedApi.php?action=beindigVeiling"
        };
        var parameters = [{parameter:"veilingId",default:"No Default",description:"Veiling Id is the Id of the veiling"}];
        changeContent(veilingInfo, parameters);        
    });
    $("#adminStatus").click(function(){
        var veilingInfo = {
            titel: "Verander Admin Status",
            beschrijving: "This endpoint changes admin rights",
            request: "http://iproject34.icasites.nl/securedApi.php?action=veranderAdminStatus"
        };
        var parameters = [{parameter:"gebruikersnaam",default:"No Default",description:"gebruikersnaam is de inlognaam van de gebruiker"}];
        changeContent(veilingInfo, parameters);        
    });
</script>

</body>
</html>