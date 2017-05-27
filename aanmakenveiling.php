<?php
$pagename = "Aanmakenveiling";

include("php/core.php");
include("php/layout/header.php");
include("php/layout/breadcrumbs.php");

$_SESSION['gebruiker'] = new User("((marion))");
?>
<main>
    <div class="aanmakenveiling">
    <div class="row column">
        <h1><strong>Aanmaken veiling</strong></h1>
    </div>
    <hr>
    <form id="veilingForm">
        <div class="row">
            <div class="large-6 columns float-left">
                <h4><strong>Titel</strong></h4>
                <input id="titel" name="titel" type="text" placeholder="Titel" pattern="[A-Za-z0-9]+" required/>

                <h4><strong>Prijs</strong></h4>
                <input id="prijs" name="startprijs" type="number" placeholder="Prijs" pattern="[0-9]+" required/>

                <h4><strong>Einddatum van de veiling</strong></h4>
                <input id="einddatum" name="einddatum" type="date" placeholder="Einddatum" required/>

                <h4><strong>Conditie</strong></h4>
                <select title="conditie" name="conditie" id="conditie">
                    <option value="" selected disabled>Kies een conditie</option>
                    <?php
                    $condities= executeQuery("SELECT distinct conditie FROM veiling WHERE conditie != ''");
                    for($i = 0; $i < count($condities['data']) ; $i++){
                        $conditie = $condities['data'][$i];
                        echo('<option value= '.$conditie["conditie"]. '>'.$conditie["conditie"].'</option>');
                    }
                    ?>
                </select>

                <h4><strong>Categorie</strong></h4>
                <div id="categorie">
                </div>
            </div>
            <div-- class="large-6 columns float-right">
                <h4><strong>Omschrijving</strong></h4>
                <textarea id="omschrijving" name="text" placeholder="Omschrijving" type="text" required></textarea>

                <input type="file" name="fileToUpload" id="fileToUpload" required>

                <div class="small-up-5 row" id="imgGallery">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="large-6 columns float-left">
                <h4><strong>Verkoopadres</strong></h4>
                <div class="row">
                    <div class="large-6 columns">
                        <h5>Straat</h5>
                        <input id="straat" name="straat" type="text" placeholder="Straat" pattern="[A-Za-z]+"/>

                        <h5 class="titel">Plaats</h5>
                        <input id="plaats" name="plaats" type="text" placeholder="Plaats" pattern="[A-Za-z]+"/>

                        <h5 class="titel">Land</h5>
                        <select title="land" name="land" id="land" required>
                            <option value="" disabled selected>Kies een land</option>
                            <?php
                            $landen= executeQuery("SELECT land FROM landen");
                            for($i = 0; $i < count($landen['data']) ; $i++){
                                $land = $landen['data'][$i];
                                echo('<option value= '.$land["land"]. '>'.$land["land"].'</option>');
                            }
                            ?>
                        </select>
                    </div>
                    <div class="large-6 columns">
                        <h5>Huisnummer</h5>
                        <input id="huisnummer" name="huisnummer" type="number" placeholder="Huisnummer"/>

                        <h5 class="titel">Provincie</h5>
                        <input id="provincie" name="provincie" type="text" placeholder="Provincie" pattern="[A-Za-z]+"/>

                        <h5 class="titel">Postcode</h5>
                        <input id="postcode" name="postcode" type="text" placeholder="Postcode" pattern="[0-9a-zA-Z]+"/>
                    </div>
                </div>
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
    $veilingForm = $('#veilingForm');

    $veilingForm.validate({
        errorClass: 'validationError',
        errorElement: 'strong',
        focusCleanup: true,
        focusInvalid: false,
        highlight: function(element){
            $(element).addClass('is-invalid-input validationError');
        },
        unhighlight: function(element){
            $(element).removeClass('is-invalid-input validationError');
        },
        submitHandler: submitFiles,
        messages: {
            land: "Dit is een verplicht veld."
        },
        errorPlacement: function(error, element) {
            if(element.hasClass('categorieLijst')){
                if(element.parent().prev().is('h4')){
                    error.appendTo(element.parent().prev());
                }
                else{
                    error.appendTo(element.parent().parent().prev());
                }
            }
            else {
                error.appendTo(element.prev());
            }

            error.css('font-size', '70%');
            error.css('margin-bottom', '0');
            error.css('position', 'absolute');
            error.parent().css('position', 'relative');
            error.css('bottom', '0');
            error.css('right', '0');
        },
        rules: {
            einddatum: {
                date: true
            }
        }
    });

    var files;

    $('input[type=file]').on('change', prepareUpload);

    function prepareUpload(event)
    {
        files = event.target.files;
    }

    function submitFiles(event) {
        var data = new FormData();
        $.each(files, function (key, value) {
            data.append(key, value);
        });

        $.ajax({
            url: 'php/api.php?action=uploadFile',
            type: 'POST',
            data: data,
            cache: false,
            dataType: 'json',
            processData: false,
            contentType: false,
            success: function (data, textStatus, jqXHR) {
                if (typeof data.error === 'undefined') {
                    submit(data.file);
                }
                else {
                    console.log('ERRORS: ' + data.error);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log('ERRORS: ' + textStatus);
            }
        });
    }

    function submit(filename){
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
            eindDatum: $('#einddatum').val(),
            conditie: $('#conditie').val(),
            thumbNail: filename
        };

        $.ajax({
            type: 'POST',
            url: 'php/api.php?action=MaakVeilingAan',
            data: veiling,
            dataType: 'json',
            complete: function(){
                alert('Veiling toevoegen geslaagd!');
            }
        });
    }
</script>
</body>
</html>