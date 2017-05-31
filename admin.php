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
            <div class="row expanded show-for-large">
                <iframe style="width:100%; height:600px;" src="https://app.powerbi.com/view?r=eyJrIjoiMzAxNzVlODktMDEyZC00NWZiLWJiYjUtNDY0ZjBjMzFjMzUyIiwidCI6ImI2N2RjOTdiLTNlZTAtNDAyZi1iNjJkLWFmY2QwMTBlMzA1YiIsImMiOjh9" frameborder="0" allowFullScreen="true"></iframe>
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
        <div class="tabs-panel categoriemanager" id="categorie">
            <?php
            include("php/layout/categorieToevoegen.php");
            ?>
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
</script>
</body>
</html>