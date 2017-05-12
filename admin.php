<?php
$pagename = "admin panel";
include("php/layout/header.php");
include("php/layout/breadcrumbs.php");
?>

<main class="row">
    <ul class="tabs" id="admintabs" data-tabs>
        <li class="tabs-title"><a href="#beheer">catogrie beheer</a></li>
        <li class="tabs-title"><a href="#betalingen">betaalgegevens</a></li>
        <li class="tabs-title"><a href="#test">test</a></li>
    </ul>

    <div class="tabs-content" data-tabs-content="admintabs">
        <div class="tabs-panel" id="beheer">
            <p>Test123</p>
        </div>
        <div class="tabs-panel" id="betalingen">
            <p>Test123</p>
        </div>
        <div class="tabs-panel" id="test">
            <p>Test123</p>
        </div>
    </div>
</main>
    

<?php
include("php/layout/footer.php")
?>