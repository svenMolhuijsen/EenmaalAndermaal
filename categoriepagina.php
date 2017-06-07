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
<div class="veilingen row">
    <div class="clearfix">
        <h4 class="float-left" id="trending">Trending</h4>
        <a href="#" class="button hollow float-right">view more ></a>
    </div>
    <hr>
    <div class="trendingData small-up-2 medium-up-3 large-up-6 columns-12">
    </div>
</div>
<?php include("php/layout/footer.html") ?>
<script>
    function trending(){
        $.post("/php/api.php?action=trending",function(result){
            var target = ".veilingen .trendingData";
            veiling(target, result);
        });
    }
    $(document).ready(function(){
        trending();
    })


</script>
</body>
</html>