<?php
$pagename = "filterpagina";
$hoofdcategorie = (isset($_GET["hoofdcategorie"]));

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

?>

<div class="row" id="filterpagina">
        <div class="column">
            <h2 class="float-left">Jouw Zoekresultaten: </h2>
            <form method="get" class="float-right" action="filterpagina.php">
                <label for="sortering">Filter op: </label>
                <select id="sortering" style="width: 100%" name="sorterenOp" style="width:20%">
                    <option value="null">Sorteren op:</option>
                    <option value="verkoopPrijs ASC">Prijs Oplopend:</option>
                    <option value="verkoopPrijs DSC">Prijs Aflopend:</option>
                    <option value="Date ACS">Datum Aflopend:</option>
                    <option value="Date DCS">Meest Recente:</option>
                </select>
            </form>
        </div>
    <aside class="column small-3">
            <h3> Filter op: </h3>
            <form class="filter">
                <label for="searchterm">Zoekterm:</label>
                <input type="text" placeholder="Zoekterm" id="searchterm" name="searchterm">
                <label for="categories">Categorie:</label>

                <div class="categorien" id="categories"></div>
                <div class="row">
                    <div class='columns'>
                        <label for="priceSlider">Prijs:</label>
                        <div class="slider" id="priceSlider" data-slider data-initial-start='0' data-initial-end='1000'
                             data-start="0"
                             data-end="1000">
            <span class="slider-handle" data-slider-handle role="slider" tabindex="1"
                  aria-controls='sliderOutput1'></span>
                            <span class="slider-fill" data-slider-fill></span>
                            <span class="slider-handle" data-slider-handle role="slider" tabindex="1"
                                  aria-controls='sliderOutput2'></span>
                        </div>
                    </div>
                    <div class="small-5 columns">
                        <input type="number" id="sliderOutput1">
                    </div>
                    <div class="small-5 columns">
                        <input type="number" id="sliderOutput2">
                    </div>
                </div>
                <input type="submit" class="button primary" value="Zoekresultaten Ophalen!"/>
                <a href="filterpagina.php" class="button secondary">reset</a>

            </form>
        </aside>

    <main class="veilingen column small-9">
        <div class="row" data-equalizer>

        </div>
        </main>
</div>


<?php include("php/layout/footer.php") ?>
