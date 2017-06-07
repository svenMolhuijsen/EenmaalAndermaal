<!doctype html>

<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eenmaal-Andermaal : <?php echo $pagename; ?></title>
    <link rel="stylesheet" crossorigin="anonymous" integrity="sha256-RYMme8QITYCPWDLzOXswkTsPu1tjeAE2Myb7Kid/JBY="
          href="https://cdn.jsdelivr.net/foundation-icons/3.0/foundation-icons.min.css">
    <link rel="stylesheet" href="/css/app.css">

    <link rel="apple-touch-icon" sizes="180x180" href="img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/favicon/favicon-16x16.png">
    <link rel="manifest" href="/img/favicon/manifest.json">
    <link rel="mask-icon" href="/img/favicon/safari-pinned-tab.svg" color="#5bbad5">
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
        <div class="menu">
            <div class="categorie">

            </div>
            <div><input type="search" placeholder="Zoekterm"></div>
            <div>
                <button type="button" class="button submit"><span class="fi-magnifying-glass"></span> Zoeken</button>
            </div>
            <div>
                <ul class="account dropdown vertical medium-horizontal menu" data-dropdown-menu>
                    <li>
                        <a href="#"><span class="fi-torso"></a>
                        <ul class="menu">
                            <?php
                            if (isset($_SESSION['gebruiker']) && !empty($_SESSION['gebruiker'])) {
                                $adminCheck = executeQuery("SELECT TOP 1 admin FROM gebruikers WHERE gebruikersnaam = ?", [$_SESSION['gebruiker']]);
                                if($adminCheck['code'] == 0) {
                                    $adminCheck = $adminCheck['data'][0];
                                }
                                if($adminCheck) {
                            ?>
                                    <li><a href="admin.php">Admin</a></li>
                                <?php } ?>
                            <li><a href="profiel.php">Mijn profiel</a></li>
                            <li><a href="aanmakenveiling.php">Nieuwe veiling</a></li>
                            <li><a href="#" id="logoutButton">Uitloggen</a></li>
                            <?php } else { ?>
                            <li><a href="#" class="login_button">Log in</a></li>
                            <li><a href="#" class="signup_button">Aanmelden</a></li>
                            <?php } ?>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php
include("php/layout/login-popup.php");
?>