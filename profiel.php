<?php
include("php/core.php");
include("php/layout/header.php");
$pagename = 'Persoongegevens';
include("php/layout/breadcrumbs.php");

$gebruikersnaam = "0815nooob";
$user  = new User($gebruikersnaam);
$openVeilingen = executeQuery("SELECT titel FROM veiling WHERE verkoperGebruikersnaam = ?", [$gebruikersnaam]);

?>

    <main class="row">
        <ul class="tabs" id="profieltabs" data-tabs>
            <li class="tabs-title is-active"><a href="#overzicht">Overzicht</a></li>
            <li class="tabs-title"><a href="#biedingen">Mijn biedingen</a></li>
            <li class="tabs-title"><a href="#advertenties">Mijn advertenties</a></li>
        </ul>

        <div class="tabs-content" data-tabs-content="profieltabs" data-active-collapse="true">
            <div class="tabs-panel" id="overzicht">
                <div class="row expanded">
                    <h4><strong>Algemene accountinstellingen</strong></h4>
                    <hr>
                        <h5><strong>Gebruikersnaam en wachtwoord</strong></h5>
                        <p>Gebruikersnaam: <?php echo($user->getGebruikersnaam());?>
                        <br>
                        Wachtwoord:
                            <?php echo($user->getWachtwoord());
                            ?>
                        </p>
                    </div>
                <div class="row expanded">
                    <h5><strong>Naam en geboortedatum</strong></h5>
                    <p> Naam:
                        <?php echo($user->getVoornaam()." ".$user->getAchternaam())?>
                    <br>
                        Geboortedatum:
                        <?php echo($user->getGeboortedatum()) ?>
                    </p>
                </div>
                    <div class="row expanded">
                    <h5><strong>Adres</strong></h5>
                    <p> Land: <?php echo($user->getLand());?>
                        <br>
                        Provincie: <?php echo($user->getProvincie())?>
                        <br>
                        Plaats: <?php echo($user->getPlaatsnaam())?>
                        <br>
                        Straat: <?php echo ($user->getStraatnaam())?>
                        <br>
                        Huisnummer: <?php echo ($user->getHuisnummer())?>
                    </p>
                </div>
                <div class="row expanded">
                    <h5><strong>Jouw contact gegevens</strong></h5>
                    <p>Telefoon nummer: <?php echo($user->getTelefoonnmr())?></p>
                </div>

                <div class="row expanded">
                    <h4><strong>Mijn Betaal gegevens</strong></h4>
                    <h5>Get betaal</h5>
                    <p>NL 35 INGB 0004 5712 32</p>
                </div>
            </div>
            <div class="tabs-panel" id="biedingen">
                <div class="row expanded">
                    <h4><strong>Mijn biedingen</strong></h4>
                    <hr>
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
                <div class="row expanded">
                    <h4><strong>Mijn advertenties</strong></h4>
                    <hr>
                    <p> Je actieve veilingen:
                       <br> <?php echo($openVeilingen['data'][1]["titel"]);?>
                    <br>
                    <?php echo($openVeilingen['data'][1]["titel"]);?>
                    </p>
                </div>
            </div>

        </div>
    </main>


<?php
include("php/layout/footer.php")
?>