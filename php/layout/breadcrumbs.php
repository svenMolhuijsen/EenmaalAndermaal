<div class="column row hide-for-small-only">
    <ul class="breadcrumbs">
        <li><a href="/">Home</a></li>
        <?php
        if(strpos($pagename, "Veiling") !== false){
            $categorie = executeQuery("SELECT * FROM categorie WHERE categorieId = ?", [$veiling->getCategorieId()])['data'][0];
            echo('<li><a href="filterpagina.php?hoofdcategorie='.$categorie["categorieId"].'">'.$categorie["categorieNaam"].'</a></li>');
        }elseif(strpos($pagename, "Filters") !== false){
            $categorie = executeQuery("SELECT * FROM categorie WHERE categorieId = ?", [$_GET['hoofdcategorie']])['data'][0];
            echo('<li><a href="categoriePagina.php">'.executeQuery("SELECT categorieNaam FROM categorie WHERE categorieId = ?", [$categorie["superId"]])["data"][0]["categorieNaam"].'</a></li>');
            echo('<li><a href="categoriePagina.php">'.$categorie['categorieNaam'].'</a></li>');
        }
        ?>
        <li><a href="#"><?php echo($pagename) ?></a></li>
    </ul>
</div>