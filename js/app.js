$(document).foundation();

$(document).ready(function () {


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
    $bigImage = $('.veilingImage #image');

//Wisselt de grote image met een alt image via fades
    $('.altImages .column img').on('click', function () {
        var imageToShow = $(this).attr('src');
        var fadeLength = 300;

        $(this).fadeOut(fadeLength, function () {
            $(this).attr('src', $bigImage.attr('src'));
            $bigImage.attr('src', imageToShow);
            $(this).fadeIn(fadeLength);
        });

        $bigImage.fadeOut(fadeLength, function () {
            $(this).fadeIn(fadeLength);
        });
    });

//////////////////////////////////////////////
//  Forms versturen
/////////////////////////////////////////////
    $('#login input[type="submit"]').on('click', function () {
        var basisurl = "/php/api.php?action=login"; // the script where you handle the form input.

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
            'repeat-password': {equalTo: "#register-password"}
        },
        messages: {
            'repeat-password': {equalTo: "Vul hetzelfde wachtwoord in."},
            'tel': {pattern: "Foutief patroon."},
            'postcode': {pattern: "Foutief patroon."}
        }
    });
    $('#registerForm').validate({
        errorClass: 'validationError'
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
    $hoofdcategorie = $('.categoriepagina .hoofdcategorien');

    $.post("/php/api.php?action=getCategories", {hoofdCategory: null}, function (result) {
        // JSON result omzetten naar var
        var res = JSON.parse(result);
        // Kijken of het result true is
        if (res.code == 0) {
            //correct
            $.each(res.data, function (index, value) {
                $hoofdcategorie.append('<li class="accordion-item " data-accordion-item> ' +
                    '<a href="#" data-category="' + value.categorieId + '" class="accordion-title">' + value.categorieNaam + '</a> ' +
                    '<div class="accordion-content hide-for-small-only show-for-medium-up " data-tab-content> ' +
                    'Bekijk rechts de categorien' +
                    '</div> ' +
                    '<div class="accordion-content mobile-subcategorien show-for-small-only " aria-hidden="true" data-tab-content> ' +
                    '<ul id="' + value.categorieId + '"></ul>' +
                    '</div> ' +
                    '</li>');
            });
        }
        else {
            //fout afvangen
            $hoofdcategorie.append("<li>sub categorien laden...</li>");
        }
        Foundation.reInit('accordion');
        bindClickListenercategoriePagina();
    });

    function bindClickListenercategoriePagina() {
        //Bind click listener to newly created element
        $(".categoriepagina .hoofdcategorien .accordion-item a").click(function () {
            var id = $(this).data('category');
            var $subcategorien = $(".subcategorien");

            if ($subcategorien.data('hoofdcategorie') == id) {
                $subcategorien.empty();
                $("#" + id).empty();
                $subcategorien.data('hoofdcategorie', null);

            } else {
                $subcategorien.empty();
                $("#" + id).empty();
                $subcategorien.data('hoofdcategorie', id);
                $subcategorien.append("Categorien laden...");
                $("#" + id).append("Categorien laden...");

                $.post("/php/api.php?action=getCategories", {hoofdCategory: id}, function (result) {
                    // JSON result omzetten naar var
                    var res = JSON.parse(result);
                    // Kijken of het result true is
                    if (res.code == 0) {
                        $subcategorien.empty();
                        $("#" + id).empty();
                        $.each(res.data, function (index, value) {
                            $("#" + id).append("<li><a href='filterpagina.php?hoofdcategorie=" + value.categorieId + "' class =''><img src='http://placehold.it/30x30'/> " + value.categorieNaam + "</a></li>").hide().fadeIn(500);
                        });
                        $.each(res.data, function (index, value) {
                            $subcategorien.append("<a href='filterpagina.php?hoofdcategorie=" + value.categorieId + "' data-equalizer-watch class ='column medium-6 large-3'><img src='http://placehold.it/200x200'/> " + value.categorieNaam + "</a>");
                        });
                        new Foundation.Equalizer($subcategorien).getHeightsByRow();
                    }

                });
            }
        });
    }

//////////////////////////////////////////////
//  filterpagina
/////////////////////////////////////////////
    if ($('#filterpagina').length != 0) {
        var category = getURLParameter('hoofdcategorie');
        var target = $('#filterpagina aside .filter .categorien');
        generateParentCategories(category, target);
    }

});

//////////////////////////////////////////////
//  Functions
/////////////////////////////////////////////

function generateParentCategories(category, target) {
    target.empty();
    $(target).unbind("change");
    $.post("/IProject/php/api.php?action=getParentCategories", {category: category}, function (result) {
        // JSON result omzetten naar var
        var res = JSON.parse(result);

        // Kijken of het result true is
        if (res.code == 0) {
            var parents = res["data"];
            var inverse = 0;
            console.log(parents);
            for (var i = parents.length - 1; i >= 0; i--) {
                //eerst container aanmaken zodat het in de goede volgorde wordt aangemaakt
                target.append("<div class='" + inverse + "'></div>")
                var childtarget = $('.' + inverse, target);

                generateCategorySelect(childtarget, parents[i]['superId'], parents[i]['categorieId']);
                inverse++;
                if (i == 0) {
                    var childtarget = $('.' + inverse, target);

                }
            }
        } else {
            generateCategorySelect(target, null, null);
        }

    });
}

function generateCategorySelect($target, category, selected) {
    $.post("/IProject/php/api.php?action=getCategories", {hoofdCategory: category}, function (result) {
        // JSON result omzetten naar var
        var res = JSON.parse(result);
        if (res.code == 0) {
            $select = $("<select data-superid='" + category + "'name=''></select>");
            $($select).append("<option selected value='*'>Categorie selecteren</option>");

            $.each(res.data, function (index, item) {
                if (selected == item["categorieId"]) {
                    $($select).append("<option selected value='" + item['categorieId'] + "'>" + item['categorieNaam'] + "</option>");
                } else {
                    $($select).append("<option value='" + item['categorieId'] + "'>" + item['categorieNaam'] + "</option>");
                }
            });
            $target.append($select);
        }

        $($target).change(function () {
            var value = $($target).find(":selected").val()
            generateParentCategories(value, $target);
            generateCategorySelect($target, value, null);
        });
    });
}

function getURLParameter(name) {
    return decodeURIComponent((new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(location.search) || [null, ''])[1].replace(/\+/g, '%20')) || null;
}