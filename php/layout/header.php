<!doctype html>

<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eenmaal-Andermaal : <?php echo $pagename; ?></title>
    <link rel="stylesheet" crossorigin="anonymous" integrity="sha256-RYMme8QITYCPWDLzOXswkTsPu1tjeAE2Myb7Kid/JBY="
          href="https://cdn.jsdelivr.net/foundation-icons/3.0/foundation-icons.min.css">
    <link rel="stylesheet" href="css/app.css">

    <link rel="apple-touch-icon" sizes="180x180" href="img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/favicon/favicon-16x16.png">
    <link rel="manifest" href="img/favicon/manifest.json">
    <link rel="mask-icon" href="img/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="theme-color" content="#ffffff">
</head>
<body>

<div class="title-bar" data-responsive-toggle="navigatie-menu" data-hide-for="medium">
    <button class="menu-icon" type="button" data-toggle></button>
    <span class="title-bar-title"><a href="/"><img src="img/logo/logo-sm.svg" alt="" class="brand-logo"></a></span>
</div>

<div class="top-bar" id="navigatie-menu">
    <div class="top-bar-left">
        <ul class="dropdown vertical medium-horizontal menu" data-dropdown-menu>
            <li class="hide-for-small-only"><a href="/"><img src="img/logo/logo.svg" alt="" class="brand-logo"></a></li>
            <li><a href="categoriepagina.php">Bekijk Categorieën</a></li>
        </ul>
    </div>
    <div class="top-bar-right">
        <?php $page = false;
        if ($page == 'account') { ?>
            <ul class="dropdown vertical medium-horizontal menu" data-dropdown-menu>
                <li><a href="#">Profile</a>
                    <ul class="menu">
                        <li><a href="#">Informatie</a></li>
                        <li><a href="#">Nieuwe verkoop</a></li>
                        <li><a href="#">Aankopen</a></li>
                        <li><a href="#">logout</a></li>
                    </ul>
                </li>
            </ul>

        <?php } else { ?>
            <div class="menu">
                <div>
                    <select>
                        <option value="Categorie">Kies categorie</option>
                        <optgroup label="Swedish Cars">
                            <option value="volvo">Volvo</option>
                            <option value="saab">Saab</option>
                        </optgroup>
                        <optgroup label="German Cars">
                            <option value="mercedes">Mercedes</option>
                            <option value="audi">Audi</option>
                        </optgroup>
                        <optgroup label="Swedish Cars">
                            <option value="volvo">Volvo</option>
                            <option value="saab">Saab</option>
                        </optgroup>
                        <optgroup label="Swedish Cars">
                            <option value="volvo">Volvo</option>
                            <option value="saab">Saab</option>
                        </optgroup>
                        <optgroup label="Swedish Cars">
                            <option value="volvo">Volvo</option>
                            <option value="saab">Saab</option>
                        </optgroup>
                    </select>
                </div>
                <div><input type="search" placeholder="Zoekterm"></div>
                <div>
                    <button type="button" class="button"><span class="fi-magnifying-glass"></span> Zoeken</button>
                </div>
                <div><a href="#" class="login_button button hollow">Log in</a></div>
                <div><a href="#" class="signup_button button">Aanmelden</a></div>


                <!--<li>
                  <div class="input-group">
                    <span class="input-group-label">$</span>
                    <input type="text" class="input-group-field">
                    <div class="input-group-button">
                      <input type="submit" class="button" value="submit">
                    </div>
                  </div>
                </li>-->
            </div>

        <?php } ?>

    </div>
</div>

<?php
include("php/layout/login-popup.php");
?>