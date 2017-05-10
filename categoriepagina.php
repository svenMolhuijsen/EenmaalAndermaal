<?php
$pagename = "categorie";
include("php/api.php");
include("php/layout/header.php");
?>

<hr>
    <div class="large-8 row categoriepagina">
        <?php categorieAccordion(); ?>
        <div class="medium-9 large-9 columns">
            <div class="row medium-up-4 large-up-5 show-for-medium">
                <?php
                $subcategorien = executeQuery("SELECT * FROM categorie WHERE superId IS NOT NULL");
                if($subcategorien['code'] == 0){
                    for($i = 0; $i < count($subcategorien['data']); $i++){
                        $subcategorie = $subcategorien['data'][$i];
                        echo('<div class="column">');
                        echo('<img rel="categorie-'.$subcategorie['superId'].'" class="categorieImage thumbnail" src="http://placehold.it/600x600">');
                        echo('</div>');
                    }
                }
                ?>
            </div>
        </div>
    </div>

    <hr>
<div class="row">
    <div class="clearfix">
        <h4 class="float-left">Populaire producten</h4>
        <!--<a href="#" class="button hollow float-right">view more ></a>!-->
    </div>
    <div class="small-up-2 medium-up-3 large-up-6 columns-12 clearfix">
        <div class="column column-block"><img src="http://placehold.it/150x300" alt=""><h3>Product naam</h3><br>Test</div>
        <div class="column column-block"><img src="http://placehold.it/150x300" alt=""><h3>Product naam</h3><br>Test</div>
        <div class="column column-block"><img src="http://placehold.it/150x300" alt=""><h3>Product naam</h3><br>Test</div>
        <div class="column column-block"><img src="http://placehold.it/150x300" alt=""><h3>Product naam</h3><br>Test</div>
        <div class="column column-block"><img src="http://placehold.it/150x300" alt=""><h3>Product naam</h3><br>Test</div>
        <div class="column column-block"><img src="http://placehold.it/150x300" alt=""><h3>Product naam</h3><br>Test</div>
    </div>
</div>

<?php include("php/layout/footer.php") ?>