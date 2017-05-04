$(document).foundation();

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