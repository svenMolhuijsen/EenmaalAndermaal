<?php
$pagename = "categorie";
include("php/api.php");
include("php/layout/header.php");
include("php/layout/breadcrumbs.php");
?>

<hr>
<div class="large-8 row categoriepagina">
    <div class="side-nav-block medium-3 large-3 columns">
        <ul class="side-nav accordion hoofdcategorien" data-accordion="vdmumf-accordion" data-allow-all-closed="true"
            data-multi-expand="false" role="tablist">

        </ul>
    </div>
    <div class="medium-9 large-9 columns">
        <div class="row data-equalizer align-middle subcategorien hide-for-small-only">

        </div>
    </div>
</div>
<hr>
<div class="row" id="categoriepagina">
    <div class="clearfix">
        <h4 class="float-left">Populaire producten</h4>
        <!--<a href="#" class="button hollow float-right">view more ></a>!-->
    </div>
    <div class="small-up-2 medium-up-3 large-up-6 columns-12 clearfix">
        <div class="column column-block"><a href="#"><img src="http://placehold.it/150x300" alt="">
                <div>Apple Iphone 4S<br>€499</div>
            </a></div>
        <div class="column column-block"><a href="#"><img src="http://placehold.it/150x300" alt="">
                <div>Beats Solo 2<br>€299</div>
            </a></div>
        <div class="column column-block"><a href="#"><img src="http://placehold.it/150x300" alt="">
                <div>MBP late 2015 13"<br>€1299</div>
            </a></div>
        <div class="column column-block"><a href="#"><img src="http://placehold.it/150x300" alt="">
                <div>Dell XPS 15 2015<br>€1499</div>
            </a></div>
        <div class="column column-block"><a href="#"><img src="http://placehold.it/150x300" alt="">
                <div>Microsoft Office 2016<br>€3,99</div>
            </a></div>
        <div class="column column-block"><a href="#"><img src="http://placehold.it/150x300" alt="">
                <div>Kaarsen<br>€4,99</div>
            </a></div>
    </div>
</div>
<?php include("php/layout/footer.php") ?>
<!-- script>
    function updateSubCategorie(){
        var activeCategorie = $('.side-nav a[aria-expanded="true"]').attr('rel');

        /*$.ajax({
            type: "GET",
            url: 'php/api.php',
            data: {action: 'categorie', arguments: [activeCategorie]},
            success: function() {

            }
        });*/

        /*for(i = 0; i < subcategorieen.length; i++){
         document.getElementById("subCategorie").innerHTML("test");
         }*/
    }
</script -->
