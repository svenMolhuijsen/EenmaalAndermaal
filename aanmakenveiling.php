<?php
include("php/core.php");
include("php/layout/header.php");

//$verkoper = false;
//if(! $_SESSION["gebruiker"]->getVerkoper()){
    //header('Location: http://localhost/EenmaalAndermaal/index.php');
    //exit();
//}

?>
<script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>
<main>
    <h3 style="margin-left: 160px; margin-top: 50px">Aanmaken veiling</h3>
    <hr>
    <form action = "php/api.php?action=MaakVeilingAan" method="post" >
        <div class = "row" id="filterpagina">
            <?php
           // include ("php/include/categorieen.php");
            ?>
        </div>
        <div class="row">
            <div class="large-2 float-left">
                <label> Titel
                    <input id = "titel"  name = "titel" type="char(18)" placeholder="Titel" pattern="[a-z]{1,15}" />
                </label>
            </div>
            <div class = "large-2 float-left" style="margin-left: 100px;">
                <label>Prijs
                    <input id = "prijs" name="startprijs"type="smallmoney" placeholder="Prijs" pattern="[a-z]{1,15}"/>
                </label>
            </div>
            <div class="large-5 float-right">
                <label>Omschrijving
                    <textarea id = "omschrijving" name = "varchar(255)" placeholder="Omschrijving" type="text" pattern="[a-z]{1,15} "></textarea>
                </label>
            </div>
        </div>
        <div class="row">
            <div class="large-2 float-left">
                <label>Einddatum van de veiling
                    <input id= "einddatum" name="einddatum"type="date" pattern="[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])" name="einddatum" min="<?php date() ?>>">
                </label>
            </div>
        </div>
        <br><br><br><br>
        <div class = "row">
            <form action="upload.php" method="post" enctype="multipart/form-data"><?php //de afbeelding moet nog in de database komen. Hoe gaan wij die opslaan? ?>
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
                    <input id = "straat" name="straat" type="varchar(255)" placeholder="Straat" pattern="[a-z]{1,15}" />
                </label>
            </div>
            <div class = "large-2 float-left" style="margin-left: 100px;">
                <label>Huisnummer<br>
                    <input id = "huisnummer"name="huisnummer" type="varchar(255)" placeholder="Huisnummer" patter="[0,9] "/>
                </label>
            </div>
        </div>
        <div class = "row">
            <div class="large-2 float-left">
                <label> Plaats
                    <input id="plaats" name="plaats" type="varchar(255)" placeholder="Plaats" pattern="[a-z]{1,15}" />
                </label>
            </div>
            <div class = "large-2 float-left" style="margin-left: 100px;">
                <label>Postcode
                    <input id= "postcode"name="postcode" type="varchar(10)" placeholder="Postcode" pattern="[1-9][0-9]{3}\s?[a-zA-Z]{2}" />
                </label>
            </div>
        </div>
        <div class = "row">
            <div class = "large-2" >
                <label>Provincie
                    <input  id ="provincie"name="provincie" type="varchar(255)" placeholder="Provincie" pattern="[a-z]{1,15}" />
                </label>
            </div>
            <div class="large-2 end" style="margin-left: 100px;" >
                <select id = land>
                    <?php
                    $landen= executeQuery("SELECT land FROM landen"); //alle waardes uit de tabel komt in landen[]
                            for($i=0; $i< count($landen['data']) ; $i++){ //i is kleiner dan aantal landen
                            $land = $landen['data'][$i]; //pompt de huidige waarde van landen[i] in land
                            echo('<option value= '.$land["land"]. '>'.$land["land"].'</option>');
                        }
                    ?>

                </select>

            </div>
        </div>
    </form>

        <div class = "row">
            <input id="add-Veiling" class = "button large" type="submit" value="Start je veiling">
        </div>



</main>






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
            $titel= $('#titel');
            $prijs=  $('#prijs');
            $omschrijving= $('#omschrijving');
            $einddatum= $('#einddatum');
            $plaats= $('#plaats');
            $provincie= $('#provincie');
            $postcode=  $('#postcode');
            $straat = $('#straat');
            $huisnummer = $('#huisnummer');
            $land = $('#land');

    $(function() {
        $('#add-Veiling').click(function () { //als je op de knop drukt voert ajax de executequerry uit
            $titelVal = $titel.val();
            $prijsVal = $prijs.val();
            $omschrijvingVal = $omschrijving.val();
            $einddatumVal = $einddatum.val();
            $plaatsVal = $plaats.val();
            $provincieVal= $provincie.val();
            $postcodeVal = $postcode.val();
            $straatVal= $straat.val();
            $huisnummerVal = $huisnummer.val();
            $landVal = $land.val();

        if($titelVal == "" ||
            $prijsVal == "" ||
            $omschrijvingVal == ""||
            $einddatumVal== ""  ||
            $plaatsVal== ""   ||
            $provincieVal == "" ||
            $postcodeVal == "" ||
            $straatVal== ""  ||
            $huisnummerVal== ""  ||
            $landVal== "" ){
            alert("Let op! U heeft een veld niet ingevuld");

        }else {

            $.ajax({
                type: 'POST',
                url: 'php/api.php?action=MaakVeilingAan',
                data: {
                    $titelVal,
                    $prijsVal,
                    $omschrijvingVal,
                    $einddatumVal,
                    $plaatsVal,
                    $provincieVal,
                    $postcodeVal,
                    $straatVal,
                    $huisnummerVal,
                    $landVal,
                },

                success: function () {
                    alert('Je veiling is succesvol aangemaakt!');
                },
                error: function () {
                    alert('Veiling aanmaken mislukt, probeer het opnieuw');
                }
            })
        }
        });


    })


</script>
<?php
include("php/layout/footer.php");
?>
