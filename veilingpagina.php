<?php
include("php/core.php");

$veilingId = $_GET["veilingId"];

if (!empty($veilingId)){

    //laad veiling info
    $veiling = Veiling::existingVeiling($veilingId);

//check om te kijken of er een veiling is gevonden
if ($veiling->getCode() == 0){
    //haal de info van de verkoper op
    $verkoper = new User($veiling->getVerkoperGebruikersnaam());

    //boden laden
    $boden = executeQuery("SELECT * FROM biedingen WHERE veilingId = ? ORDER BY biedingsBedrag DESC", [$veiling->getVeilingId()]);

    //images laden
    $images = executeQuery("SELECT fotoPath FROM veilingFoto WHERE veilingId = ?", [$veiling->getVeilingId()]);

    if ($images['code'] == 0) {
        $images = $images["data"];
    } else {
        var_dump($images);
    }

    //bepaald de tussensprong tussen 2 biedingen
    function bepaalBiedStap($hoogsteBedrag){
        if ($hoogsteBedrag > 50) {
            if ($hoogsteBedrag > 500) {
                if ($hoogsteBedrag > 1000) {
                    return 50;
                }
                return 5;
            }
            return 1;
        }
        return 0.5;
    }

    //pagina naam voor de titel
    $pagename = 'veilingPagina - '.$veiling->getTitel();

    //header
    include("php/layout/header.php");

    //zet de veiling in de watchistory van de gebruiker
    if (isset($_SESSION['gebruiker'])) {
        executeQueryNoFetch("INSERT INTO history VALUES(?, ?, GETDATE())", [$veiling->getVeilingId(), $_SESSION['gebruiker']]);
    } else {
        executeQueryNoFetch("INSERT INTO history VALUES(?, NULL, GETDATE())", [$veiling->getVeilingId()]);
    }

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
        <!-- grote image -->
        <div class="veilingImage">
            <?php
            echo('<img id="image" src="');
            if (!is_null($images[0])) {
                echo("http://iproject34.icasites.nl/".$images[0]['fotoPath']);
            } else {
                echo('http://placehold.it/450x450');
            } echo('"alt="Image">');
            ?>
        </div>

        <!-- kleine images -->
        <div class="altImages row small-up-4">
            <?php
            for ($i = 1; $i < count($images) && $i < 5; $i++) {
                echo('<div class="column">');
                echo('<img id="image'.$i.'" rel="image" class="thumbnail" src="http://iproject34.icasites.nl/'.$images[$i]['fotoPath'].'" alt="altImage">');
                echo('</div>');
            }
            ?>
        </div>
        <hr>
        <!-- Omschrijving -->
        <h4><strong>Omschrijving:</strong></h4>
        <h5><?php echo($veiling->getBeschrijving()); ?></h5>
    </div>

    <hr class="hide-for-large">
    <div class="large-4 columns">
        <!-- bieding venster -->
        <div class="card">
            <div class="card-divider">
                <h4><strong>Veiling eindigt over:</strong></h4>
                <span id="timer"></span><br>
            </div>

            <?php if (!$veiling->getVeilingGestopt()) { ?>
            <div id="expired">
            <?php if (isset($_SESSION['gebruiker']) && !empty($_SESSION['gebruiker'])) { ?>
                <input name="bedrag" id="bedrag" type="text" maxlength="18" placeholder="bedrag">
                <input name="biedenKnop" id="biedenKnop" value="Bieden" type="submit" class="button biedKnop">

                <!-- Bieding errors -->
                <label class="is-invalid-label veilingError" id="bedragError">
                    U Kunt niet lager bieden dan het hoogste bod, biedt minstens: €
                    <?php
                    if ($boden['code'] == 0) {
                        echo(round($boden['data'][0]['biedingsBedrag']+bepaalBiedStap($boden['data'][0]['biedingsBedrag']), 2));
                    } else if ($boden['code'] == 1) {
                        echo(round($veiling->getStartPrijs()+bepaalBiedStap($veiling->getStartPrijs()), 2));
                    }
                    ?>
                </label>
                <label class="is-invalid-label veilingError" id="biedenError">U heeft al het hoogste bod.</label>
                <label class="is-invalid-label veilingError" id="verkoperError">U mag niet op uw eigen veiling bieden.</label>
            <?php } else { ?>
                <!-- login check -->
                <p class="callout warning" style="margin: 1% 0;">U bent niet ingelogd, log in om te bieden.</p>
                <input name="loginKnop" value="Login" type="submit" id="loginKnop" class="login_button button biedKnop">
            <?php } ?>
            </div>
            <?php } ?>
            <!-- Huidige boden -->
            <table class="card-section biedingen">
                <?php
                    if ($boden['code'] == 0) {
                        for ($i = 0; $i < count($boden['data']); $i++) {
                            echo('
                        <tr>
                            <td>' . $boden['data'][$i]["gebruikersnaam"] . '</td>
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
//Voor wanneer de veiling niet laad of bestaat
} else{
    $pagename = "veilingpagina";
    include('php/layout/header.php');
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
}
include("php/layout/footer.html");
?>
<script>
$(document).ready(function(){
    ///////////////////////////////////////////////
    //Timer related
    ////////////////////////////////////////
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
            document.getElementById("timer").innerHTML = "VERLOPEN";
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


    //////////////////////////////////////////////
    //Bieden related
    /////////////////////////////////////////////
    var veilingId = $(location).attr('href').substring($(location).attr('href').indexOf('=') + 1);
    var veiling;
    var gebruiker;
    var data = { veilingId: veilingId };

    //Pak de veiling info en de hoogste bieder
    $.ajax({
        url: 'php/api.php?action=getBiedingInfo',
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
    $verkoperError = $('#verkoperError');

    //Check het hoogste bod telkens wanneer er een bod wordt gemaakt
    $biedenKnop.on('click', function(){
        checkHoogsteBod(veiling["veilingId"]);
    });

    /**
     * @param veilingId VeilingId
     * @param bedrag int bedrag
     */
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

    /**
     * @param hoogsteBod Het hoogste bod
     */
    function biedAttempt(hoogsteBod){
        //Stel de bied-drempel in
        var biedDrempel;
        if(hoogsteBod.code == 0) {
            biedDrempel = Number(hoogsteBod.data[0].biedingsBedrag) + bepaalBiedStap(hoogsteBod.data[0].biedingsBedrag);
        }
        else if(hoogsteBod.code == 1){
            biedDrempel = Number(veiling["startPrijs"]) + bepaalBiedStap(veiling["startPrijs"]);
        }

        //Geef de huidige tijd mee
        var now = new Date($.now());
        var biedingsTijd = now.getFullYear() + "-" + (now.getMonth() + 1) + "-" + now.getDate() + " " + now.getHours() + ":" + now.getMinutes() + ":" + now.getSeconds() + "." + now.getMilliseconds();
        //Alle informatie van het bod
        var bod = { veilingId: veiling["veilingId"], gebruikersnaam: gebruiker,  biedingsTijd: biedingsTijd, biedingsBedrag: Math.round($bedrag.val()*100)/100 };
        //Kijk of de gebruiker niet al het hoogste bod heeft
        if(hoogsteBod.code == 1 || bod['gebruikersnaam'] != hoogsteBod.data[0]["gebruikersnaam"]) {
            if(bod['gebruikersnaam'] != veiling['verkoperGebruikersnaam']) {
                $biedenError.hide();
                $verkoperError.hide();

                //Kijk of het bod hoger is dan de biedrempel
                if (bod.biedingsBedrag > biedDrempel) {

                    //Bied
                    $.post("php/api.php?action=bieden", bod);

                    //Update het nieuwe hoogste bod
                    hoogsteBod = bod;
                    //Update de bied-drempel
                    biedDrempel = Number(hoogsteBod.biedingsBedrag) + bepaalBiedStap(hoogsteBod.biedingsBedrag);

                    var dateString = ("0" + (now.getDate().toString())).slice(-2) + '-' + ("0" + (now.getMonth() + 1)).toString().slice(-2) + '-' + now.getFullYear().toString().substring(2);
                    $biedingen.prepend('<tr><td>' + bod.gebruikersnaam + '</td><td>€' + bod.biedingsBedrag + '</td><td>' + dateString + '</td></tr>');
                    $bedragError.html('U Kunt niet lager bieden dan het hoogste bod, biedt minstens: €' + biedDrempel);
                    $bedragError.hide();
                    $bedrag.removeClass('is-invalid-input');
                } else {
                    $bedragError.show();
                    $bedrag.addClass('is-invalid-input');
                }
            } else {
                $verkoperError.show();
                $bedrag.addClass('is-invalid-input');
            }
        } else{
            $biedenError.show();
        }
    }

    //Bepaal de stappen tussen 2 boden.
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

//////////////////////////////////////////////
//  Image gallery
/////////////////////////////////////////////

//Grote image van het product
$bigImage = $('.veilingImage #image');

var isBusy = false;

//Wisselt de grote image met een alt image via fades
$('.altImages .column img').on('click', function () {
    if(!isBusy) {
        isBusy = true;
        var imageToShow = $(this).attr('src');
        var fadeLength = 300;

        $(this).fadeOut(fadeLength, function () {
            $(this).attr('src', $bigImage.attr('src'));
            $bigImage.attr('src', imageToShow);
            $(this).fadeIn(fadeLength);
        });

        $bigImage.fadeOut(fadeLength, function () {
            $(this).fadeIn(fadeLength, function(){isBusy = false;});
        });
    }
});
</script>
</body>
</html>