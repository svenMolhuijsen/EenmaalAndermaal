$(document).foundation();

//////////////////////////////////////////////
//    login Modal
/////////////////////////////////////////////

//Modal afsluiten
$(".signin-register-modal").click(function () {
    $('.signin-register-modal').fadeOut(300);
}).children().click(function (e) {
    return false;
});

//inlog-pop modal openen
$('.login_button, .signin').on('click', function () {
    showModal();
    showSignIn();
});

//registreer modal openen
$('.signup_button, .register').on('click', function () {

    showModal();
    showRegister();
});
//reset modal openen
$('.reset').on('click', function () {
    showReset();
});

//achtergrond en venster openen
function showModal() {
    $('.signin-register-modal').fadeIn(300);
}

//het openen van inlog scherm binnen het modal
function showSignIn() {
    $('#register, #reset').hide();
    $('#login').show();
    $('.switcher').children().removeClass("active");
    $('.switcher .signin').addClass("active");
}
//het openen van registreren scherm binnen het modal
function showRegister() {
    $('#login, #reset').hide();
    $('#register').show();
    $('.switcher').children().removeClass("active");
    $('.switcher .register').addClass("active");
}

//het openen van reset scherm binnen het modal
function showReset() {
    $('#login, #register').hide();
    $('.switcher').children().removeClass("active");
    $('#reset').show();
}

//////////////////////////////////////////////
//  Image gallery
/////////////////////////////////////////////

//Grote image van het product
$bigImage = $('.veilingImage .columns img');

//Wisselt de grote image met een alt image via fades
$('.altImages .column img').on('click', function(){
    var imageToShow = $(this).attr('src');
    var fadeLength = 300;

    $(this).fadeOut(fadeLength, function(){
        $(this).attr('src', $bigImage.attr('src'));
        $bigImage.attr('src', imageToShow);
        $(this).fadeIn(fadeLength);
    });

    $bigImage.fadeOut(fadeLength, function(){
        $(this).fadeIn(fadeLength);
    });
});

//////////////////////////////////////////////
//  Forms versturen
/////////////////////////////////////////////
$('#login input[type="submit"]').on('click', function () {
    var url = "/IProject/php/api.php?action=login"; // the script where you handle the form input.

    var password = $('#login #signin-password').val();
    var email = $('#login #signin-email').val();

    $.post(url, {email: email, password: password}, function (result) {
        // JSON result omzetten naar var
        var res = JSON.parse(result);
        console.log(res);
        // Kijken of het result true is
        if (res.code == 0) {
            // Melding weergeven
            $('#login form').append("<div data-alert class='callout success'>" + res.message + "</div>");
            // Alle velden legen, behalve submit
            $('#login input:not([type=\"submit\"])').val('');
            $('.signin-register-modal,.signin-register-modal .callout').fadeOut(300);

            //TODO: functie aanroepen die header doet veranderen
        }
        else {
            //oude foutmeldingen verwijderen, en laatste foutmelding weergeven
            $('.signin-register-modal .callout').remove();
            $('#login form').append("<div data-alert class='callout alert'>" + res.message + "</div>");
        }
    });
});

//////////////////////////////////////////////
//  Validation
/////////////////////////////////////////////

$('#registerForm').validate({
    errorClass: 'validationError',
    rules: {
        'repeat-password': { equalTo: "#register-password" }
    },
    messages: {
        'repeat-password': { equalTo: "Vul hetzelfde wachtwoord in."},
        'tel': { pattern: "Foutief patroon." },
        'postcode': { pattern: "Foutief patroon." }
    }
});

$('#loginForm').validate({
    errorClass: 'validationError'
});

$('#resetForm').validate({
    errorClass: 'validationError'
});


//////////////////////////////////////////////
//  Categoriepagina
/////////////////////////////////////////////
$hoofdcategorie = $('.hoofdcategorie');

$hoofdcategorie.on('click', function(){
    var categorie = $(this).attr('rel');
    $categorieImages = $('div[rel="' + categorie + '"].categorieImage');
    $categorieImages.fadeToggle(300, function(){
    });
});

//////////////////////////////////////////////
//  VeilingPagina
/////////////////////////////////////////////
var veilingId = $(location).attr('href').substring($(location).attr('href').indexOf('=') + 1);
var gebruiker;

$.ajax({
    url: 'php/api.php?action=getGebruiker',
    type: 'POST',
    dataType: 'json',
    success: function(result){
        gebruiker = result;
    }
});

$biedenKnop = $('#biedenKnop');
$bedrag = $('#bedrag');

$hoogsteBedrag = $('#hoogsteBedrag');

$biedenError = $('#biedenError');
$bedragError = $('#bedragError');

$biedenKnop.on('click', function(){
    var hoogsteBod = getHoogsteBod(veilingId);
    var biedDrempel = Number(hoogsteBod['biedingsBedrag'])+bepaalBiedStap(hoogsteBod['biedingsBedrag']);

    var now = new Date($.now());
    var biedingsTijd = now.getFullYear() + "-" + (now.getMonth() + 1) + "-" + now.getDate() + " " + now.getHours() + ":" + now.getMinutes() + ":" + now.getSeconds() + "." + now.getMilliseconds();

    var bod = { veilingId: veilingId, email: gebruiker["email"],  biedingsTijd: biedingsTijd, biedingsBedrag: Math.round($bedrag.val()*100)/100 };

    if(bod['email'] != hoogsteBod['email']) {
        $biedenError.hide();

        if (bod['biedingsBedrag'] > biedDrempel) {

            $.post("php/api.php?action=bieden", bod);

            hoogsteBod = bod;
            biedDrempel = Number(hoogsteBod['biedingsBedrag']) + bepaalBiedStap(hoogsteBod['biedingsBedrag']);

            $hoogsteBedrag.html('€' + hoogsteBod['biedingsBedrag']);
            $bedragError.html('U Kunt niet lager bieden dan het hoogste bod, biedt minstens: €' + biedDrempel);
            $bedragError.hide();
            $bedrag.removeClass('is-invalid-input');
        }
        else {
            $bedragError.show();
            $bedrag.addClass('is-invalid-input');
        }
    }
    else{
        $biedenError.show();
    }
});

function getHoogsteBod(veilingId, bedrag){
    var response;
    var url = "php/api.php?action=biedingCheck";
    var data = {
        veilingId: veilingId
    };

    $.ajax({
        url: url,
        data: data,
        type: 'POST',
        dataType: 'json',
        async: false,
        success: function(result){
            response = result;
        }
    });

    return response;
}

function bepaalBiedStap(hoogsteBedrag){
    if(hoogsteBedrag > 50){
        if(hoogsteBedrag > 500){
            if(hoogsteBedrag > 1000){
                return 50;
            }
            return 5;
        }
        return 1;
    }
    return 0.5;
}