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


    </div>
    <div class="row">
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
        <aside class="column medium-3">
            <h3> Filter op: </h3>
            <form class="filter">
                <div class="categorien"></div>
                <div class="slider" data-slider data-initial-start="0" data-initial-end="100">
                    <span class="slider-handle" data-slider-handle role="slider" tabindex="1"></span>
                    <span class="slider-fill" data-slider-fill></span>
                    <span class="slider-handle" data-slider-handle role="slider" tabindex="1"></span>
                    <input type="hidden">
                    <input type="hidden">
                </div>
                <button type="button"
                        style="width: 175px; color: white; border-color: #E25822; background-color: #E25822">
                    Zoekresultaten Ophalen!
                </button>
            </form>
        </aside>

        <main class="products column medium-9">
            <div class="row">
                <div class="column small-6 medium-4 large-3"><a href="#"><img src="http://placehold.it/150x300" alt="">
                        <div style="color: #E25822">titel Product<br>€100</div>
                    </a></div>
                <div class="column small-6 medium-4 large-3"><a href="#"><img src="http://placehold.it/150x300" alt="">
                        <div style="color: #E25822">titel Product<br>€100</div>
                    </a></div>
                <div class="column small-6 medium-4 large-3"><a href="#"><img src="http://placehold.it/150x300" alt="">
                        <div style="color: #E25822">titel Product<br>€100</div>
                    </a></div>
                <div class="column small-6 medium-4 large-3"><a href="#"><img src="http://placehold.it/150x300" alt="">
                        <div style="color: #E25822">titel Product<br>€100</div>
                    </a></div>
                <div class="column small-6 medium-4 large-3"><a href="#"><img src="http://placehold.it/150x300" alt="">
                        <div style="color: #E25822">titel Product<br>€100</div>
                    </a></div>
                <div class="column small-6 medium-4 large-3"><a href="#"><img src="http://placehold.it/150x300" alt="">
                        <div style="color: #E25822">titel Product<br>€100</div>
                    </a></div>
                <div class="column small-6 medium-4 large-3"><a href="#"><img src="http://placehold.it/150x300" alt="">
                        <div style="color: #E25822">titel Product<br>€100</div>
                    </a></div>
                <div class="column small-6 medium-4 large-3"><a href="#"><img src="http://placehold.it/150x300" alt="">
                        <div style="color: #E25822">titel Product<br>€100</div>
                    </a></div>
                <div class="column small-6 medium-4 large-3"><a href="#"><img src="http://placehold.it/150x300" alt="">
                        <div style="color: #E25822">titel Product<br>€100</div>
                    </a></div>
                <div class="column small-6 medium-4 large-3"><a href="#"><img src="http://placehold.it/150x300" alt="">
                        <div style="color: #E25822">titel Product<br>€100</div>
                    </a></div>
                <div class="column small-6 medium-4 large-3"><a href="#"><img src="http://placehold.it/150x300" alt="">
                        <div style="color: #E25822">titel Product<br>€100</div>
                    </a></div>
                <div class="column small-6 medium-4 large-3"><a href="#"><img src="http://placehold.it/150x300" alt="">
                        <div style="color: #E25822">titel Product<br>€100</div>
                    </a></div>
                <div class="column small-6 medium-4 large-3"><a href="#"><img src="http://placehold.it/150x300" alt="">
                        <div style="color: #E25822">titel Product<br>€100</div>
                    </a></div>
                <div class="column small-6 medium-4 large-3"><a href="#"><img src="http://placehold.it/150x300" alt="">
                        <div style="color: #E25822">titel Product<br>€100</div>
                    </a></div>
            </div>
        </main>
    </div>
</div>


<?php include("php/layout/footer.php") ?>
