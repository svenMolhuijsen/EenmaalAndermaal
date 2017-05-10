<?php

include("php/core.php");
if(true){
    $veilingId = stripInput($_GET["veilingId"]);
    if(checkForEmpty($veilingId)){

        $veiling = new veiling($veilingId);
        $gebruiker = new User($veiling->getVerkoperEmail());

        $imgdir = 'img/placeholder';
        $imagesRough = scandir($imgdir);

        for($i = 0; $i < count($imagesRough); $i++){
            if($imagesRough[$i] == '.' || $imagesRough[$i] == '..'){
                unset($imagesRough[$i]);
            }
        }

        $images = array_values($imagesRough);
    }
};

$pagename = $veiling->getTitel();

include("php/layout/header.php");
include("php/layout/breadcrumbs.php");
?>

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
                <?php
                echo('<img id="image" class="thumbnail" src="');
                if(!is_null($images[0])){
                    echo($imgdir.'\\'.$images[0]);
                }
                else{
                    echo('http://placehold.it/450x450');
                }
                echo('" height="450" width="450" alt="Image">');
                ?>
            </div>
        </div>
        <div class="altImages row large-up-4 small-up-4">
            <?php
            for($i = 1; $i < count($images) && $i < 5; $i++){
                echo('<div class="column">');
                echo('<img id="image'.$i.'" rel="image" class="thumbnail" src="'.$imgdir.'\\'.$images[$i].'">');
                echo('</div>');
            }
            ?>
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

<?php include("php/layout/footer.php") ?>