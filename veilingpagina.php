<?php
$pagename = "veiling";

include("php/core.php");
include("php/layout/header.php");


if(true){
    $veilingId = stripInput($_GET["veilingId"]);
    if(checkForEmpty($veilingId)){

        $veiling = new veiling($veilingId);
        $gebruiker = new User($veiling->getverkoperId());
    }
}
?>
<div class="veilingpagina">
<div class="row show-for-medium">
    <div class="column">
        <ul class="titel breadcrumbs">
            <li><a href="#">Home</a></li>
            <li><a href="#">Veilingen</a></li>
            <li class="current"><a href="#"><?php echo($veiling->getTitel()); ?></a></li>
        </ul>
    </div>
</div>
<div class="row">
    <div class="large-6 columns">
            <h1><strong><?php echo($veiling->getTitel()); ?></strong></h1>

            <h4 class="titel"><strong>Verkoper:</strong></h4>
            <h5><?php echo($gebruiker->getVoornaam()." ".$gebruiker->getAchternaam()); ?></h5>
            <h5 class="subheader"><?php echo($gebruiker->getProvincie()." - ".$gebruiker->getPlaatsnaam()); ?></h5>

            <h4 class="titel"><strong>Omschrijving:</strong></h4>
            <h5><?php echo($veiling->getBeschrijving()); ?></h5>
    </div>
    <div class="large-6 columns">
        <div class="veilingImage row">
            <div class="columns">
                <img id="image" class="thumbnail" src="http://placehold.it/300x300" height="450" width="450" alt="Image">
            </div>
        </div>
        <div class="altImages row large-up-4 small-up-4">
            <div class="column">
                <img id="image1" rel="image" class="thumbnail" src="http://placehold.it/300x300">
            </div>
            <div class="column">
                <img id="image2" rel="image" class="thumbnail" src="http://placehold.it/400x400">
            </div>
            <div class="column">
                <img id="image3" rel="image" class="thumbnail" src="http://placehold.it/500x500">
            </div>
            <div class="column">
                <img id="image4" rel="image" class="thumbnail" src="http://placehold.it/600x600">
            </div>
        </div>
        <div class="row">
            <div class="large-6 columns">
                <h4><strong>Verkoop Prijs:</strong></h4>
                <h5><?php echo("€".round($veiling->getVerkoopPrijs(), 2)); ?></h5>
                <h5 class="subheader"><?php echo("Excl. €".round($veiling->getVerzendKosten(), 2)." Verzendkosten"); ?></h5>
            </div>
            <div class="large-6 columns">
                <h4><strong>Hoogste bod:</strong></h4>
                <h5><?php echo("€".round($veiling->getStartPrijs())); ?></h5>
                <a href="#" class="button" style="width: 100%; margin: 5% 0;">Bieden</a>
            </div>
        </div>
    </div>
</div>
</div>

<?php include("php/layout/footer.php") ?>
