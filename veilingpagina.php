<?php

include("php/core.php");
if(true){
    $veilingId = stripInput($_GET["veilingId"]);
    if(checkForEmpty($veilingId)){

        $veiling = new veiling($veilingId);
        $verkoper = new User($veiling->getVerkoperEmail());
        $categorie = new Categorie($veiling->getCategorieId());

        $hoogsteBod = executeQuery("SELECT TOP 1 * FROM biedingen WHERE veilingId = ? ORDER BY biedingsBedrag DESC", [$veiling->getVeilingId()]);
        if($hoogsteBod['code'] == 0){
            $hoogsteBod = $hoogsteBod['data'][0];
        }
        else if($hoogsteBod['code'] == 1){
            $hoogsteBod = $veiling->getStartPrijs();
        }
        else{
            var_dump($hoogsteBod);
        }

        //temp
        session_destroy();
        session_start();
        $_SESSION['gebruiker'] = new User('test1@test1.nl');

        $imgdir = 'img/placeholder';
        $imagesRough = scandir($imgdir);

        for($i = 0; $i < count($imagesRough); $i++){
            if($imagesRough[$i] == '.' || $imagesRough[$i] == '..'){
                unset($imagesRough[$i]);
            }
        }

        $images = array_values($imagesRough);

        function bepaalBiedStap($hoogsteBedrag){
            if($hoogsteBedrag > 50){
                if($hoogsteBedrag > 500){
                    if($hoogsteBedrag > 1000){
                        return 50;
                    }
                    return 5;
                }
                return 1;
            }
            return 0.5;
        }
    }
};

$pagename = $veiling->getTitel();

include("php/layout/header.php");

if($veiling->getCode() == 0){
include("php/layout/breadcrumbs.php");

?>
<div class="veilingpagina">
<div class="row">
    <div class="large-6 columns">
            <h1><strong><?php echo($veiling->getTitel()); ?></strong></h1>
            <h5 class="subheader"><?php echo($categorie->getCategorieNaam());?></h5><br>

            <h4 class="titel"><strong>Verkoper:</strong></h4>
            <h5><?php echo($verkoper->getVoornaam()." ".$verkoper->getAchternaam()); ?></h5>
            <h5 class="subheader"><?php echo($verkoper->getProvincie()." - ".$verkoper->getPlaatsnaam()); ?></h5><br>

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
        <div class="altImages row small-up-4">
            <?php
            for($i = 1; $i < count($images) && $i < 5; $i++){
                echo('<div class="column">');
                echo('<img id="image'.$i.'" rel="image" class="thumbnail" src="'.$imgdir.'\\'.$images[$i].'" alt="altImage">');
                echo('</div>');
            }
            ?>
        </div>
        <div class="row">
            <div class="columns">
                <h4><strong>Einddatum:</strong></h4>
                <h5><?php echo($veiling->getEindDatum());?></h5><br>
                <h4><strong>Veiling eindigt over:</strong></h4>
                <span id="timer"></span><br>
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
                <h5 id="hoogsteBedrag">
                    <?php
                    echo("€");
                    if(is_array($hoogsteBod)){
                        echo(round($hoogsteBod['biedingsBedrag'], 2));
                    }
                    else{
                        echo(round($hoogsteBod, 2));
                    }
                    ?>
                </h5>
                <div id="expired">
                    <input name="bedrag" id="bedrag" type="text" placeholder="bedrag">
                    <label class="is-invalid-label veilingError" id="bedragError">
                        U Kunt niet lager bieden dan het hoogste bod, biedt minstens: €
                        <?php
                        if(is_array($hoogsteBod)){
                            echo(round($hoogsteBod['biedingsBedrag']+bepaalBiedStap($hoogsteBod['biedingsBedrag']), 2));
                        }
                        else{
                            echo(round($hoogsteBod+bepaalBiedStap($hoogsteBod), 2));
                        }
                        ?>
                    </label>
                    <label class="is-invalid-label veilingError" id="biedenError">U heeft al het hoogste bod.</label>
                    <input name="biedenKnop" id="biedenKnop" value="Bieden" type="submit" class="button" style="width: 100%; margin: 5% 0;">
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script>
    //
    //Timer related
    //
    var eindDatum = "<?php echo($veiling->getEindDatum())?>";
    // Set the date we're counting down to
    var countDownDate = new Date(eindDatum).getTime();

    // Update the count down every 1 second
    var x = setInterval(function() {

        // Get todays date and time
        var now = new Date().getTime();

        // Find the distance between now an the count down date
        var distance = countDownDate - now;

        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Output the result in an element with id="timer"
        document.getElementById("timer").innerHTML = days + "d " + hours + "h "
            + minutes + "m " + seconds + "s ";

        // If the count down is over, write some text
        if (distance < 0) {
            clearInterval(x);
            document.getElementById("timer").innerHTML = "EXPIRED";
            document.getElementById("expired").innerHTML = "";
            sentEmail();
        }
    }, 1000);

    function sentEmail(){
        var veilingid = "<?php $veiling->getVeilingId();?>";

        $.ajax({
            url:"api.php",
            type:"post",
            data:{veilingId: veilingid}
        })
    }
</script>
<?php
}
else{
?>
<div class="row">
    <div class="small-12 columns">
        <div class="callout alert">
            <h5>Geen veiling gevonden</h5>
            <p>Ga terug en probeer het opnieuw</p>
        </div>
    </div>
</div>
<?php
}
include("php/layout/footer.php");

?>

