<head>
    <style>
        .centercrumbs {
            float: right;
            position: relative;
            left:-50%;
            text-align: left;
        }
        .centercrumbs ul {
            position: relative;
            left: 50%;
        }
        .centercrumbs ul li {
            float: left; position: relative
        }

        .titel {
            margin-top: 5%;
        }
    </style>
</head>
<?php
$pagename = "veiling";

include("php/core.php");
include("php/layout/header.php");


if(true){
    $productId = stripInput($_GET["productId"]);
    if(checkForEmpty($productId)){
        connectToDatabase();

        $product = selectRecords("SELECT * FROM veiling WHERE veilingId = ?", array($productId))->fetch();
        $verkoper = selectRecords("SELECT * FROM gebruikers WHERE gebruikerId = ?", array($product["verkoperId"]))->fetch();
    }
}
?>
<body>
<div class="row show-for-medium">
    <div class="centercrumbs">
        <ul class="breadcrumbs">
            <li><a href="#">Home</a></li>
            <li><a href="#">Veilingen</a></li>
            <li class="current"><a href="#"><?php echo($product["titel"]); ?></a></li>
        </ul>
    </div>
</div>
<div class="row">
    <div class="large-6 columns">
            <h1 class="titel"><strong><?php echo($product["titel"]); ?></strong></h1>

            <h4 class="titel"><strong>Verkoper:</strong></h4>
            <h5><?php echo($verkoper["voornaam"]." ".$verkoper["achternaam"]); ?></h5>
            <h5 class="subheader"><?php echo($verkoper["provincie"]." - ".$verkoper["plaatsnaam"]); ?></h5>

            <h4 class="titel"><strong>Omschrijving:</strong></h4>
            <h5><?php echo($product["beschrijving"]); ?></h5>
    </div>
    <div class="large-6 columns">
        <div class="row">
            <img class="thumbnail" src="http://placehold.it/300x300" height="450" width="450" style="display: block; margin: 5% auto 5% auto;">
        </div>
        <div class="row large-up-4 small-up-4">
            <div class="column">
                <img class="thumbnail" src="http://placehold.it/600x600">
            </div>
            <div class="column">
                <img class="thumbnail" src="http://placehold.it/600x600">
            </div>
            <div class="column">
                <img class="thumbnail" src="http://placehold.it/600x600">
            </div>
            <div class="column">
                <img class="thumbnail" src="http://placehold.it/600x600">
            </div>
        </div>
        <div class="row">
            <div class="large-6 columns">
                <h4><strong>Verkoop Prijs:</strong></h4>
                <h5><?php echo("€".round($product["verkoopPrijs"], 2)); ?></h5>
                <h5 class="subheader"><?php echo("Excl. €".round($product["verzendKosten"], 2)." Verzendkosten"); ?></h5>
            </div>
            <div class="large-6 columns">
                <h4><strong>Hoogste bod:</strong></h4>
                <h5><?php echo("€".round($product["startPrijs"])); ?></h5>
                <a href="#" class="button" style="width: 100%; margin: 5% 0;">Bieden</a>
            </div>
        </div>
    </div>
</div>

<?php include("php/layout/footer.php") ?>
</>
</html>