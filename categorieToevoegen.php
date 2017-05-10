<?php
$pagename = "categorieToevoegen";
include("php/core.php");
include("php/layout/header.php");
include("php/layout/breadcrumbs.php");
?>

<main>
    <div class="row" style="padding-top:4em;">
        <input type="text" placeholder="new Categorie">
       
        <ul class="vertical menu" data-accordion-menu>
            <li>
                <a href="#">Computers</a>
                <ul class="menu vertical nested">
                <li>
                    <a href="#">Laptops</a>
                    <ul class="menu vertical nested">
                    <li class="active"><a href="#">Apple</a></li>
                    <li><a href="#">Dell</a></li>
                    <li><a href="#">Lenovo</a></li>
                    </ul>
                </li>
                <li><a href="#">Monitoren</a></li>
                <li><a href="#">Servers</a></li>
                </ul>
            </li>
            <li>
                <a href="#">Auto</a>
                <ul class="menu vertical nested">
                <li><a href="#">BMW</a></li>
                <li><a href="#">Mercedes</a></li>
                </ul>
            </li>
            <li><a href="#">Sport</a></li>
        </ul>



        <div type="submit" class="button" value="Submit">Submit</div>
    </div>
</main>

<?php
include("php/layout/footer.php");
?>