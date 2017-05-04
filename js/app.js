$(document).foundation();


//Modal afsluiten
$(".signin-register-modal").click(function () {
    $('.signin-register-modal').fadeOut(300);
}).children().click(function (e) {
    return false;
});

$('.login_button, .signin').on('click', function () {
    showModal();
    showSignIn();
});
$('.signup_button, .register').on('click', function () {

    showModal();
    showRegister();
});
$('.reset').on('click', function () {
    showReset();
});

function showModal() {
    $('.signin-register-modal').fadeIn(300);
}
function showSignIn() {
    $('#register, #reset').hide();
    $('#login').show();
    $('.switcher').children().removeClass("active");
    $('.switcher .signin').addClass("active");
}

function showRegister() {
    $('#login, #reset').hide();
    $('#register').show();
    $('.switcher').children().removeClass("active");
    $('.switcher .register').addClass("active");
}

function showReset() {
    $('#login, #register').hide();
    $('.switcher').children().removeClass("active");
    $('#reset').show();
}