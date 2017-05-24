<?php
include("php/core.php");
include("php/layout/header.php");
$pagename = 'Persoongegevens';
include("php/layout/breadcrumbs.php");

$gebruikersnaam = "admul";
$user  = new User($gebruikersnaam);
$openVeilingen = executeQuery("SELECT titel, beschrijving FROM veiling WHERE verkoperGebruikersnaam = ?", [$gebruikersnaam]);
$veilingidBiedingen = executeQuery("SELECT veilingId, biedingsBedrag from biedingen where gebruikersnaam = ?", [$gebruikersnaam]);
$lopendeBiedingen = executeQuery("SELECT titel, beschrijving, verkoopPrijs from veiling where veilingId = ?", [$veilingidBiedingen['data'][0]['veilingId']]);
//$verlopenBiedingen = executeQuery();
//$gewonnenBiedingen = executeQuery();
?>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

    <main class="row columns">
        <ul class="tabs" id="profieltabs" data-tabs>
            <li class="tabs-title is-active"><a href="#overzicht">Overzicht</a></li>
            <li class="tabs-title"><a href="#biedingen">Mijn biedingen</a></li>
            <li class="tabs-title"><a href="#advertenties">Mijn advertenties</a></li>
        </ul>

        <div class="tabs-content" data-tabs-content="profieltabs" data-active-collapse="true">
            <div class="tabs-panel" id="overzicht">
              <div class = "row">
                  <h4 ><strong>Algemene accountinstellingen</strong></h4>
                  <hr>
                <div class="row columns small-5 float-left">
                        <h5><strong>Gebruikersnaam en wachtwoord</strong></h5>
                    <button  id="showEditFormContact"  type="button" class = "button hollow tiny">Edit</button>
                    <p>Gebruikersnaam: <?php echo($user->getGebruikersnaam());?>
                        <br>
                        Wachtwoord:
                            <?php echo($user->getWachtwoord());?>
                            <input id = "editWachtwoord" type="text" placeholder = "New Password" style = "width: 150px; height: 25px;  ">
                    </p>
                </div>

                <div class="row columns small-6 float-right">
                    <h5><strong>Naam en geboortedatum</strong></h5>
                    <button  id="showEditFormContact"  type="button" class = "button hollow tiny">Edit</button>
                    <br>
                    Naam:
                    <?php echo($user->getVoornaam()." ".$user->getAchternaam())?>
                        <input id = "editNaam" type="text" placeholder = "Nieuwe naam"  style = "width: 150px; height: 25px;  ">
                        <br>
                        Geboortedatum:
                        <?php echo($user->getGeboortedatum()) ?>
                            <input id = "editGeboortedatum" type="date" placeholder = "Nieuwe gebruikersnaam" style = "width: 200px; height: 40px; ">

                </div>
              </div>
              <div class="row">
                <div class="row  columns small-5 float-left">
                    <h5><strong>Adres</strong></h5>
                        <button  id="showEditFormContact"  type="button" class = "button tiny hollow " style = "border-color: #0a0a0a;  background-color: white; color: #0a0a0a">Edit</button>
                            <br>
                        Provincie: <?php echo($user->getProvincie())?>
                        <input id = "editProvincie" type="text" placeholder = "Nieuwe naam" style = "width: 150px; height: 25px;  ">
                        <br>
                        Plaats: <?php echo($user->getPlaatsnaam())?>
                        <input id = "editPlaats" type="text" placeholder = "Nieuwe naam"  style = "width: 150px; height: 25px;  ">
                        <br>
                        Straat: <?php echo ($user->getStraatnaam())?>
                        <input id = "editStraat" type="text" placeholder = "Nieuwe naam"  style = "width: 150px; height: 25px;  ">
                        <br>
                        Huisnummer: <?php echo ($user->getHuisnummer())?>
                        <input id = "editHuisnummer" type="text" placeholder = "Nieuwe naam" style = "width: 150px; height: 25px;  ">


                        </p>
                </div>

                <div class="row columns small-6 float-right">
                    <h5><strong>Jouw contact gegevens</strong></h5>
                    <button  id="showEditFormContact"  type="button" class = " small-6 columns button tiny large-1 float-right" style = "border-color: #0a0a0a; margin-top: -35px; background-color: white; color: #0a0a0a">Edit</button>
                    <p>Telefoon nummer: <?php echo($user->getTelefoonnmr())?>
                    <input id = "editTelefoonnummer" type="text" placeholder = "Nieuwe naam" style = "width: 150px; height: 25px;  ">
                    </p>
                </div>
              </div>
               <button type="button" id="submitChanges" class="button large float-center">Submit Changes</button>


            <div class="tabs-panel" id="biedingen">
                <div class="row  columns">
                    <h4><strong>Mijn biedingen</strong></h4>
                    <hr>
                    <h5>Jouw lopende biedingen: </h5>
                    <p><strong>Titel: </strong><?php echo($lopendeBiedingen['data'][0]['titel']) ?>
                    <br>
                       <strong>Omschrijving: </strong> <?php echo($lopendeBiedingen['data'][0]['beschrijving']) ?>
                    <br>
                      <strong> Bedrag: </strong> <?php echo($veilingidBiedingen['data'][0]['biedingsBedrag'])  ?>
                    </p>
                    <hr>
                    <h5><strong>Jouw gewonnen biedingen</strong></h5>
                    <p>Get biedingen</p>
                    <hr>
                    <h5><strong>Jouw verlopen biedingen</strong></h5>
                    <p>Get biedingen</p>
               </div>
            </div>
            <?php /*?><div class="tabs-panel categoriemanager" id="categorie">
                <div class="row expanded" style="margin-top:0;">
                    <input type="text" placeholder="new Categorie">
                    <div type="submit" class="button" value="Submit">Submit</div>

                    <ul class="vertical menu root" data-accordion-menu>

                    </ul>
                </div>
            </div><?php */?>
            <div class="tabs-panel" id="advertenties">
                <div class="row columns">
                    <h4><strong>Mijn advertenties</strong></h4>
                    <hr>
                    <p> <h5>Je actieve veilingen: </h5>

                        <strong>Titel: </strong> <?php echo($openVeilingen['data'][0]["titel"]);?>
                       <br>
                        <strong>omschrijving:</strong> <?php echo($openVeilingen['data'][0]["beschrijving"]);?>
                    <hr>
                    <strong>   Titel: </strong><?php echo($openVeilingen['data'][1]["titel"]);?>
                        <br>
                        <strong>Omschrijving: </strong><?php echo($openVeilingen['data'][1]["beschrijving"]);?>
                    </p>
                </div>
            </div>

        </div>
    </main>

<script>
   /* $("#showEditFormUser").click(function () {
        $('#editWachtwoord').show());
    });*/



    $('#submitChanges').click(function () {


        var userInfo = {
            NEWpassword: $('#editWachtwoord').val(),
            NEWname: $('#editNaam').val(),
            NEWgeboortedatum: $('#editGeboortedatum').val(),
            NEWprovincie: $('#editProvincie').val(),
            NEWplaats: $('#editPlaats').val(),
            NEWstraat: $('#editStraat').val(),
            NEWhuisnummer: $('#editHuisnummer').val(),
            NEWtelefoonnummer: $('#editTelefoonnummer').val()
        };

        console.log(userInfo);
        $.ajax({
            type: 'POST',
            url: 'php/api.php?action=AanpassenGegevens',
            data: userInfo,

        });


    });
</script>



<?php
include("php/layout/footer.php")
?>