$(document).foundation();
var currCategory = null;
$(document).ready(function () {


//////////////////////////////////////////////
//    login Modal
/////////////////////////////////////////////
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
});

//////////////////////////////////////////////
//  Functions
/////////////////////////////////////////////
function generateCategorySelect($childtarget, $target, category, selected) {
    $.post("/php/api.php?action=getCategories", {hoofdCategory: category}, function (result) {
        // JSON result omzetten naar var
        var res = JSON.parse(result);
        if (res.code == 0) {
            $select = $("<select data-superid='" + category + "' class='categorieLijst' name='" + category + "' required></select>");
            $($select).append("<option value='" + category + "' disabled selected>Categorie selecteren</option>");

            $.each(res.data, function (index, item) {
                if (selected == item["categorieId"]) {
                    $($select).append("<option selected value='" + item['categorieId'] + "'>" + item['categorieNaam'] + "</option>");
                } else {
                    $($select).append("<option value='" + item['categorieId'] + "'>" + item['categorieNaam'] + "</option>");
                }
            });
            $childtarget.append($select);
        }

        $($childtarget).change(function () {
            var value = $($childtarget).find(":selected").val();
            currCategory = value;
            generateParentCategories(value, $target);
            zoeken();
        });
    });
}

function generateParentCategories(category, target) {
    target.empty();
    $(target).unbind("change");
    $.post("/php/api.php?action=getParentCategories", {category: category}, function (result) {
        // JSON result omzetten naar var
        var res = JSON.parse(result);

        // Kijken of het result true is
        if (res.code == 0) {
            var parents = res["data"];
            var inverse = 0;
            for (var i = parents.length - 1; i >= 0; i--) {
                //eerst container aanmaken zodat het in de goede volgorde wordt aangemaakt
                target.append("<div class='" + inverse + "'></div>");
                var childtarget = $('.' + inverse, target);

                generateCategorySelect(childtarget, target, parents[i]['superId'], parents[i]['categorieId']);

                inverse++;
                if (i == 0) {
                    target.append("<div class='" + inverse + "'></div>")
                    var childtarget = $('.' + inverse, target);
                    generateCategorySelect(childtarget, target, category, null);
                }
            }
        } else {
            generateCategorySelect(target, target, null, null);
        }

    });
}

function veiling(target, result) {
    var res = JSON.parse(result);
    $(target).empty();
    if (res.code === 0) {
        $.each(res.data, function (index, item) {
            console.log(target);
            $(target).append('<div class="column small-6 medium-4 veiling" data-equalizer-watch><div class="inner">' +
                '<a href="veilingpagina.php?veilingId=' + item['veilingId'] + '"><div class="image" style="background-image: url(http://iproject34.icasites.nl/' + item["thumbNail"] + ')"></div>' +
                '<div class="omschrijving"><div class="button primary">Bied mee!</div>' +
                '<div class="titel">' + item["titel"] + '</div> ' +
                '<div class="bod">&euro;' + (item["hoogsteBieding"] > item["startPrijs"] || item["hoogsteBieding"] == null ? item["startPrijs"] : item["hoogsteBieding"]) + '</div> ' +
                '<br></div> ' +
                '</a><div class="clock eindtijd-' + item["veilingId"] + '"></div></div></div></div>');
            createCountdown($(".eindtijd-" + item["veilingId"]), item["eindDatum"]);
        });

        //$(target).foundation('destroy');
        new Foundation.Equalizer($(target)).getHeightsByRow();
    }
    $(target).append('<div class="column veiling" data-equalizer-watch>' +
        "<div class='callout warning'> " +
        "<h5>Niets gevonden</h5> " +
        "<p>Er is waarschijnlijk een database probleem</p> " +
        "</div></div></div>");
}

var searchRequestcounter = 0;
function zoeken(page = 0, newIndex = false) {
    var minBedrag = $('#sliderOutput1').val();
    var maxBedrag = $('#sliderOutput2').val();
    var searchterm = $('#searchterm').val();
    var categorie = currCategory;
    var sortering = $("#sortering").find(":selected").val();
    searchRequestcounter++;
    requestNumber = searchRequestcounter;
    $.post("/php/api.php?action=search", {
        category: categorie,
        minprice: minBedrag,
        maxprice: maxBedrag,
        searchterm: searchterm,
        sortering: sortering,
        page: page,
        numrows: 12
    }, function (result) {
        if (requestNumber == searchRequestcounter) {
            //to make sure only the last query is displayed
            var target = ".veilingen .row";
            veiling(target, result);
        }
    });
    if (newIndex) {
        console.log("geactiveerd")
        createPageIndex();
    }
}

var pageIndexCounter = 0;
function createPageIndex() {
    var minBedrag = $('#sliderOutput1').val();
    var maxBedrag = $('#sliderOutput2').val();
    var searchterm = $('#searchterm').val();
    var categorie = currCategory;
    var sortering = $("#sortering").find(":selected").val();
    pageIndexCounter++;
    requestNumber = pageIndexCounter;
    $.post("/php/api.php?action=getNumRows", {
        category: categorie,
        minprice: minBedrag,
        maxprice: maxBedrag,
        searchterm: searchterm,
        sortering: sortering
    }, function (result) {
        var res = JSON.parse(result);
        console.log(res);
        if (pageIndexCounter == requestNumber) {
            pages = Math.ceil(parseInt(res.data["0"]['numRows']) / 12);
            $('.pagination').jqPagination('option', 'max_page', pages);
        }
    });
}

function createCountdown($target, countDownDate) {

    setInterval(function () {

        // Get todays date and time
        var now = new Date().getTime();
        // Find the distance between now an the count down date
        var distance = new Date(countDownDate).getTime() - now;

        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Output the result in an element with id="timer"
        $target.html(days + "d " + hours + "h "
            + minutes + "m " + seconds + "s ");

        // If the count down is over, write some text
        if (distance < 0) {
            clearInterval(x);
            $("#timer").html("VERLOPEN");
            $("#expired").html("");
        }
    }, 1000);
}

function getURLParameter(name) {
    return decodeURIComponent((new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(location.search) || [null, ''])[1].replace(/\+/g, '%20')) || null;
}

$(document).ready(function () {
//////////////////////////////////////////////
//  Navbar
/////////////////////////////////////////////
    if ($('#navigatie-menu').length != 0) {
        var target = $('#navigatie-menu .categorie');
        generateCategorySelect(target, null, null, null);
        $('#navigatie-menu .menu button.submit').click(function () {
            var searchterm = $('#navigatie-menu .menu input').val();
            var categorie = $('#navigatie-menu .categorie select').val();
            document.location["href"] = "filterpagina.php?searchterm=" + searchterm + "&hoofdcategorie=" + categorie;
        });
    }
//////////////////////////////////////////////
//  Inloggen/registreren
/////////////////////////////////////////////
    $('#login input[type="submit"]').on('click', function () {
        var url = "/php/api.php?action=login";

        var wachtwoord = $('#login #signin-password').val();
        var gebruikersnaam = $('#login #signin-username').val();

        $.post(url, {gebruikersnaam: gebruikersnaam, wachtwoord: wachtwoord}, function (result) {
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

                location.reload();
            }
            else {
                //oude foutmeldingen verwijderen, en laatste foutmelding weergeven
                $('.signin-register-modal .callout').remove();
                $('#loginForm').append("<div class='column callout alert'>" + res.message + "</div>");
            }
        });
    });

    $('#logoutButton').on('click', function(){
        $.ajax({
            dataType: 'json',
            url: 'php/api.php?action=logout',
            success: function(data){
                if(data.loggedOut) {
                    window.location.replace("http://iproject34.icasites.nl");
                }
                else{
                    alert('Logout failed!');
                }
            }
        });
    });

//////////////////////////////////////////////
//  Validation
/////////////////////////////////////////////
    jQuery.validator.addMethod("greaterThanDate",
        function (value, element, params) {

            if (!/Invalid|NaN/.test(new Date(value))) {
                return new Date(value) > params;
            }

            return isNaN(value) && isNaN(params)
                || (Number(value) > Number(params));
        },
        'Voer een latere datum in.'
    );

    jQuery.validator.addMethod("lessThanDate",
        function (value, element, params) {

            if (!/Invalid|NaN/.test(new Date(value))) {
                return new Date(value) < params;
            }

            return isNaN(value) && isNaN(params)
                || (Number(value) < Number(params));
        },
        'Voer een eerdere datum in.'
    );

    var errorCSS = {
        'position': 'absolute',
        'font-size': '70%',
        'margin-bottom': '0',
        'bottom': '0',
        'right': '0'
    };

    jQuery.validator.setDefaults({
        errorClass: 'validationError',
        errorElement: 'strong',
        focusCleanup: true,
        focusInvalid: false,
        highlight: function (element) {
            $(element).addClass('is-invalid-input validationError');
        },
        unhighlight: function (element) {
            $(element).removeClass('is-invalid-input validationError');
        },
        errorPlacement: function(error, element) {
            error.appendTo(element.prev());
            error.addClass('hide-for-small show-for-large');

            error.css(errorCSS);
            error.parent().css('position', 'relative');
        }
    });

    var eighteenYearsAgo = new Date();
    eighteenYearsAgo.setFullYear(eighteenYearsAgo.getFullYear() - 18);

    $('#registerForm').validate({
        rules: {
            'gebdate': {lessThanDate: eighteenYearsAgo},
            'repeat-password': {equalTo: "#register-password"}
        },
        messages: {
            'repeat-password': {equalTo: "Vul hetzelfde wachtwoord in."},
            'tel': {pattern: "Foutief patroon."},
            'postcode': {pattern: "Foutief patroon."}
        }
    });

    $('#resetForm').validate();

//////////////////////////////////////////////
//  Categoriepagina
/////////////////////////////////////////////
    if ($('#categoriepagina').length != 0) {
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
    }

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
        var searchterm = getURLParameter('searchterm');
        searchterm != null ? $("#searchterm").val(searchterm) : null;
        var category = getURLParameter('hoofdcategorie');
        var target = $('#filterpagina aside .filter .categorien');
        generateParentCategories(category, target);
        currCategory = category;

        $('.pagination').jqPagination({
            paged: function (pages) {
                zoeken(pages - 1);
            }
        });

        $('.filter .slider').on('changed.zf.slider', function () {
            createPageIndex();
            $('.pagination').jqPagination('option', 'current_page', 1);
            zoeken(0, true);
        });
        $('#searchterm').on('keyup', function () {
            createPageIndex();
            $('.pagination').jqPagination('option', 'current_page', 1);
            zoeken(0, true);
        });
        $("#sortering").change(function () {
            createPageIndex();
            $('.pagination').jqPagination('option', 'current_page', 1);
            zoeken(0, true);
        });
        zoeken(0, true);
    }

    generateParentCategories(null, $('#categorie'));
    generateParentCategories(null, $('#categorieToevoegen form .categorien'));
    generateParentCategories(null, $('#categorieTwee'));

});