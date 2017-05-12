<?php
$pagename = "admin panel";
include("php/layout/header.php");
include("php/layout/breadcrumbs.php");
?>

<main class="row">
    <ul class="tabs" id="admintabs" data-tabs>
        <li class="tabs-title is-active"><a href="#overzicht">overzicht</a></li>
        <li class="tabs-title"><a href="#betalingen">betaalgegevens</a></li>
        <li class="tabs-title"><a href="#categorie">Categorie toevoegen</a></li>
    </ul>

    <div class="tabs-content" data-tabs-content="admintabs" data-active-collapse="true">
        <div class="tabs-panel" id="overzicht">
            <div class="row expanded">
                <h4><strong>Verkoop gegevens</strong></h4>
                <hr>
                <h5><strong>Vestiging</strong></h5>
                <p>Technovium<br>vergertlaan 10<br>9421BS<br>Nijmegen</p>
            </div>
            <div class="row expanded">
                <h4><strong>Betaal gegevens</strong></h4>
                <hr>
                <h5>Creditcard</h5>
                <p>NL 35 INGB 0004 5712 32</p>
            </div>
        </div>
        <div class="tabs-panel" id="betalingen">
            <select name="" id="">
                <option value="">Paypal</option>
                <option value="">Creditcard</option>
                <option value="">Vooruitbetaling</option>
            </select>
            <input type="text" placeholder="cardnumber">
            <div class="button" type="submit" value="Submit">Submit</div>
        </div>
        <div class="tabs-panel" id="categorie">
            <div class="row expanded" style="margin-top:0;">
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