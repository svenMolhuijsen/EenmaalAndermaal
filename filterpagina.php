<?php
$pagename = "filterpagina";
$hoofdcategorie = $_GET["hoofdcategorie"];

include("php/core.php");
include("php/layout/header.php");
include("php/layout/breadcrumbs.php");

$sortBy = (isset($_GET['sorterenOp']) ? $_GET['sorterenOp'] : null);
/* onderstaande querry wordt gebruikt om alle veilingen op te halen die voldoen aan de filters
$query = select fotoPath
from veilingFoto, veiling
where veilingFoto.veilingId = veiling.veilingId AND categorie = $geselecteerdeCat
order by $sortBy*/

$categorien = executeQuery("SELECT * FROM categorie WHERE superId = ?", [$hoofdcategorie]);

function ding($categorie){
    if(isset($categorie["subs"])) {
        for ($i = 0; $i < count($categorie["subs"]); $i++) {
            $categorie = &$categorie["subs"][$i];

            $subcategorien = executeQuery("SELECT * FROM categorie WHERE superId = ?", [$categorie["categorieId"]]);
            if ($subcategorien["code"] == 0) {
                $categorie["subs"] = $subcategorien["data"];

                ding($categorie);
            }
        }
    }
}

if($categorien["code"] == 0){
    for($i = 0; $i < count($categorien["data"]); $i++) {
        $categorie = &$categorien["data"][$i];
        $subcategorien = executeQuery("SELECT * FROM categorie WHERE superId = ?", [$categorie["categorieId"]]);

        if($subcategorien["code"] == 0){
            $categorie["subs"] = $subcategorien["data"];

            ding($categorien);
        }
    }
}

var_dump($categorien);

 ?>

<div class="row">
    <div class="clearfix">
        <div class="small-up-1 medium-up-3 columns-12 float-center">
            <div class="column column-block" id="blocks">
                <input type="text" placeholder="zoek">
            </div>
            <div class="column column-block" id="blocks">
                <select>
                    <option value="Voertuigen">Voertuigen</option>
                    <option value="Kleding">Kleding</option>
                    <option value="Vakanties">Vakanties</option>
                    <option value="Sport">Sport</option>
                </select>
            </div>
            <div class="column column-block" id="blocks">
                <input type="submit" class="button" value="submit">
            </div>
        </div>


        <h4 class="float-right hide-for-small-only">Jouw Zoekresultaten: </h4>
    </div>
        <form method="get" action="filterpagina.php">
            <select class = "float-right hide-for-small-only" name="sorterenOp" style="width:20%">
            <option value="null">Sorteren op: </option>
            <option value="verkoopPrijs ASC">Prijs Oplopend: </option>
            <option value="verkoopPrijs DSC">Prijs Aflopend: </option>
            <option value="Date ACS">Datum Aflopend: </option>
            <option value = "Date DCS">Meest Recente: </option>
            </select>
        </form>
    <h3 class ="hide-for-large float-left">Filter op: </h3>
    <br><br><br><br>


    <?php/*----------------------------DRILL DOWN MENU---------------------------------------------------------*/?>
    <div class ="hide-for-large" style="color: blue">
    <button class="accordion ">Merk</button>
    <div class="panel">
        <form method="get" action="">
            <select class = "medium-up-2" name="selecteerCat" style="100%">
                <option value="Merk">Merk: </option>
                <option value="prijs oplopend">BMW: </option>
                <option value="prijs aflopend">Audi: </option>
                <option value="tijd">Mercedes: </option>
                <option value = "recente">Aston Martin: </option>
            </select>
        </form>
    </div>

    <button class="accordion">Type</button>
    <div class="panel">
        <form method="get" action="">
            <select class = "medium-up-2" name="selecteerCat" style="100%">
                <option value="Merk">Merk: </option>
                <option value="prijs oplopend">BMW: </option>
                <option value="prijs aflopend">Audi: </option>
                <option value="tijd">Mercedes: </option>
                <option value = "recente">Aston Martin: </option>
            </select>
        </form>
    </div>

    <button class="accordion">Jaar</button>
    <div class="panel">
        <form method="get" action="">
            <select class = "medium-up-2" name="selecteerCat" style="100%">
                <option value="Merk">Merk: </option>
                <option value="prijs oplopend">BMW: </option>
                <option value="prijs aflopend">Audi: </option>
                <option value="tijd">Mercedes: </option>
                <option value = "recente">Aston Martin: </option>
            </select>
        </form>
    </div>
    </div>
    <script>
        var acc = document.getElementsByClassName("accordion");
        var i;

        for (i = 0; i < acc.length; i++) {
            acc[i].onclick = function(){
                this.classList.toggle("active");
                var panel = this.nextElementSibling;
                if (panel.style.display === "block") {
                    panel.style.display = "none";
                } else {
                    panel.style.display = "block";
                }
            }
        }
    </script>

    <?php/*---------------------------------------------------------------------------------------------------------------*/?>
    <hr>
    <h4 class="show-for-small-only">Jouw Zoekresultaten: </h4>
    <form method="get" action="filterpagina.php">
    <select class = "show-for-small-only" style="width: 100%"" name="sorterenOp" style="width:20%">
        <option value="null">Sorteren op: </option>
        <option value="verkoopPrijs ASC">Prijs Oplopend: </option>
        <option value="verkoopPrijs DSC">Prijs Aflopend: </option>
        <option value="Date ACS">Datum Aflopend: </option>
        <option value = "Date DCS">Meest Recente: </option>
    </select>
</form>


    <div class="small-up-3 medium-up-4 large-up-5 columns-12 float-right"<?php/*Hieronder komt de querry om de afbeelding
        op te halen. met een querry. daarbij komt dat als bijvoorbeeld de 'sorteren op' wordt aangepast ook de selectie van de
        veilingen veranderen */ ?>

        <?php/* selectRecords($query, $data) */?>
        <div class="column column-block"><a href="#"><img src="http://placehold.it/150x300" alt=""><div style="color: #E25822">titel Product<br>€100</div></a></div>
        <div class="column column-block"><a href="#"><img src="http://placehold.it/150x300" alt=""><div style="color: #E25822">titel Product<br>€100</div></a></div>
        <div class="column column-block"><a href="#"><img src="http://placehold.it/150x300" alt=""><div style="color: #E25822">titel Product<br>€100</div></a></div>
        <div class="column column-block"><a href="#"><img src="http://placehold.it/150x300" alt=""><div style="color: #E25822">titel Product<br>€100</div></a></div>
        <div class="column column-block"><a href="#"><img src="http://placehold.it/150x300" alt=""><div style="color: #E25822">titel Product<br>€100</div></a></div>
        <div class="column column-block"><a href="#"><img src="http://placehold.it/150x300" alt=""><div style="color: #E25822">titel Product<br>€100</div></a></div>
        <div class="column column-block"><a href="#"><img src="http://placehold.it/150x300" alt=""><div style="color: #E25822">titel Product<br>€100</div></a></div>
        <div class="column column-block"><a href="#"><img src="http://placehold.it/150x300" alt=""><div style="color: #E25822">titel Product<br>€100</div></a></div>
        <div class="column column-block"><a href="#"><img src="http://placehold.it/150x300" alt=""><div style="color: #E25822">titel Product<br>€100</div></a></div>
        <div class="column column-block"><a href="#"><img src="http://placehold.it/150x300" alt=""><div style="color: #E25822">titel Product<br>€100</div></a></div>
        <div class="column column-block"><a href="#"><img src="http://placehold.it/150x300" alt=""><div style="color: #E25822">titel Product<br>€100</div></a></div>
        <div class="column column-block"><a href="#"><img src="http://placehold.it/150x300" alt=""><div style="color: #E25822">titel Product<br>€100</div></a></div>
        <div class="column column-block"><a href="#"><img src="http://placehold.it/150x300" alt=""><div style="color: #E25822">titel Product<br>€100</div></a></div>
        <div class="column column-block"><a href="#"><img src="http://placehold.it/150x300" alt=""><div style="color: #E25822">titel Product<br>€100</div></a></div>
        <div class="column column-block"><a href="#"><img src="http://placehold.it/150x300" alt=""><div style="color: #E25822">titel Product<br>€100</div></a></div>


    </div>

            <div class = "show-for-large">
                <h3> Filter op: </h3>

            <form method="get" action="">
                     <select class = "medium-up-2 float-left" name="selecteerCat" style="width: 175px;">
                         <option value="Merk">Merk: </option>
                         <option value="prijs oplopend">BMW: </option>
                         <option value="prijs aflopend">Audi: </option>
                         <option value="tijd">Mercedes: </option>
                         <option value = "recente">Aston Martin: </option>
                     </select>
                 </form>

                 <form method="get" action="">
                     <select class = "medium-up-2 float-left" name="selecteerCat" style="width: 175px;">
                         <option value="SORT BY">Type: </option>
                         <option value="prijs oplopend">SUV: </option>
                         <option value="prijs aflopend">Coupé: </option>
                         <option value="tijd">Station Wagon: </option>
                         <option value = "recente">Pick Up: </option>
                     </select>
                 </form>


                 <form method="get" action="">
                     <select class = "medium-up-2 float-left" name="selecteerCat" style="width: 175px;">
                         <option value="SORT BY">Jaar: </option>
                         <option value="prijs oplopend">1980 of eerder: </option>
                         <option value="prijs aflopend">1980-1990: </option>
                         <option value="tijd">1990-2000: </option>
                         <option value = "recente">2000-2010: </option>
                         <option value = "recente">2010-Heden: </option>
                     </select>
                 </form>

                 <form method="get" action="">
                 <select class = "medium-up-2 float-left" name="selecteerCat" style="width: 175px;" >
                     <option value="SORT BY">Uitvoering: </option>
                     <option value="prijs oplopend">Sport: </option>
                     <option value="prijs aflopend">Luxury: </option>
                     <option value="tijd">GTI: </option>
                 </select>
                 </form>
                <button type="button" style="width: 175px; color: white; border-color: #E25822; background-color: #E25822">Zoekresultaten Ophalen!</button>

            </div>
</div>

<?php include("php/layout/footer.php") ?>
