<?php
include("php/core.php");
include("php/layout/header.php");
$pagename = 'Profiel';
include("php/layout/breadcrumbs.php");
error_reporting(E_ERROR | E_PARSE);

$gebruiker = new User($_SESSION['gebruiker']);

$verlopenBiedingen = executeQuery("SELECT * from veiling v, biedingen b where gebruikersnaam = ? and v.veilingid = b.veilingid AND veilingGestopt = 0 AND biedingsBedrag NOT IN(SELECT MAX(biedingsBedrag) AS 'Hoogste bod' FROM biedingen GROUP BY veilingId)", [$gebruiker->getGebruikersnaam()]);
$lopendeBiedingen = executeQuery("SELECT * from veiling v, biedingen b where gebruikersnaam = ? and v.veilingid = b.veilingid AND veilingGestopt = 0 AND b.biedingsBedrag IN(SELECT MAX(biedingsBedrag) AS 'Hoogste bod' FROM biedingen GROUP BY veilingId)", [$gebruiker->getGebruikersnaam()]);
$gewonnenBiedingen = executeQuery("SELECT * from veiling v, biedingen b where gebruikersnaam = ? and v.veilingid = b.veilingid AND veilingGestopt = 1 AND b.biedingsBedrag IN(SELECT MAX(biedingsBedrag) AS 'Hoogste bod' FROM biedingen GROUP BY veilingId)", [$gebruiker->getGebruikersnaam()]);

$openVeilingen = executeQuery("SELECT *  FROM veiling WHERE verkoperGebruikersnaam = ? AND veilingGestopt = 0", [$gebruiker->getGebruikersnaam()]);
$verlopenVeilingen = executeQuery("SELECT * from veiling where verkoperGebruikersnaam = ? AND veilingGestopt = 1", [$gebruiker->getGebruikersnaam()]);

function pasteStatus($typeStatus, $soort) {
    if (count($typeStatus['data']) > 0) {
        foreach ($typeStatus['data'] as $status) {
            echo('  
                <div class="column"><hr></div>
                <div class="columns small-3">
                    <img src="http://iproject34.icasites.nl/' . $status["thumbNail"] . '" alt="image">
                </div>

                <div class="columns small-5">
                    <p><strong>Titel: </strong>' . $status["titel"] . '</p>
            ');
            if ($soort == 1) {
                echo('<p><strong> Verkoper: </strong> ' . $status["verkoperGebruikersnaam"] . '</p >');
                } elseif ($soort == 3) {
                    echo('<p><strong>Beëindigd op: </strong>'.$status["eindDatum"].'</p>');
                } 
            echo('</div><div class="columns small-4">');
            if ($soort == 1) {
                echo('<p><strong>Bedrag: </strong>' . $status['biedingsBedrag'] . '</p>');
            } elseif ($soort == 2) {
                echo('<p><strong>Huidige bod: </strong>' . $status["startPrijs"] . '</p>');
            } elseif ($soort == 3) {
                echo('<p><strong>Verkocht voor: </strong>'.$status["verkoopPrijs"].'</p><p><strong>Gekocht door: </strong>'.$status["koperGebruikersnaam"].'</p>');
            }
            echo('</div>');
        }
    } else {
        echo('<div class="column"><hr><p><strong>Niets gevonden</strong></p></div>');
    }
}

if (!isset($_SESSION['gebruiker'])) {
    include("php/layout/geentoegang.html");
} else {
    ?>
    <main class="row profiel">
        <ul class="tabs" id="profieltabs" data-tabs>
            <li class="tabs-title is-active"><a href="#overzicht">Account instellingen</a></li>
            <li class="tabs-title"><a href="#biedingen">Mijn biedingen</a></li>
            <li class="tabs-title"><a href="#advertenties">Mijn advertenties</a></li>
        </ul>

        <div class="tabs-content" data-tabs-content="profieltabs" data-active-collapse="true">
            <div class="tabs-panel" id="overzicht">
                <form id="profielForm">
                <div class="row small-up-1 large-up-2">
                    <div class="columns small-6">
                        <fieldset class="fieldset">
                            <legend><h5>Gebruikersnaam en wachtwoord</h5></legend>

                            <button id="showInlogGegevens" type="button" class="tiny button hollow">Edit</button>

                            <?php
                            echo('<p id="gebruikersnaam"><strong>Gebruikersnaam: </strong>' . $gebruiker->getGebruikersnaam() . '</p>');
                            ?>
                            <p id="wachtwoord"><strong>Wachtwoord: </strong>********</p>

                            <div class="field editInlogGegevens">
                                <input id="oudWachtwoord" type="password" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$" maxlength="255" placeholder="Old Password">
                                <input id="editWachtwoord" maxlength="255" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$" type="text" placeholder="New Password">
                            </div>
                        </fieldset>
                    </div>

                    <div class="columns small-6">
                        <fieldset class="fieldset">
                            <legend><h5>Naam en geboortedatum</h5></legend>

                            <?php echo('<p id="Naam"><strong>Naam: </strong>' . $gebruiker->getVoornaam() . ' ' . $gebruiker->getAchternaam() . '</p>'); ?>
                            <?php echo('<p id="Geboortedatum"><strong>Geboortedatum: </strong>' . $gebruiker->getGeboortedatum() . '</p>'); ?>
                        </fieldset>
                    </div>
                </div>

                <div class="row small-up-1 large-up-2">
                    <div class="columns small-6">
                        <fieldset class="fieldset">
                            <legend><h5>Adres</h5></legend>

                            <button id="showAdres" type="button" class="button tiny hollow">Edit</button>

                            <?php
                            echo('<p id="Provincie"><strong>Provincie: </strong>' . $gebruiker->getProvincie() . '</p>');
                            echo('<p id="Plaats"><strong>Plaats: </strong>' . $gebruiker->getPlaatsnaam() . '</p>');
                            echo('<p id="Straat"><strong>Straat: </strong>' . $gebruiker->getStraatnaam() . '</p>');
                            echo('<p id="Huisnummer"><strong>Huisnummer: </strong>' . $gebruiker->getHuisnummer() . '</p>');
                            echo('<p id="Postcode"><strong>Postcode: </strong>' . $gebruiker->getPostcode() . '</p>');
                            ?>

                            <div class="field editAdres">
                                <input rel="Provincie" maxlength="255" id="editProvincie" type="text" placeholder="Provincie" pattern="[A-Za-z-' ]+">
                                <input rel="Plaats" maxlength="255" id="editPlaats" type="text" placeholder="Plaats" pattern="[a-zA-Z-' ]+">
                                <input rel="Straat" maxlength="255" id="editStraat" type="text" placeholder="Straat" pattern="[A-Za-z-' ]+">
                                <input rel="Huisnummer" maxlength="20" id="editHuisnummer" type="text" placeholder="Huisnummer" pattern="[0-9a-z]+">
                                <input rel="Postcode" id="editPostcode" maxlength="10" type="text" placeholder="Postcode" pattern="^[1-9][0-9]*[a-zA-Z]?">
                            </div>
                        </fieldset>
                    </div>

                    <div class="columns small-6">
                        <fieldset class="fieldset">
                            <legend><h5>Jouw contactgegevens</h5></legend>

                            <button id="showContactgegevens" type="button" class="button hollow tiny">Edit</button>

                            <?php echo('<p id="Telefoonnummer"><strong>Telefoonnummer: </strong>' . $gebruiker->getTelefoonnmr() . '</p>'); ?>

                            <input rel="Telefoonnummer" maxlength="20" class="field editContactgegevens" id="editTelefoonnummer"
                                   type="text" placeholder="Telefoonnmr" pattern="^\+?[0-9() ]+">
                        </fieldset>
                    </div>
                </div>
                <hr>
                <input type="submit" id="submitChanges" value="Sumbit" class="button large">
                </form>
            </div>

            <div class="tabs-panel" id="biedingen">
                <div class="row column">
                    <h4>Lopende biedingen</h4>
                </div>
                <div class="noMarginRow row">
                    <?php pasteStatus($lopendeBiedingen, 1); ?>
                </div>

                <div class="row column">
                    <h4>Verlopen biedingen</h4>
                </div>
                <div class="row noMarginRow">
                    <?php pasteStatus($verlopenBiedingen, 1); ?>
                </div>

                <div class="row column">
                    <h4>Gewonnen biedingen</h4>
                </div>
                <div class="noMarginRow row">
                    <?php pasteStatus($gewonnenBiedingen, 1); ?>
                </div>
            </div>

            <div class="tabs-panel" id="advertenties">
                <div class="row column">
                    <h4>Actieve advertenties</h4>
                </div>
                <div class="noMarginRow row">
                    <?php pasteStatus($openVeilingen, 2); ?>
                </div>

                <div class="row column">
                    <h4>Inactieve advertenties</h4>
                </div>
                <div class="noMarginRow row">
                    <?php pasteStatus($verlopenVeilingen, 3) ?>
                </div>
            </div>
        </div>
    </main>
    <?php
}
include("php/layout/footer.html");
?>
<script>
    $(document).ready(function() {
        var errorCSS = {
            "font-size": "70%",
            "margin-bottom": "0",
            "bottom": "0",
            "right": "0"
        };

        $('#profielForm').validate({
            submitHandler: function(){submitChanges()},
            errorPlacement: function(error, element) {
                error.insertBefore(element);
                error.addClass("hide-for-small show-for-large");
                error.css(errorCSS);
            }
        });

        $('#showInlogGegevens').click(function () {
            $('.editInlogGegevens').toggle(300);
        });
        $('#showAdres').click(function () {
            $('.editAdres').toggle(300);
        });
        $('#showContactgegevens').click(function () {
            $('.editContactgegevens').toggle(300);
        });

        function submitChanges() {
            var userInfo = {
                OLDpassword: $('#oudWachtwoord').val(),
                NEWpassword: $('#editWachtwoord').val(),
                NEWprovincie: $('#editProvincie').val(),
                NEWplaats: $('#editPlaats').val(),
                NEWstraat: $('#editStraat').val(),
                NEWhuisnummer: $('#editHuisnummer').val(),
                NEWtelefoonnummer: $('#editTelefoonnummer').val(),
                NEWpostcode: $('#editPostcode').val(),
            };

            $.ajax({
                type: 'POST',
                url: 'php/api.php?action=AanpassenGegevens',
                data: userInfo,
                success: function () {
                    alert("Je gegevens zijn succesvol verandert");

                    $.each($('#overzicht').find('input'), function () {
                        if ($(this).val() != "") {
                            $('#overzicht').find('p[id="' + $(this).attr('rel') + '"]').html('<p><strong>' + $(this).attr('rel') + ': </strong>' + $(this).val() + '</p>');

                        }
                    });
                }
            });
        }
    });
</script>
</body>
</html>