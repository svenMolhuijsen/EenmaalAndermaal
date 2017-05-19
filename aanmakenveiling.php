<?php
$pagename = "nieuwe veiling";
include("php/core.php");
include("php/layout/header.php");


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

</script>
<script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>
<main>
    <h3 style="margin-left: 160px; margin-top: 50px">Aanmaken veiling</h3>
    <hr>
    <form action = "registreerveiling.php" method="post" >
    <div class = "row">
        <div class="large-2 float-left">
            <label>Selecteer Hoofd Categorie
                <select name = "hoofdcategorie">
                    <option value="husker">Auto</option>
                    <option value="starbuck">Speelgoed</option>
                    <option value="hotdog">Gezondheid</option>
                    <option value="apollo">Fietsen</option>
                </select>
            </label>
        </div>
    </div>
        <div class="row">
            <div class="large-2 float-left">
                <label> Titel
                    <input name = "titel" type="text" placeholder="Titel" pattern="[a-z]{1,15}" />
                </label>
            </div>
            <div class = "large-2 float-left" style="margin-left: 100px;">
                <label>Prijs
                    <input name="startprijs"type="text" placeholder="Prijs" pattern="[a-z]{1,15}"/>
                </label>
            </div>
            <div class="large-5 float-right">
                <label>Omschrijving
                    <textarea name = "omschrijving" placeholder="Omschrijving" type="text" pattern="[a-z]{1,15} "></textarea>
                </label>
            </div>
        </div>
        <div class="row">
            <div class="large-2 float-left">
                <label>Einddatum
                    <input name="einddatum"type="date" pattern="[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])" name="einddatum" min="<?php date() ?>>">
                </label>
            </div>
        </div>
        <br><br><br><br>
        <div class = "row">
            <form action="upload.php" method="post" enctype="multipart/form-data">
                <label for="hoofdfoto" class="button">Upload je Hoofdfoto</label>
                <input type="file" id="hoofdfoto" class="show-for-sr" onchange="readURL1(this);">
            </form>
        </div>
        <div class = "row">
            <img id="Hoofdfoto" src="#" alt="Uw Afbeelding" />
        </div>
        <br><br>
        <div class = "row">
            <h3 syle="margin-left: 150px;">Verkoopadres</h3>
        </div>
        <div class = "row">
            <div class="large-2 float-left">
                <label> Straat
                    <input name="straat" type="text" placeholder="Straat" pattern="[a-z]{1,15}" />
                </label>
            </div>
            <div class = "large-2 float-left" style="margin-left: 100px;">
                <label>nr
                    <input name="huisnummer" type="number" placeholder="Huisnummer" patter="[0,9] "/>
                </label>
            </div>
        </div>
        <div class = "row">
            <div class="large-2 float-left">
                <label> Plaats
                    <input name="plaats" type="text" placeholder="Plaats" pattern="[a-z]{1,15}" />
                </label>
            </div>
            <div class = "large-2 float-left" style="margin-left: 100px;">
                <label>Postcode
                    <input name="postcode" type="text" placeholder="Prijs" pattern="[1-9][0-9]{3}\s?[a-zA-Z]{2}" />
                </label>
            </div>
        </div>
        <div class = "row">
            <div class = "large-2 float-left" >
                <label>Provincie
                    <input name="provincie" type="text" placeholder="Provincie" pattern="[a-z]{1,15}" />
                </label>
            </div>
        </div>


        <div class = "row">
            <input class = "button large" type="submit" value="Start je veiling">
        </div>

    </form>

</main>







<?php
include("php/layout/footer.php");
?>
