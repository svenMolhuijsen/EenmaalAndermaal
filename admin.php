<?php
$pagename = "admin panel";
include("php/layout/header.php");
include("php/layout/breadcrumbs.php");
?>

<main class="row">
    <ul class="tabs" id="admintabs" data-tabs>
        <li class="tabs-title"><a href="#overzicht">overzicht</a></li>
        <li class="tabs-title"><a href="#betalingen">betaalgegevens</a></li>
        <li class="tabs-title"><a href="#categorie">Categorie toevoegen</a></li>
        <li class="tabs-title is-active"><a href="#veiling">Veiling</a></li>
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
        <div class="tabs-panel" id="veiling">
            <div class="row">Zoek functie</div>
            <hr>
            <div class="column row">
                <div class="float-right">
                <ul class="titel breadcrumbs">
                    <li><a href="#" style="color:#e2c30c;">Verplaatsen</a></li>
                    <li><a href="#" style="color:#e2c30c;">Beïndigen</a></li>
                    <li><a href="#"style="color:#E2222C;">Verwijderen</a></li>
                </ul>
                </div>
            </div>
            <div class="row">
                <div class="columns large-8">
                    <div>
                        <h1>Dikke BMW</h1>
                        <h5 class="subheader">John Regard - Gelderland - Netherlands</h5>
                    </div>
                    <div>
                        <img src="http://placehold.it/600x400" alt="img">
                    </div>
                    <div>
                        <h4>Beschrijving:</h4>
                        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui.</p>
                    </div>
                </div>
                <div class="columns large-4">
                    <div>
                    <h4>Veiling eindigd over:</h4>
                    <span>29d 12h 5m 46s</span>

                    </div>

                    <table class="card-section biedingen">
                        <tr>
                            <td>Carsten</td>
                            <td>€50.00</td>
                            <td>Wed 31 May 11:51:41</td>
                        </tr>
                        <tr>
                            <td>Henri</td>
                            <td>€40.00</td>
                            <td>Wed 31 May 11:20:54</td>
                        </tr>
                    </table>
                    
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
</script>
</body>
</html>