<?php
$pagename = "Aanmakenveiling";

include("php/core.php");
include("php/layout/header.php");
include("php/layout/breadcrumbs.php");

//$verkoper = false;
//if(! $_SESSION["gebruiker"]->getVerkoper()){
    //header('Location: http://localhost/EenmaalAndermaal/index.php');
    //exit();
//}

?>
<main>
    <div class="aanmakenveiling">
    <div class="row column">
        <h1><strong>Aanmaken veiling</strong></h1>
    </div>
    <hr>
    <form action="php/api.php?action=MaakVeilingAan" method="post">
        <div class="row">
            <div class="large-6 columns float-left">
                <h4><strong>Titel</strong></h4>
                <input id="titel" name="titel" type="text" placeholder="Titel" pattern="[A-Za-z]" />

                <h4 class="titel"><strong>Prijs</strong></h4>
                <input id="prijs" name="startprijs" type="number" placeholder="Prijs" pattern="[0-9]"/>

                <h4 class="titel"><strong>Einddatum van de veiling</strong></h4>
                <input title="einddatum" id="einddatum" name="einddatum" type="date" pattern="[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])" min="<?php date(); ?>">
            </div>
            <div class="large-6 columns float-right">
                <h4><strong>Omschrijving</strong></h4>
                <textarea id="omschrijving" name="text" placeholder="Omschrijving" type="text"></textarea>

                <h4 class="titel"><strong>Conditie</strong></h4>
                <input id="conditie" name="conditie" placeholder="Conditie" pattern="[A-Za-z]" type="text"/>

                <h4 class="titel"><strong>Categorie</strong></h4>
                <div id="categorie">
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="large-6 columns float-left">
                <form action="php/functions/upload.php" method="post" enctype="multipart/form-data">
                    <label for="hoofdfoto" class="button">Upload je Hoofdfoto</label>
                    <input type="file" id="hoofdfoto" class="show-for-sr" onchange="readURL1(this);">
                </form>
            </div>
        </div>
        <div class="row">
            <div class="large-6 columns float-left"
                <img id="Hoofdfoto" src="#" alt="Uw Afbeelding"/>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="large-6 columns float-left">
                <fieldset class="fieldset">
                <legend><strong>Verkoopadres</strong></legend>
                <div class="row">
                    <div class="large-6 columns">
                        <h5>Straat</h5>
                        <input id="straat" name="straat" type="text" placeholder="Straat" pattern="[A-Za-z]"/>

                        <h5 class="titel">Plaats</h5>
                        <input id="plaats" name="plaats" type="text" placeholder="Plaats" pattern="[A-Za-z]"/>

                        <h5 class="titel">Land</h5>
                        <select title="land" name="land" id="land">
                            <?php
                            $landen= executeQuery("SELECT land FROM landen"); //alle waardes uit de tabel komt in landen[]
                            for($i=0; $i< count($landen['data']) ; $i++){ //i is kleiner dan aantal landen
                                $land = $landen['data'][$i]; //pompt de huidige waarde van landen[i] in land
                                echo('<option value= '.$land["land"]. '>'.$land["land"].'</option>');
                            }
                            ?>
                        </select>
                    </div>
                    <div class="large-6 columns">
                        <h5>Huisnummer</h5>
                        <input id="huisnummer" name="huisnummer" type="text" placeholder="Huisnummer" pattern="[0-9]"/>

                        <h5 class="titel">Provincie</h5>
                        <input id="provincie" name="provincie" type="text" placeholder="Provincie" pattern="[A-Za-z]"/>

                        <h5 class="titel">Postcode</h5>
                        <input id="postcode" name="postcode" type="text" placeholder="Postcode" pattern="[1-9][0-9]{3}\s?[a-zA-Z]{2}"/>
                    </div>
                </div>
                </fieldset>
            </div>
        </div>
        <div class="row column">
            <input id="add-Veiling" class = "button large" type="submit" value="Start je veiling">
        </div>
    </form>
</main>
<?php
include("php/layout/footer.php");
?>
<script>

    function readURL1(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#Hoofdfoto')
                    .attr('src', e.target.result)
                    .width(200)
                    .height(250);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    $('#add-Veiling').click(function () { //als je op de knop drukt voert ajax de executequerry uit

        var veiling = {
            titel: $('#titel').val(),
            beschrijving: $('#omschrijving').val(),
            categorieId: $('#categorie').children().last().prev().find(":selected").val(),
            postcode: $('#postcode').val(),
            land: $('#land').val(),
            startPrijs: $('#prijs').val(),
            verkoopPrijs: null,
            provincie: $('#provincie').val(),
            plaatsnaam: $('#plaats').val(),
            straatnaam: $('#straat').val(),
            huisnummer: $('#huisnummer').val(),
            betalingswijze: 'IDEAL',
            verzendwijze: 'POSTNL',
            eindDatum: $('#einddatum').val(),
            conditie: $('#conditie').val(),
            thumbNail: null
        };

        $.ajax({
            type: 'POST',
            url: 'php/api.php?action=MaakVeilingAan',
            data: veiling,
            dataType: 'json',
            complete: function(){
                alert('Veiling toevoegen geslaagd!');
            }
            }
        });
    });
</script>
</body>
</html>
