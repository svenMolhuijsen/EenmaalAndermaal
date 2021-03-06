<?php
$pagename = "Filters";

//Hoofdcategorie van de eerste set subcategoriën
$hoofdcategorie = (isset($_GET["hoofdcategorie"]));

include("php/core.php");
include("php/layout/header.php");
include("php/layout/breadcrumbs.php");

//Manier van sorteren
$sortBy = (isset($_GET['sorterenOp']) ? $_GET['sorterenOp'] : null);

/* onderstaande querry wordt gebruikt om alle veilingen op te halen die voldoen aan de filters
$query = select fotoPath
from veilingFoto, veiling
where veilingFoto.veilingId = veiling.veilingId AND categorie = $geselecteerdeCat
order by $sortBy*/

//Haal alle subcategoriën op
$categorien = executeQuery("SELECT * FROM categorie WHERE superId = ?", [$hoofdcategorie]);

?>

<main class="row" id="filterpagina">
    <div class="column">
        <h2 class="float-left">Uw Zoekresultaten: </h2>
        <form method="get" class="float-right" action="filterpagina.php">
            <div class="float-right">
                <!-- Filter formulier -->
                <label for="sortering">Filter op: </label>
                <select id="sortering" style="width: 100%" name="sorterenOp" style="width:20%">
                    <option value="Date ASC">Datum Aflopend</option>
                    <option value="Date DECS">Datum Oplopend</option>
                    <option value="startPrijs ASC">Startprijs Oplopend</option>
                    <option value="startPrijs DESC">Startprijs Aflopend</option>
                    <option value="Title ASC">Alphabet</option>
                </select>
            </div>

            <!-- Pagination -->
            <div class="float-right">
                <label for="pagination">Pagina</label>
                <div id="pagination" class="pagination float-right">
                    <a href="#" class="first" data-action="first">&laquo;</a>
                    <a href="#" class="previous" data-action="previous">&lsaquo;</a>
                    <input type="text" readonly="readonly" data-max-page="1"/>
                    <a href="#" class="next" data-action="next">&rsaquo;</a>
                    <a href="#" class="last" data-action="last">&raquo;</a>
                </div>
            </div>
        </form>
    </div>
    <aside class="column small-3">
        <!-- Zoeken op woorden en categorie -->
        <h3> Filter op: </h3>
        <form class="filter">
            <label for="searchterm">Zoekterm:</label>
            <input type="text" placeholder="Zoekterm" id="searchterm" name="searchterm">
            <label for="categories">Categorie:</label>

            <div class="categorien" id="categories"></div>
            <div class="row">
                <div class='columns'>
                    <!-- Prijs slider -->
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
            <a class="button primary" onclick="zoeken()" value="Zoekresultaten Ophalen!">Zoeken!</a>
            <a href="filterpagina.php" class="button secondary-light">Reset</a>

        </form>
    </aside>

    <div class="veilingen column small-9">
        <div class="row">
            <!--de rest wordt gegenereet met javascript-->

        </div>
    </div>
</main>


<?php include("php/layout/footer.html") ?>
