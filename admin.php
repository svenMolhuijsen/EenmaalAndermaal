<?php
$pagename = "admin panel";
include("php/core.php");
include("php/layout/header.php");
include("php/layout/breadcrumbs.php");
if(isset($_SESSION['gebruiker'])) {//isset() geeft false als niet ingelogd
    if($_SESSION['gebruiker']->getVerkoper() == 1) { //getVerkoper() staat op 1 als admin is
        include("geentoegang.php");
    }
}else {
?>

<main class="row">
    <ul class="tabs" id="admintabs" data-tabs>
        <li class="tabs-title"><a href="#overzicht">overzicht</a></li>
        <li class="tabs-title"><a href="#categorie">Categorie toevoegen</a></li>
        <li class="tabs-title is-active"><a href="#veiling">Veiling</a></li>
    </ul>

    <div class="tabs-content" data-tabs-content="admintabs" data-active-collapse="true">
        <div class="tabs-panel" id="overzicht">
            <div class="row expanded show-for-large">
                <iframe style="width:100%; height:600px;" src="https://app.powerbi.com/view?r=eyJrIjoiMzAxNzVlODktMDEyZC00NWZiLWJiYjUtNDY0ZjBjMzFjMzUyIiwidCI6ImI2N2RjOTdiLTNlZTAtNDAyZi1iNjJkLWFmY2QwMTBlMzA1YiIsImMiOjh9" frameborder="0" allowFullScreen="true"></iframe>
            </div>
        </div>
        <div class="tabs-panel categoriemanager" id="categorie">
            <?php
            include("php/layout/categorieToevoegen.php");
            ?>
        </div>
        <div class="tabs-panel" id="veiling">
        <?php
        $veilingId = '380468258025';
        $veiling = Veiling::existingVeiling($veilingId);
        ?>
            <div class="column row">
                <div class="input-group">
                    <input type="number" class="input-group-field" placeholder="veilingId">
                    <div class="input-group-button"><button class="button">Zoek</button></div>
                </div>
            </div>
            <hr>
            <div class="column row">
                <div class="float-right">
                    <button class="button secondary" data-open="verplaatsVeiling">Verplaatsen</button>
                    <button class="button warning" id="beindigd">Beïndigen</button>
                    <button class="button alert" data-open"verwijderVeiling">Verwijderen</button>
                </div>
                <div class="large reveal" id="verplaatsVeiling" data-reveal>
                    <h4>Selecteer categorie</h4>
                    <div id="categorieTwee"></div>
                    <button class="button alert" id="verplaats">Verplaats</button>
                    <button class="close-button" data-close aria-label="Close modal" type="button">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="large reveal" id="verwijderVeiling" data-reveal>
                    <h4>Weet u zeker dat u de veiling wilt verwijderen?</h4>
                    <button class="button alert" id="verwijder">Verwijder</button>
                    <button class="close-button" data-close aria-label="Close modal" type="button">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

            </div>

            <div class="row">
                <div class="columns large-8">
                    <?php
                    echo('  <div>
                                <h1>'.$veiling->getTitel().'</h1>
                                <h5>'.$veiling->getVerkoperGebruikersnaam().'</h5>
                            </div>');
                    echo('  <div>
                                <img src="http://iproject34.icasites.nl/thumbnails/'.$veiling->getThumbNail().'" alt="img">
                            </div>');
                    echo('  <div>
                                <h4>Beschrijving:</h4>
                                <p>'.$veiling->getBeschrijving().'</p>
                            </div>')
                    ?>
                </div>
                <div class="columns large-4">
                <?php
                echo('  <div>
                            <h4>Veiling eindigd op:</h4>
                            <span>'.$veiling->getEindDatum().'</span>
                        </div>')
                ?>                     
                </div>
            </div>
        </div>
    </div>
</main>
    

<?php
include("php/layout/footer.html")
?>
<script>
    $('#addCategorieToDatabase').click(function () {
        var categorie = {
            categorieNaam: $('#categorieNaam').val(),
            superId: $('.categorien').children().last().prev().find(":selected").val()
        };

        $.ajax({
            type: 'POST',
            url: 'php/api.php?action=addCategorieToDatabase',
            data: categorie,
            dataType: 'json',
            complete: function(){
                alert('Categorie toevoegen geslaagd!');
            }
        });
    });

    $('#beindigd').click(function(){
        var veiling = {
            veilingId: '<?php echo($veilingId); ?>'
        };
         $.ajax({
            type: 'POST',
            url: 'php/api.php?action=beindigveiling',
            data: veiling,
            dataType: 'json',
            complete: function(){
                alert('Veiling beïndigen geslaagd!');
            }
        });
    });

    $('#verwijder').click(function(){
        var veiling = {
            veilingId: '<?php echo($veilingId); ?>'
        };
         $.ajax({
            type: 'POST',
            url: 'php/api.php?action=verwijderVeiling',
            data: veiling,
            dataType: 'json',
            complete: function(){
                alert('Veiling verwijderen geslaagd!');
            }
        });
    });

    $('#verplaats').click(function(){
        var veiling = {
            veilingId: '<?php echo($veilingId);?>',
            categorieId: $('#categorieTwee').children().last().prev().find(":selected").val()
        };
        $.ajax({
            type: 'POST',
            url: 'php/api.php?action=verplaatsVeiling',
            data: veiling,
            dataType: 'json',
            complete: function(){
                alert('Veiling verplaatsen geslaagd!');
            }
        });
    });



</script>
</body>
</html>
    <?php
}
include("php/layout/footer.html");
?>