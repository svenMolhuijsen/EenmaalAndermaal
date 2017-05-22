<?php

include("php/core.php");
$veilingId = stripInput($_GET["veilingId"]);
if(checkForEmpty($veilingId)){

    $veiling = new veiling($veilingId);
    $verkoper = new User($veiling->getVerkoperEmail());
    $categorie = new Categorie($veiling->getCategorieId());

    $boden = executeQuery("SELECT * FROM biedingen WHERE veilingId = ? ORDER BY biedingsBedrag DESC", [$veiling->getVeilingId()]);

    //temp
    session_destroy();
    session_start();
    //$_SESSION['gebruiker'] = new User('test1@test1.nl');

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
};

$pagename = 'veilingPagina - '.$veiling->getTitel();

include("php/layout/header.php");

if($veiling->getCode() == 0){
include("php/layout/breadcrumbs.php");

?>
<hr>
<div class="veilingpagina">
<div class="row">
    <div class="columns">
        <h1><strong><?php echo($veiling->getTitel()); ?></strong></h1>
        <h5 class="subheader"><?php echo($verkoper->getVoornaam()." ".$verkoper->getAchternaam()." - ".$verkoper->getProvincie()." - ".$verkoper->getPlaatsnaam()); ?></h5><br>
    </div>
</div>
<div class="row">
    <div class="large-8 columns">
        <div class="veilingImage">
            <?php
            echo('<img id="image" src="');
            if(!is_null($images[0])){
                echo($imgdir.'\\'.$images[0]);
            }
            else{
                echo('http://placehold.it/450x450');
            }
            echo('" alt="Image">');
            ?>
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
        <hr>
        <h4><strong>Omschrijving:</strong></h4>
        <h5><?php echo($veiling->getBeschrijving()); ?></h5>
    </div>

    <hr class="hide-for-large">
    <div class="large-4 columns">
        <div class="card">
            <div class="card-divider">
                <h4><strong>Veiling eindigt over:</strong></h4>
                <span id="timer"></span><br>
            </div>

            <?php if(!$veiling->getVeilingGestopt()){ ?>
            <div id="expired">
            <?php if(isset($_SESSION['gebruiker']) && !empty($_SESSION['gebruiker'])){ ?>
                <input name="bedrag" id="bedrag" type="text" placeholder="bedrag">
                <input name="biedenKnop" id="biedenKnop" value="Bieden" type="submit" class="button biedKnop">
                <label class="is-invalid-label veilingError" id="bedragError">
                    U Kunt niet lager bieden dan het hoogste bod, biedt minstens: €
                    <?php
                    if($boden['code'] == 0){
                        echo(round($boden['data'][0]['biedingsBedrag']+bepaalBiedStap($boden['data'][0]['biedingsBedrag']), 2));
                    }
                    else if($boden['code'] == 1){
                        echo(round($veiling->getStartPrijs()+bepaalBiedStap($veiling->getStartPrijs()), 2));
                    }
                    ?>
                </label>
                <label class="is-invalid-label veilingError" id="biedenError">U heeft al het hoogste bod.</label>
            <?php } else{ ?>
                <p class="callout warning" style="margin: 1% 0;">U bent niet ingelogd, log in om te bieden.</p>
                <input name="loginKnop" value="Login" type="submit" id="loginKnop" class="login_button button biedKnop"">
            <?php } ?>
            </div>
            <?php } ?>
            <table class="card-section biedingen">
                <?php
                    if($boden['code'] == 0) {
                        for ($i = 0; $i < count($boden['data']); $i++) {
                            echo('
                        <tr>
                            <td>' . $boden['data'][$i]["email"] . '</td>
                            <td>€' . $boden['data'][$i]["biedingsBedrag"] . '</td>
                            <td>' . substr_replace(date("d-m-Y", strtotime(substr($boden['data'][$i]["biedingsTijd"], 0, 10))), "", 6, 2) . '</td>
                        </tr>
                        ');
                        }
                    }
                    echo('<tr><td>Startprijs</td><td>€'.$veiling->getStartPrijs().'</td><td>'.substr_replace(date("d-m-Y", strtotime(substr($veiling->getBeginDatum(), 0, 10))), "", 6, 2).'</td></tr>');
                ?>
            </table>
        </div>
    </div>
</div>
</div>
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
<script>
$(document).ready(function(){
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
        var response;
        var veilingid = "<?php $veiling->getVeilingId();?>";
        var url = "php/api.php?action=sluitVeiling";
        var data = {veilingId: veilingId};

        $.ajax({
            url: url,
            data: data,
            type:"POST",
            dataType:'JSON',
            async:false,
            success: function(result){
                response = $.parseJSON(result);
            }
        });
        return response;
    }


    //
    //Bieden related
    //
    var veilingId = $(location).attr('href').substring($(location).attr('href').indexOf('=') + 1);
    var veiling;
    var gebruiker;
    var data = { veilingId: veilingId };

    $.ajax({
        url: 'php/api.php?action=getVeilingInfo',
        data: data,
        type: 'post',
        dataType: 'json',
        success: function(result) {
            gebruiker = result.gebruiker;
            veiling = result.veiling.data[0];
        }
    });

    $biedenKnop = $('#biedenKnop');
    $bedrag = $('#bedrag');

    $biedingen = $('.biedingen');

    $biedenError = $('#biedenError');
    $bedragError = $('#bedragError');

    $biedenKnop.on('click', function(){
        checkHoogsteBod(veiling["veilingId"]);
    });

    function checkHoogsteBod(veilingId, bedrag){
        var response;
        var url = "php/api.php?action=biedingCheck";
        var data = {
            veilingId: veilingId
        };

        $.ajax({
            url: url,
            data: data,
            type: 'POST',
            dataType: 'json',
            success: function(result) {
                biedAttempt(result);
            }
        });
    }

    function biedAttempt(hoogsteBod){
        var biedDrempel;
        if(hoogsteBod.code == 0) {
            biedDrempel = Number(hoogsteBod.data[0].biedingsBedrag) + bepaalBiedStap(hoogsteBod.data[0].biedingsBedrag);
        }
        else if(hoogsteBod.code == 1){
            biedDrempel = Number(veiling["startPrijs"]) + bepaalBiedStap(veiling["startPrijs"]);
        }

        var now = new Date($.now());
        var biedingsTijd = now.getFullYear() + "-" + (now.getMonth() + 1) + "-" + now.getDate() + " " + now.getHours() + ":" + now.getMinutes() + ":" + now.getSeconds() + "." + now.getMilliseconds();

        var bod = { veilingId: veiling["veilingId"], email: gebruiker.email,  biedingsTijd: biedingsTijd, biedingsBedrag: Math.round($bedrag.val()*100)/100 };

        if(hoogsteBod.code == 1 || bod['email'] != hoogsteBod.data[0]["email"]) {
            $biedenError.hide();
            console.log(gebruiker);
            if (bod.biedingsBedrag > biedDrempel) {

                $.post("php/api.php?action=bieden", bod);

                hoogsteBod = bod;
                biedDrempel = Number(hoogsteBod.biedingsBedrag) + bepaalBiedStap(hoogsteBod.biedingsBedrag);

                var dateString = ("0"+(now.getDate().toString())).slice(-2)+'-'+("0"+(now.getMonth()+1)).toString().slice(-2)+'-'+now.getFullYear().toString().substring(2);
                $biedingen.prepend('<tr><td>'+bod.email+'</td><td>€'+bod.biedingsBedrag+'</td><td>'+dateString+'</td></tr>');
                $bedragError.html('U Kunt niet lager bieden dan het hoogste bod, biedt minstens: €' + biedDrempel);
                $bedragError.hide();
                $bedrag.removeClass('is-invalid-input');
            }
            else {
                $bedragError.show();
                $bedrag.addClass('is-invalid-input');
            }
        }
        else{
            $biedenError.show();
        }
    }

    function bepaalBiedStap(hoogsteBedrag){
        if(hoogsteBedrag > 50){
            if(hoogsteBedrag > 500){
                if(hoogsteBedrag > 1000){
                    return 50;
                }
                return 5;
            }
            return 1;
        }
        return 0.5;
    }
});
</script>
</body>
</html>
