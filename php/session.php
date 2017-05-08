<?php
session_start();// Starting Session

//kijkt of er een resultaat is gevonden en of succesvol het object user wordt aangemaakt
if (isset($_SESSION['email'])) {
    $email_check = $_SESSION['email'];
    if ($user = new User($email_check)) {

    }
}
?>