<?php
include("php/core.php");
include("php/layout/header.php");
$pagename = 'Persoongegevens';
include("php/layout/breadcrumbs.php");
error_reporting(E_ERROR | E_WARNING | E_PARSE);

$gebruikersnaam = "admul";
$user  = new User($gebruikersnaam);

$alleVerlopenVeilingen = executeQuery("SELECT veilingid FROM veiling where veilingGestopt = ?", [1]);
$openVeilingen = executeQuery("SELECT titel, beschrijving FROM veiling WHERE verkoperGebruikersnaam = ? and veilingGestopt = ?", [$gebruikersnaam, 0]);
$veilingidBiedingen = executeQuery("SELECT veilingId, biedingsBedrag from biedingen where gebruikersnaam = ?", [$gebruikersnaam]);
$lopendeBiedingen = executeQuery("SELECT titel, beschrijving, verkoopPrijs from veiling where veilingId = ?", [$veilingidBiedingen['data'][0]['veilingId']]);
$verlopenBiedingen = executeQuery("SELECT veilingId, biedingsBedrag, biedingsTijd from biedingen where veilingId = ? and gebruikersNaam = ?", [ $alleVerlopenVeilingen['data'], $gebruikersnaam]);
$gewonnenBiedingen = executeQuery("SELECT titel, beschrijving, verkoopPrijs from veiling where koperGebruikersnaam = ? and verkoopPrijs is not null ",[$gebruikersnaam]);
$verlopenveilingen = executeQuery("SELECT titel, beschrijving, verkoopPrijs from veiling where verkoperGebruikersnaam = ? and veilingGestopt = ?",[$gebruikersnaam,1 ]);

$aantalLopendeBiedingen = count($lopendeBiedingen['data']);
$aantalLopendeVeilingen = count($openVeilingen['data']);
$aantalGewonnenBiedingen = count($gewonnenBiedingen['data']);
$aantalVerlopenVeilingen = count($verlopenveilingen['data']);

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
                    <button  id="showInlogGegevens"  type="button" class = "button hollow tiny">Edit</button>
                    <?php echo('<p>Gebruikersnaam: '.$user->getGebruikersnaam().'</p>'); echo('<p>Wachtwoord:'.$user->getWachtwoord().'<p>');?>
                    <input class="editInlogGegevens" id="editWachtwoord" type="password" placeholder="New Password" style="width: 300px; display:none;">
                </div>

                <div class="columns small-6">
                    <h5>Naam en geboortedatum</h5><hr>
                    <?php echo('<p>Naam: '.$user->getVoornaam().' '.$user->getAchternaam().'</p>');?>
                    <?php echo('<p>Geboortedatum: '.$user->getGeboortedatum().'</p>'); ?>
                </div>
            </div>
            <div class="row small-up-1 medium-up-2">
            <div class="columns small-6">
                <h5>Adres</h5><hr>
                    <button id="showAdres"  type="button" class="button tiny hollow">Edit</button>
                    <?php echo('<p>Provincie: '.$user->getProvincie().'</p>');
                    echo('<p>Plaats: '.$user->getPlaatsNaam().'</p>');
                    echo('<p>Straat :'.$user->getStraatnaam().' '.$user->getHuisnummer().'</p>');
                    ?>
                    <input class="editAdres" id="editProvincie" type="text" placeholder = "Provincie" style = "width: 300px;display:none;">
                    <input class="editAdres" id = "editPlaats" type="text" placeholder = "Plaats"  style = "width: 300px;display:none;">
                    <input class="editAdres" id = "editStraat" type="text" placeholder = "Straat"  style = "width: 300px;display:none;">
                    <input class="editAdres" id = "editHuisnummer" type="text" placeholder = "Huisnummer" style = "width: 300px;display:none;">
            </div>

            <div class="columns small-6">
                <h5>Jouw contact gegevens</h5><hr>
                <button  id="showContactgegevens"  type="button" class = "button hollow tiny">Edit</button>
                <?php echo('<p>Telefoonnummer: '.$user->getTelefoonnmr().'</p>'); ?>
                <input class="editContactgegevens" id = "editTelefoonnummer" type="text" placeholder = "Telefoonnmr" style = "width: 300px;display:none;">
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
                <?php
                    if($aantalLopendeBiedingen > 0){
                        echo('<p><strong>Titel: </strong>');
                        for($i = 0; $i < $aantalLopendeBiedingen; $i++){
                            echo($lopendeBiedingen['data'][$i]['titel']);
                        }
                    } else {
                        echo("Je hebt geen lopende biedingen.");
                    }

                     ?>
                <br>
                <?php
                    if($aantalLopendeBiedingen > 0) {
                        echo('<strong>Omschrijving: </strong>');
                        for ($i = 0; $i < $aantalLopendeBiedingen; $i++) {
                            echo($lopendeBiedingen['data'][$i]['beschrijving']);
                        }
                    }
                    ?>
                <br>
                <?php
                    if($aantalLopendeBiedingen > 0) {
                        echo('<strong> Bedrag: </strong>');
                        for ($i = 0; $i < $aantalLopendeBiedingen; $i++) {
                            echo($veilingidBiedingen['data'][$i]['biedingsBedrag']);
                        }
                    }
                    echo '<hr>';
                    ?>
                </p>
                <hr>
            </div>
            <div class="row">
                <h5>Gewonnen biedingen</h5>
                <?php
                    if($aantalGewonnenBiedingen > 0){
                        echo ('<p><strong>Titel: </strong>');
                        for($i = 0; $i < $aantalGewonnenBiedingen; $i++){
                            echo($gewonnenBiedingen['data'][$i]['titel']);
                        }
                    } else {
                        echo("Je hebt nog geen veiling gewonnen.");
                    }

                    ?>
                    <br>
                <?php
                    if($aantalGewonnenBiedingen > 0) {
                        echo('<strong>Omschrijving: </strong>') ;
                        for ($i = 0; $i < $aantalGewonnenBiedingen; $i++) {
                            echo($gewonnenBiedingen['data'][$i]['beschrijving']);
                        }
                    }
                    ?>
                    <br>
                <?php
                    if($aantalGewonnenBiedingen > 0) {
                        echo('<strong> Bedrag: </strong>');
                        for ($i = 0; $i < $aantalGewonnenBiedingen; $i++) {
                            echo($gewonnenBiedingen['data'][$i]['verkoopPrijs']);
                        }
                    }
                    echo '<hr>';
                    ?>
                </p>
                <hr>
            </div>
            <div class="row">
                <h5>Verlopen biedingen: </h5>
                <?php
                if($aantal > 0) {
                    echo('<strong> Bedrag: </strong>');
                for ($i = 0; $i < $aantalGewonnenBiedingen; $i++) {
                echo($verlopenBiedingen['data'][$i]['verkoopPrijs']);
                }
                }
                echo 'Je hebt geen verlopen biedingen.';
                ?>
            </div>
        </div>
        <div class="tabs-panel" id="advertenties">
            <h4>Advertenties</h4>
            <div class="row">
                <h5>Actieve advertenties</h5><hr>
                    <?php
                    if($aantalLopendeVeilingen > 0){
                        for($i =0; $i<$aantalLopendeVeilingen; $i++){
                            echo('<div><span><strong>Titel:</strong> ' . $openVeilingen['data'][$i]["titel"] . '</span><br><span><strong>Omschrijving:</strong> ' . $openVeilingen['data'][0]["beschrijving"] . '</span></div>');
                            echo '<hr>';
                        }
                    } else{
                        echo ('Je hebt nog geen actieve veilingen.');
                    }
                    ?>
            </div>
            <div class="row">
                <h5>Inactieve advertenties</h5><hr>
                <?php
                if($aantalVerlopenVeilingen > 0){
                    for($i =0; $i<$aantalVerlopenVeilingen; $i++){
                        echo('<div><span><strong>Titel:</strong> ' . $verlopenveilingen['data'][$i]["titel"] . '</span><br><span><strong>Omschrijving:</strong> ' . $verlopenveilingen['data'][0]["beschrijving"] . '</span><br><span><strong>Prijs:</strong> ' . $verlopenveilingen['data'][0]["verkoopPrijs"] . '</span></div>');
                        echo '<hr>';
                    }
                } else{
                    echo ('Je hebt nog geen verlopen veilingen.');
                }
                ?>
            </div>
        </div>
    </div>
</main>

<script>
   /* $("#showEditFormUser").click(function () {
        $('#editWachtwoord').show());
    });*/

    $('#showInlogGegevens').click(function(){
        $('.editInlogGegevens').css("display", "block");
    });
    $('#showPersoonsgegevens').click(function(){
        $('.editPersoonsgegevens').css("display", "block");
    });
    $('#showAdres').click(function(){
        $('.editAdres').css("display", "block");
    });
    $('#showContactgegevens').click(function(){
        $('.editContactgegevens').css("display", "block");
    });

    $('#submitChanges').click(function () {


        var userInfo = {
            NEWpassword: $('#editWachtwoord').val(),
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
</body>
</html>