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
            <h4 >Algemene accountinstellingen</h4>
            <div class = "row small-up-1 medium-up-2">
                                
                <div class="columns small-6">
                    <h5>Gebruikersnaam en wachtwoord</h5><hr>
                    <button  id="showEditFormContact"  type="button" class = "button hollow tiny">Edit</button>
                    <?php echo('<p>Gebruikersnaam: '.$user->getGebruikersnaam().'</p>'); echo('<p>Wachtwoord:'.$user->getWachtwoord().'<p>');?>
                    <input id="editWachtwoord" type="password" placeholder="New Password" style="width: 300px; ">
                </div>

                <div class="columns small-6">
                    <h5>Naam en geboortedatum</h5><hr>
                    <button  id="showEditFormContact"  type="button" class = "button hollow tiny">Edit</button>
                    <?php echo('<p>Naam: '.$user->getVoornaam().' '.$user->getAchternaam().'</p>');?>
                    <input id="editNaam" type="text" placeholder"Voornaam" style="width:300px;">
                    <?php echo('<p>Geboortedatum: '.$user->getGeboortedatum().'</p>'); ?>
                    <input id="editGeboortedatum" type="date" style="width:300px;">
                </div>
            </div>
            <div class="row small-up-1 medium-up-2">
            <div class="columns small-6">
                <h5>Adres</h5><hr>
                    <button id="showEditFormContact"  type="button" class="button tiny hollow">Edit</button>
                    <?php echo('<p>Provincie: '.$user->getProvincie().'</p>');
                    echo('<p>Plaats: '.$user->getPlaatsNaam().'</p>');
                    echo('<p>Straat :'.$user->getStraatnaam().' '.$user->getHuisnummer().'</p>');
                    ?>
                    <input id = "editProvincie" type="text" placeholder = "Provincie" style = "width: 300px;">
                    <input id = "editPlaats" type="text" placeholder = "Plaats"  style = "width: 300px;">
                    <input id = "editStraat" type="text" placeholder = "Straat"  style = "width: 300px;">
                    <input id = "editHuisnummer" type="text" placeholder = "Huisnummer" style = "width: 300px;">
            </div>

            <div class="columns small-6">
                <h5>Jouw contact gegevens</h5><hr>
                <button  id="showEditFormContact"  type="button" class = "button hollow tiny">Edit</button>
                <?php echo('<p>Telefoonnummer: '.$user->getTelefoonnmr().'</p>'); ?>
                <input id = "editTelefoonnummer" type="text" placeholder = "Telefoonnmr" style = "width: 300px;">
            </div>
            </div>
            <hr>
            <button type="button" id="submitChanges" class="button large">Submit Changes</button>
        </div>
            

        <div class="tabs-panel" id="biedingen">
            <h4>Biedingen</h4>
            <div class="row">
                <h5>Lopende biedingen</h5>
                <hr>
                <p><strong>Titel: </strong><?php echo($lopendeBiedingen['data'][0]['titel']) ?>
                <br>
                <strong>Omschrijving: </strong> <?php echo($lopendeBiedingen['data'][0]['beschrijving']) ?>
                <br>
                <strong> Bedrag: </strong> <?php echo($veilingidBiedingen['data'][0]['biedingsBedrag'])  ?>
                </p>
                <hr>
            </div>
            <div class="row">
                <h5>Gewonnen biedingen</h5>
                <hr>
            </div>
            <div class="row">
                <h5>Verlopen biedingen</h5>
            </div>
        </div>
        <div class="tabs-panel" id="advertenties">
            <h4>Advertenties</h4>
            <div class="row">
                <h5>Actieve advertenties</h5><hr>
                    <?php
                    echo('<div><span><strong>Titel:</strong> '.$openVeilingen['data'][0]["titel"].'</span><br><span><strong>Omschrijving:</strong> '.$openVeilingen['data'][0]["beschrijving"].'</span></div>');
                    ?>
            </div>
            <div class="row">
                <h5>Inactieve advertenties</h5><hr>
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