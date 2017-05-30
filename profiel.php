<?php
include("php/core.php");
include("php/layout/header.php");
$pagename = 'Persoongegevens';
include("php/layout/breadcrumbs.php");
error_reporting(E_ERROR | E_PARSE);
$gebruikersnaam = "admul";
$user = new User($gebruikersnaam);

$alleVerlopenVeilingen = executeQuery("SELECT veilingid FROM veiling where veilingGestopt = ?", [1]);
$openVeilingen = executeQuery("SELECT titel, startPrijs  FROM veiling WHERE verkoperGebruikersnaam = ? and veilingGestopt = ?", [$gebruikersnaam, 0]);
$lopendeBiedingen = executeQuery("SELECT titel,biedingsBedrag ,verkoperGebruikersnaam, verkoopPrijs, gebruikersnaam from veiling, biedingen  where gebruikersnaam = ? and veiling.veilingid = biedingen.veilingid", [$gebruikersnaam]);
$verlopenBiedingen = executeQuery("SELECT veilingId, biedingsBedrag, biedingsTijd from biedingen where veilingId = ? and gebruikersnaam = ?", [$alleVerlopenVeilingen['data']['veilingid'], $gebruikersnaam]);
$gewonnenBiedingen = executeQuery("SELECT titel, verkoperGebruikersnaam, verkoopPrijs from veiling where koperGebruikersnaam = ? and verkoopPrijs is not null ", [$gebruikersnaam]);
$verlopenveilingen = executeQuery("SELECT titel, verkoopPrijs, verkoperGebruikersnaam, eindDatum from veiling where verkoperGebruikersnaam = ? and veilingGestopt = ?", [$gebruikersnaam, 1]);
?>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" xmlns="http://www.w3.org/1999/html"
        xmlns="http://www.w3.org/1999/html"></script>
<main class="row columns">
    <ul class="tabs" id="profieltabs" data-tabs>
        <li class="tabs-title is-active"><a href="#overzicht">Overzicht</a></li>
        <li class="tabs-title"><a href="#biedingen">Mijn biedingen</a></li>
        <li class="tabs-title"><a href="#advertenties">Mijn advertenties</a></li>
    </ul>

    <div class="tabs-content" data-tabs-content="profieltabs" data-active-collapse="true">
        <div class="tabs-panel" id="overzicht">
            <h4>Algemene accountinstellingen</h4>
            <div class="row small-up-1 medium-up-2">

                <div class="columns small-6">
                    <h5>Gebruikersnaam en wachtwoord</h5>
                    <hr>
                    <button id="showInlogGegevens" type="button" class="button hollow tiny">Edit</button>
                    <?php echo('<p>Gebruikersnaam: ' . $user->getGebruikersnaam() . '</p>');
                    echo('<p>Wachtwoord: ********  <p>'); ?>
                    <input class="editInlogGegevens" id="oudWachtwoord" type="password" placeholder="Old Password"
                           style="width: 300px; display:none;">
                    <input class="editInlogGegevens" id="editWachtwoord" type="text" placeholder="New Password"
                           style="width: 300px; display:none;">
                </div>

                <div class="columns small-6">
                    <h5>Naam en geboortedatum</h5>
                    <hr>
                    <?php echo('<p>Naam: ' . $user->getVoornaam() . ' ' . $user->getAchternaam() . '</p>'); ?>
                    <?php echo('<p>Geboortedatum: ' . $user->getGeboortedatum() . '</p>'); ?>
                </div>
            </div>
            <div class="row small-up-1 medium-up-2">
                <div class="columns small-6">
                    <h5>Adres</h5>
                    <hr>
                    <button id="showAdres" type="button" class="button tiny hollow">Edit</button>
                    <?php echo('<p>Provincie: ' . $user->getProvincie() . '</p>');
                    echo('<p>Plaats: ' . $user->getPlaatsNaam() . '</p>');
                    echo('<p>Straat :' . $user->getStraatnaam() . ' ' . $user->getHuisnummer() . '</p>');
                    echo('<p>Postcode: ' . $user->getPostcode() . '</p>');
                    ?>
                    <input class="editAdres" id="editProvincie" type="text" placeholder="Provincie"
                           style="width: 300px;display:none;">
                    <input class="editAdres" id="editPlaats" type="text" placeholder="Plaats"
                           style="width: 300px;display:none;">
                    <input class="editAdres" id="editStraat" type="text" placeholder="Straat"
                           style="width: 300px;display:none;">
                    <input class="editAdres" id="editHuisnummer" type="text" placeholder="Huisnummer"
                           style="width: 300px;display:none;">
                    <input class="editAdres" id="editPostcode" type="text" placeholder="Postcode"
                           style="width: 300px;display:none;">
                </div>

                <div class="columns small-6">
                    <h5>Jouw contact gegevens</h5>
                    <hr>
                    <button id="showContactgegevens" type="button" class="button hollow tiny">Edit</button>
                    <?php echo('<p>Telefoonnummer: ' . $user->getTelefoonnmr() . '</p>'); ?>
                    <input class="editContactgegevens" id="editTelefoonnummer" type="text" placeholder="Telefoonnmr"
                           style="width: 300px;display:none;">
                </div>
            </div>
            <hr>
            <button type="button" id="submitChanges" class="button large">Submit Changes</button>
        </div>
        <?php //-------------------------------------------------------------------------------------------------------------------------------------------?>

        <div class="tabs-panel" id="biedingen">
            <h3>Biedingen</h3>
            <div class="row">
                <h4>Lopende biedingen</h4>
                <hr>
                <?php
                if(count($lopendeBiedingen['data']) > 0){
                foreach ($lopendeBiedingen['data'] as $value){ ?>
                <hr>
                <div class="columns small-3">
                    <?php
                    echo('<img id="image" src="');
                    echo('http://placehold.it/175x150');
                    echo('" alt="Image">');
                    ?>
                </div>
                <div class="columns small-5">
                    <?php
                    echo('<p><strong><h5>Titel: </strong>');
                    echo($value['titel']);
                    echo('<p><strong><h5>Verkoper</strong>: </strong>');
                    echo($value['verkoperGebruikersnaam']);

                    ?>
                </div>
                <div class="columns small-4"
                <?php
                echo('<p><strong><h5> Bedrag: </strong>');
                echo($value['biedingsBedrag']);
                ?>
            </div>
            <?php }
            }else {
                echo('<strong>Je hebt geen lopende biedingen</strong>');
            }?>
        </div>


        <div class="row">
            <h4>Verlopen biedingen</h4>
            <hr>
            <?php
            if(count($verlopenBiedingen['data']) > 0) {
                foreach ($verlopenBiedingen['data'] as $value) { ?>
                    <hr>
                    <div class="columns small-3">
                        <?php
                        echo('<img id="image" src="');
                        echo('http://placehold.it/175x150');
                        echo('" alt="Image">');
                        ?>
                    </div>

                    <div class="columns small-5">
                        <?php
                        echo('<p><strong><h5>Titel: </strong>');
                        echo($value['titel']);
                        echo('<p><strong><h5>Verkoper</strong>: </strong>');
                        echo($value['verkoperGebruikersnaam']);

                        ?>
                    </div>
                    <div class="columns small-4">
                        <?php
                        echo('<p><strong><h5> Bedrag: </strong>');
                        echo($value['biedingsBedrag']);
                        ?>
                        <br>
                    </div>
                    <?php
                }
            } else{
                echo('<strong>Je hebt geen verlopen biedingen</strong>');
            }
            ?>
    </div>
    <div class="row">
        <h4>Gewonnen biedingen</h4>
        <hr>
        <?php
        if(count($gewonnenBiedingen['data']) > 0) {
            foreach ($gewonnenBiedingen['data'] as $value) { ?>
                <hr>
                <div class="columns small-3">
                    <?php
                    echo('<img id="image" src="');
                    echo('http://placehold.it/175x150');
                    echo('" alt="Image">');
                    ?>
                </div>
                <div class="columns small-5">
                    <?php
                    echo('<p><strong><h5>Titel: </strong>');
                    echo($value['titel']);
                    echo('<p><strong><h5>Verkoper</strong>: </strong>');
                    echo($value['verkoperGebruikersnaam']);
                    ?>
                </div>
                <div class="columns small-4">
                    <?php
                    echo('<p><strong><h5> Bedrag: </strong>');
                    echo($value['verkoopPrijs']);


                    ?>
                </div>
            <?php }
        } else{
            echo('<strong>Je hebt nog geen veiling gewonnen</strong>');
        }
        ?>
    </div>
    </div>

    <?php //-------------------------------------------------------------------------------------------------------------------------------------------?>

    <div class="tabs-panel" id="advertenties">
        <div class="row">
            <h4>Actieve advertenties</h4>
            <hr>
            <?php
            if(count($openVeilingen['data']) > 0) {
                foreach ($openVeilingen['data'] as $value) { ?>
                    <hr>
                    <div class="small-3 columns">
                        <?php
                        echo('<img id="image" src="');
                        echo('http://placehold.it/175x150');
                        echo('" alt="Image">');
                        ?>
                    </div>
                    <div class="small-5 columns">
                        <?php
                        echo('<strong>Titel:</strong> ');
                        echo($value["titel"]);
                        ?>
                    </div>
                    <div class="columns small-4">
                        <?php
                        echo('<strong>Huidige bod:</strong>');
                        echo($value["startPrijs"]);
                        ?>
                        <br>
                    </div>
                <?php }
            } else{
                echo('<strong>Je hebt nog geen actieve advertenties</strong>');
            }?>
        </div>
    <div class="row">
        <h4>Inactieve advertenties</h4>
        <hr>
        <?php
        if(count($verlopenveilingen['data']) > 0){
        foreach($verlopenveilingen['data'] as $value) { ?>
            <hr>
            <div class="columns small-3 ">
                <?php
                echo('<img id="image" src="');
                echo('http://placehold.it/175x150');
                echo('" alt="Image">');
                ?>
            </div>
            <div class="columns small-5 ">
                <?php
                echo('<p><strong><h5>Titel:</strong> ');
                echo($value["titel"]);
                echo('<p><strong><h5>Beëindigd op:</strong> ');
                echo($value["eindDatum"]);
                ?>
            </div>
            <div class="columns small-4">
                <?php
                echo('<p><strong><h5> Verkoop Prijs: </strong>');
                echo($value['verkoopPrijs']);
                echo('<p><strong><h5> Koper: </strong>');
                echo($value["verkoperGebruikersnaam"]);
                ?>
            </div>
            <?php
        }
        } else{
            echo('<strong>Je hebt geen veilingen die verlopen zijn</strong>');
        }?>
    </div>
    </div>
    </div>
</main>


<script>
    /* $("#showEditFormUser").click(function () {
     $('#editWachtwoord').show());
     });*/

    $('#showInlogGegevens').click(function () {
        $('.editInlogGegevens').css("display", "block");
    });
    $('#showAdres').click(function () {
        $('.editAdres').css("display", "block");
    });
    $('#showContactgegevens').click(function () {
        $('.editContactgegevens').css("display", "block");
    });

    $('#submitChanges').click(function () {


        var userInfo = {
            OLDpassword: $('#oudWachtwoord').val(),
            NEWpassword: $('#editWachtwoord').val(),
            NEWprovincie: $('#editProvincie').val(),
            NEWplaats: $('#editPlaats').val(),
            NEWstraat: $('#editStraat').val(),
            NEWhuisnummer: $('#editHuisnummer').val(),
            NEWtelefoonnummer: $('#editTelefoonnummer').val(),
            NEWpostcode: $('#editPostcode').val()
        };

        console.log(userInfo);
        $.ajax({
            type: 'POST',
            url: 'php/api.php?action=AanpassenGegevens',
            data: userInfo,
            succes: alert("Je gegevens zijn succesvol verandert")
        });


    });
</script>


<?php
include("php/layout/footer.html")
?>
</body>
</html>