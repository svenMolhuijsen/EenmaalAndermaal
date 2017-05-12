<?php
$pagename = "admin panel";
include("php/layout/header.php");
include("php/layout/breadcrumbs.php");
?>

<main class="row">
    <ul class="tabs" id="admintabs" data-tabs>
        <li class="tabs-title"><a href="#beheer">beheer</a></li>
        <li class="tabs-title"><a href="#betalingen">betaalgegevens</a></li>
        <li class="tabs-title"><a href="#categorie">Categorie toevoegen</a></li>
    </ul>

    <div class="tabs-content" data-tabs-content="admintabs">
        <div class="tabs-panel" id="beheer">
            <p>Test123</p>
        </div>
        <div class="tabs-panel" id="betalingen">
            <p>Test123</p>
        </div>
        <div class="tabs-panel" id="categorie">
            <div class="row expanded" style="padding-top:4em;">
                <input type="text" placeholder="new Categorie">
            
                <ul class="vertical menu" data-accordion-menu data-multi-expand="false">
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
        </div>
    </div>
</main>
    

<?php
include("php/layout/footer.php")
?>