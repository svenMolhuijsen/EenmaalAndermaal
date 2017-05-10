<?php 
//page variables
$pagename = "home";

include("php/core.php");
include("php/layout/header.php");
?>
<main>
  <div class="row" id="indexTriggerText">
    <h3><span>Eenmaal-Andermaal</span> Koop een uniek geschenk<br>of verkoop je eigen spullen</h3>
  </div>


  <div class="row" style="padding-bottom:100px;">
    <div class="small-up-1 medium-up-3 columns-12">
      <div class="column column-block" id="blocks">
        <input type="text" placeholder="zoek">
      </div>
      <div class="column column-block" id="blocks">
        <select>
          <option value="Voertuigen">Voertuigen</option>
          <option value="Kleding">Kleding</option>
          <option value="Vakanties">Vakanties</option>
          <option value="Sport">Sport</option>
        </select>
      </div>
      <div class="column column-block" id="blocks">
        <input type="submit" class="button" value="submit">
      </div>
    </div>
  </div>

  <div class="row">
    <div class="clearfix">
      <h4 class="float-left" id="trending">Trending</h4>
      <a href="#" class="button hollow float-right">view more ></a>
    </div>
    <hr>
    <div class="small-up-2 medium-up-3 large-up-6 columns-12 clearfix">
      <div class="column column-block"><a href="#"><img src="http://placehold.it/150x300" alt=""><div>Apple Iphone 4S<br>€499</div></a></div>
      <div class="column column-block"><a href="#"><img src="http://placehold.it/150x300" alt=""><div>Beats Solo 2<br>€299</div></a></div>
      <div class="column column-block"><a href="#"><img src="http://placehold.it/150x300" alt=""><div>MBP late 2015 13"<br>€1299</div></a></div>
      <div class="column column-block"><a href="#"><img src="http://placehold.it/150x300" alt=""><div>Dell XPS 15 2015<br>€1499</div></a></div>
      <div class="column column-block"><a href="#"><img src="http://placehold.it/150x300" alt=""><div>Microsoft Office 2016<br>€3,99</div></a></div>
      <div class="column column-block"><a href="#"><img src="http://placehold.it/150x300" alt=""><div>Kaarsen<br>€4,99</div></a></div>
    </div>
  </div>
</main>


<?php include("php/layout/footer.php"); ?>
