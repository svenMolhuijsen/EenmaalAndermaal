<?php
$pagename = "categorie";
include("php/api.php");
include("php/layout/header.php");
include("php/layout/breadcrumbs.php");
?>

<main>
    <div class="row collapse">
        <div class="medium-3 columns">
            <ul class="tabs vertical" id="categorieen" data-tabs>
                <?php
                $hoofdCategorieen = executeQuery("SELECT * FROM categorie WHERE superId IS NULL");
                for($i = 0; $i < count($hoofdCategorieen['data']); $i++){
                    $hoofdCategorie = $hoofdCategorieen['data'][$i];
                echo('<li class="tabs-title"><a href="#'.$hoofdCategorie['categorieId'].'">'.$hoofdCategorie['categorieNaam'].'</a></li>');
                }
                
                ?>
            </ul>
        </div>
        <div class="medium-9 columns">
            <div class="tabs-content vertical" data-tabs-content="categorieen">
                <?php
                    for($i = 0; $i < count($hoofdCategorieen['data']); $i++){
                        $hoofdCategorie = $hoofdCategorieen['data'][$i];
                        echo('<div class="tabs-panel" id="'.$hoofdCategorie['categorieId'].'">');
                        echo('<div class="row medium-up-3 large-up-5 text-center">');
                            $subcategorien = executeQuery("SELECT * FROM categorie WHERE superId = ?", [$hoofdCategorie['categorieId']]);
                            for ($j = 0; $j < count($subcategorien['data']); $j++) {
                                $subcategorie = $subcategorien['data'][$j];
                                echo('<div class="column column-block"><a href="#"><img src="http://placehold.it/100x100" alt=""><div>'.$subcategorie['categorieNaam'].'</div></a></div>');
                            }
                        echo('</div>');
                        echo('</div>');
                    }
                ?>
        </div>
        <div class="medium-9 columns">
            <div class="tabs-content vertical" data-tabs-content="categorieen">
                <div class="tabs-panel is-active" id="populair">
                    <div class="row medium-up-3 large-up-5 text-center">
                        <div class="column column-block"><a href="#">
                                <img src="http://placehold.it/100x100" alt="">
                                <div>Laptops</div>
                            </a></div>
                        <div class="column column-block"><a href="">
                                <img src="http://placehold.it/100x100" alt="">
                                <div>Monitoren</div>
                            </a></div>
                        <div class="column column-block"><a href="">
                                <img src="http://placehold.it/100x100" alt="">
                                <div>Smartphones</div>
                            </a></div>
                        <div class="column column-block"><a href="">
                                <img src="http://placehold.it/100x100" alt="">
                                <div>Televisies</div>
                            </a></div>
                        <div class="column column-block"><a href="">
                            <img src="http://placehold.it/100x100" alt="">
                            <div>Moederborden</div>
                        </a></div>
                        <div class="column column-block"><a href="">
                                <img src="http://placehold.it/100x100" alt="">
                                <div>Processors</div>
                            </a></div>
                        <div class="column column-block"><a href="">
                                <img src="http://placehold.it/100x100" alt="">
                                <div>Interne harde schijven</div>
                            </a></div>
                    </div>
                </div>
                <div class="tabs-panel" id="voertuigen">
                    <p>Vivamus hendrerit arcu sed erat molestie vehicula. Sed auctor neque eu tellus rhoncus ut eleifend nibh porttitor. Ut in nulla enim. Phasellus molestie magna non est bibendum non venenatis nisl tempor. Suspendisse dictum feugiat nisl ut dapibus.</p>
                </div>
                <div class="tabs-panel" id="sport">
                    <img class="thumbnail" src="assets/img/generic/rectangle-3.jpg">
                </div>
                <div class="tabs-panel" id="kids">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                </div>
                <div class="tabs-panel" id="computers">
                    <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include("php/layout/footer.php") ?>