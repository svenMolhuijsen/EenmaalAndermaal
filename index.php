<?php 
//page variables
$pagename = "home";

include("php/core.php");
include("php/layout/header.php");
?>
<main>
    <div class="banner">
        <!-- Groet -->
        <div class="row" id="indexTriggerText">
            <h3><span>Eenmaal-Andermaal</span> Koop een uniek geschenk<br>of verkoop je eigen spullen</h3>
        </div>
        <div class="row" style="padding-bottom:100px;">
            <div class="small-up-1 medium-up-3 columns-12 big-search">
                <div class="column column-block" id="blocks">
                    <input type="text" placeholder="zoekterm">
                </div>
                <div class="column column-block categorieselect" id="blocks">

                </div>
                <div class="column column-block" id="blocks">
                    <input type="submit" class="button submit" value="submit">
                </div>
            </div>
        </div>
    </div>
  <div class="veilingen row">
    <div class="clearfix">
        <!-- Trending sectie -->
      <h4 class="float-left" id="trending">Trending</h4>
      <a href="filterpagina.php" class="button hollow float-right">view more ></a>
    </div>
    <hr>
    <div class="trendingData small-up-2 medium-up-3 large-up-6 columns-12" data-equalizer>
    </div>
  </div>
</main>


<?php include("php/layout/footer.html"); ?>
<script>
    //Haalt trending op
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