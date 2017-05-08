<?php 
//page variables
$pagename = "home";

include("php/core.php");
include("php/layout/login-popup.php");
include("php/layout/header.php");
?>
<main>
  <div class="row">
    <blockquote class="text-center" style="border:none;">
    Eenmaal-Andermaal, De beste veiling site ter wereld!<cite>The Verge</cite>
    </blockquote>
  </div>


  <div class="row">
    <div class="small-up-1 medium-up-3 columns-12">
      <div class="column column-block">
        <input type="text" placeholder="zoek">
      </div>
      <div class="column column-block">
        <select>
          <option value="Voertuigen">Voertuigen</option>
          <option value="Kleding">Kleding</option>
          <option value="Vakanties">Vakanties</option>
          <option value="Sport">Sport</option>
        </select>
      </div>
      <div class="column column-block">
        <input type="submit" class="button" value="submit">
      </div>
    </div>
  </div>

  <div class="row">
    <div class="clearfix">
      <h4 class="float-left">Trending</h4>
      <a href="#" class="button hollow float-right">view more ></a>
    </div>
    <hr>
    <div class="small-up-2 medium-up-3 large-up-6 columns-12 clearfix">
      <div class="column column-block"><a href="#"><img src="http://placehold.it/150x300" alt="">Apple Iphone 4S<br>€499</a></div>
      <div class="column column-block"><a href="#"><img src="http://placehold.it/150x300" alt="">Beats Solo 2<br>€299</a></div>
      <div class="column column-block"><a href="#"><img src="http://placehold.it/150x300" alt="">MBP late 2015 13"<br>€1299</a></div>
      <div class="column column-block"><a href="#"><img src="http://placehold.it/150x300" alt="">Dell XPS 15 2015<br>€1499</a></div>
      <div class="column column-block"><a href="#"><img src="http://placehold.it/150x300" alt="">Microsoft Office 2016<br>€3,99</a></div>
      <div class="column column-block"><a href="#"><img src="http://placehold.it/150x300" alt="">Kaarsen<br>€4,99</a></div>
    </div>
  </div>
</main>


<?php include("php/layout/footer.php") ?>
