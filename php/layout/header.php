<!doctype html>

<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eenmaal-Andermaal : <?php echo $pagename; ?></title>
    <link rel="stylesheet" crossorigin="anonymous" integrity="sha256-RYMme8QITYCPWDLzOXswkTsPu1tjeAE2Myb7Kid/JBY=" href="https://cdn.jsdelivr.net/foundation-icons/3.0/foundation-icons.min.css">
    <link rel="stylesheet" href="css/app.css">
</head>
<body>

<div class="title-bar" data-responsive-toggle="navigatie-menu" data-hide-for="medium">
  <button class="menu-icon" type="button" data-toggle></button>
  <span class="title-bar-title"><a href="index.php"><img src="/img/logo-sm.svg" alt="" class="brand-logo"></a></span>
</div>

<div class="top-bar" id="navigatie-menu">
  <div class="top-bar-left">
    <ul class="dropdown vertical medium-horizontal menu" data-dropdown-menu>
      <li class="hide-for-small-only"><a href="index.php"><img src="/img/logo.svg" alt="" class="brand-logo"></a></li>
      <li><a href="#">Categoriën</a></li>
      <li><a href="#">FAQ</a></li>
      <li><a href="#">Contact</a></li>
    </ul>
  </div>
  <div class="top-bar-right">
    <ul class="menu">
        <li><a href="#" onclick="showSignIn()" class="login_button button hollow">Log in</a></li>
        <li><a href="#" onclick="showRegister()" class="signup_button button">Sign Up</a></li>
      <li>
        <div class="input-group">
          <span class="input-group-label">$</span>
          <input type="text" class="input-group-field">
          <div class="input-group-button">
            <input type="submit" class="button" value="submit">
          </div>
        </div>
      </li>
    </ul>
  </div>
</div>
