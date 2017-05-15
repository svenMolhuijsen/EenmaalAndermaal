<?php
include("php/core.php");
include("php/layout/header.php");
?>

<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blah')
                    .attr('src', e.target.result)
                    .width(150)
                    .height(200);
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
    <form>
        <div class="row">
            <div class="large-2 float-left">
                <label> Titel
                    <input type="text" placeholder="Titel" />
                </label>
            </div>
            <div class = "large-2 float-left" style="margin-left: 100px;">
                <label>Prijs
                    <input type="text" placeholder="Prijs" />
                </label>
            </div>
            <div class="large-5 float-right">
                <label>Omschrijving
                    <textarea placeholder="Omschrijving"></textarea>
                </label>
            </div>
        </div>
        <div class="row">
            <div class="large-2 float-left">
                <label>Selecteer Hoofd Categorie
                    <select>
                        <option value="husker">Auto</option>
                        <option value="starbuck">Speelgoed</option>
                        <option value="hotdog">Gezondheid</option>
                        <option value="apollo">Fietsen</option>
                    </select>
                </label>
            </div>
            <div class="large-2 float-left" style="margin-left: 100px;">
                <label>Selecteer Conditie
                    <select>
                        <option value="husker">nieuw</option>
                        <option value="starbuck">ZGAN</option>
                        <option value="hotdog">Gebruikt</option>
                    </select>
                </label>
            </div>
        </div>
        <br><br><br><br>
        <div class = "row">
            <form action="upload.php" method="post" enctype="multipart/form-data">
                <label for="exampleFileUpload" class="button">Upload je foto</label>
                <input type="file" id="exampleFileUpload" class="show-for-sr" onchange="readURL(this);">
            </form>
        </div>
        <div class = "row">
            <img id="blah" src="#" alt="your image" />
        </div>
        <br><br>
        <div class = "row">
            <h3 syle="margin-left: 150px;">Verkoopadres</h3>
        </div>
        <div class = "row">
            <div class="large-2 float-left">
                <label> Straat
                    <input type="text" placeholder="Titel" />
                </label>
            </div>
            <div class = "large-2 float-left" style="margin-left: 100px;">
                <label>nr
                    <input type="text" placeholder="Prijs" />
                </label>
            </div>
        </div>
        <div class = "row">
            <div class="large-2 float-left">
                <label> Plaats
                    <input type="text" placeholder="Titel" />
                </label>
            </div>
            <div class = "large-2 float-left" style="margin-left: 100px;">
                <label>Postcode
                    <input type="text" placeholder="Prijs" />
                </label>
            </div>
        </div>
        <div class = "row">
            <div class = "large-2 float-left" >
                <label>Provincie
                    <input type="text" placeholder="Prijs" />
                </label>
            </div>
        </div>
        <br><br><br><br>



        <div class = "row">
            <input class = "button large"type="submit" value="Start je veiling">
        </div>

    </form>
</main>



<?php
include("php/layout/footer.php");
?>
