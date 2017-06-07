<?php
$pagename = "Password recovery";

include("php/core.php");
include("php/layout/header.php");
include("php/layout/breadcrumbs.php");

if (!isset($_GET['t'])){
     include("php/layout/geentoegang.html");
} else {
  $vervalDatum = executeQuery("SELECT expire_Date FROM password_recovery where token = ?",[$_GET['t']]);
  if ($vervalDatum['data'][0]["expire_Date"] > date("Y-m-d h:i:s")){
?>
<main>
    <div class="columns row text-center" id="content">
        <h2>U kunt hier uw wachtwoord veranderen</h2>
        <div class="input-group">
            <input type="password" class="input-group-field" placeholder="New password" id="NEWPassword">
            <div class="input-group-button">
                <input type="submit" class="button" id="veranderWachtwoord">
            </div>
        </div>
    </div>
</main>
<?php
  } else{
      include("php/layout/geentoegang.html");
  }
}
include("php/layout/footer.html");
?>
<script>
    $('#veranderWachtwoord').click(function(){
        var data = {
            nieuwWachtwoord: $('#NEWPassword').val(),
            token: "<?php echo($_GET['t'])?>"
        }
        $.ajax({
            type: 'POST',
            url: 'php/api.php?action=veranderWachtwoord',
            data: data,
            dateType: 'json',
            complete: function(){
                $('#content').empty();
                $('#content').append("<h4>Wachtwoord is gewijzigd!</h4>");
            }
        });
    });

</script>
</body>
</html>