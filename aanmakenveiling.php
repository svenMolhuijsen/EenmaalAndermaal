<?php
$pagename = "Aanmakenveiling";

include("php/core.php");
include("php/layout/header.php");
include("php/layout/breadcrumbs.php");

//Blokeer de gebruiker als hij niet ingelogd is.
if (!isset($_SESSION['gebruiker'])) {
    include("php/layout/geentoegang.html");
} else {
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
                        <!-- Titel -->
                        <h4><strong>Titel</strong></h4>
                        <input id="titel" maxlength="255" name="titel" type="text" placeholder="Titel" pattern="[A-Za-z0-9-' ]+" required/>

                        <!-- Prijs -->
                        <h4><strong>Prijs</strong></h4>
                        <input id="prijs" maxlength="18" name="startprijs" pattern="^[1-9]+\.\d{2}$" type="text" placeholder="Prijs"
                               required/>

                        <!-- Einddatum -->
                        <h4><strong>Einddatum</strong></h4>
                        <input id="einddatum" name="einddatum" type="date" max="31-12-2099" placeholder="Einddatum" required/>

                        <!-- Conditie -->
                        <h4><strong>Conditie</strong></h4>
                        <select title="conditie" name="conditie" id="conditie">
                            <option value="" selected disabled>Kies een conditie</option>
                            <?php
                            //Haal de condities uit de database als optie
                            $condities = executeQuery("SELECT distinct conditie FROM veiling WHERE conditie != ''");
                            for ($i = 0; $i < count($condities['data']); $i++) {
                                $conditie = $condities['data'][$i];
                                echo('<option value= ' . $conditie["conditie"] . '>' . $conditie["conditie"] . '</option>');
                            }
                            ?>
                        </select>

                        <!-- Categorie -->
                        <h4><strong>Categorie</strong></h4>
                        <div id="categorieTwee">
                        </div>
                    </div>
                    <div class="large-6 columns float-right">
                        <!-- Omschrijving -->
                        <h4><strong>Omschrijving</strong></h4>
                        <textarea id="omschrijving" name="text" placeholder="Omschrijving" type="text"
                                  required></textarea>

                        <!-- Thumbnail image -->
                        <h4><strong>Thumbnail</strong></h4>
                        <input type="file" name="thumbnailUpload" id="thumbnailUpload" required>

                        <!-- Foto's -->
                        <h4><strong>Foto's</strong></h4>
                        <input type="file" name="imageUpload" id="imageUpload" multiple>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <!-- Locatie informatie -->
                    <div class="large-6 columns float-left">
                        <h4><strong>Verkoopadres</strong></h4>
                        <div class="row">
                            <div class="large-6 columns">
                                <!-- Straatnaam -->
                                <h5>Straat</h5>
                                <input id="straat" maxlength="255" name="straat" type="text" placeholder="Straat"
                                       pattern="[A-Za-z-' ]+"/>

                                <!-- Plaatsnaam -->
                                <h5 class="titel">Plaats</h5>
                                <input id="plaats" name="plaats" maxlength="255" type="text" placeholder="Plaats"
                                       pattern="[A-Za-z-' ]+"/>

                                <!-- Land -->
                                <h5 class="titel">Land</h5>
                                <select title="land" name="land" id="land" required>
                                    <option value="" disabled selected>Kies een land</option>
                                    <?php
                                    //Haal de landen uit de database als optie
                                    $landen = executeQuery("SELECT land FROM landen");
                                    for ($i = 0; $i < count($landen['data']); $i++) {
                                        $land = $landen['data'][$i];
                                        echo('<option value= ' . $land["land"] . '>' . $land["land"] . '</option>');
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="large-6 columns">
                                <!-- Huisnummer -->
                                <h5>Huisnummer</h5>
                                <input id="huisnummer" name="huisnummer" type="text"  maxlength="20" placeholder="Huisnummer"
                                       pattern="^[1-9][0-9]*[a-zA-Z]?"/>

                                <!-- Provincie -->
                                <h5 class="titel">Provincie</h5>
                                <input id="provincie" name="provincie" type="text" maxlength="255" placeholder="Provincie"
                                       pattern="[A-Za-z-' ]+"/>

                                <!-- Postcode -->
                                <h5 class="titel">Postcode</h5>
                                <input id="postcode" name="postcode" type="text" maxlength="10" placeholder="Postcode"
                                       pattern="^[1-9][0-9]*[a-zA-z- ]*"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row column">
                    <input id="add-Veiling" class="button large" type="submit" value="Start je veiling">
                </div>
            </form>
        </div>
    </main>
<?php } include('php/layout/footer.html'); ?>
    <script>
        $(document).ready(function () {
            //Nu in het juiste formaat
            var date = new Date();
            now = date.getFullYear() + "-" + date.getMonth() + "-" + date.getDate() + " " + date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds() + ":" + date.getMilliseconds();

            //DOM locatie van elementen
            $veilingForm = $('#veilingForm');
            $imageUploader = $('#imageUpload');
            $thumbnailUploader = $('#thumbnailUpload');

            //Opmaak van de error class
            var errorCSS = {
                'position': 'absolute',
                'font-size': '70%',
                'margin-bottom': '0',
                'bottom': '0',
                'right': '0'
            };

            //Validatie van de veiling form en al zijn regels
            $veilingForm.validate({
                submitHandler: submit,
                messages: {
                    land: "Dit is een verplicht veld.",
                    eindDatum: {
                        greaterThanDate: "Voer een latere datum in."
                    }
                },
                errorPlacement: function (error, element) {
                    //Dynamische errorpositionering voor de categorielijst
                    if (element.hasClass('categorieLijst')) {
                        if (element.parent().prev().is('h4')) {
                            error.appendTo(element.parent().prev());
                        }
                        else {
                            error.appendTo(element.parent().parent().prev());
                        }
                    }
                    else {
                        error.appendTo(element.prev());
                    }

                    error.parent().css('position', 'relative');
                    error.css(errorCSS);
                },
                rules: {
                    einddatum: {
                        date: true,
                        greaterThanDate: date
                    }
                }
            });

            //Opslag voor de image files
            var thumbnail;
            var images;

            //Klaarzetten van de images
            $imageUploader.on('change', function (event) {
                images = event.target.files;
            });

            $thumbnailUploader.on('change', function (event) {
                thumbnail = event.target.files;
            });

            //Opsturen van de form
            function submit() {
                var data = new FormData();

                //Images
                $.each(images, function (key, value) {
                    data.append(key, value);
                });

                $.each(thumbnail, function (key, value) {
                    data.append('thumbnail', value);
                });

                //Veilinginfo
                data.append('titel', $('#titel').val());
                data.append('beschrijving', $('#omschrijving').val());
                data.append('categorieId', $('#categorieTwee').children().last().prev().find(":selected").val());
                data.append('postcode', $('#postcode').val());
                data.append('land', $('#land').val());
                data.append('startPrijs', $('#prijs').val());
                data.append('provincie', $('#provincie').val());
                data.append('plaatsnaam', $('#plaats').val());
                data.append('straatnaam', $('#straat').val());
                data.append('huisnummer', $('#huisnummer').val());
                data.append('beginDatum', now);
                data.append('eindDatum', $('#einddatum').val());
                data.append('conditie', $('#conditie').val());

                $.ajax({
                    type: 'POST',
                    url: 'php/api.php?action=MaakVeilingAan',
                    data: data,
                    cache: false,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    success: function (result) {
                        //Geef het resultaat weer
                        switch (result.status) {
                            case 'success':
                                $imageUploader.removeClass('is-invalid-input');
                                alert(result.message);
                                break;
                            case 'error':
                                alert(result.message);
                                break;
                            case 'userError':
                                $imageUploader.addClass('is-invalid-input');
                                alert(result.feedback);
                                break;
                        }
                    },
                    error: function (result) {
                        console.log('error');
                        console.log(result);
                    }
                });
            }
        });
    </script>
    </body>
    </html>
