<?php

//Kijk of de sessie al bestaat
if (session_status() == PHP_SESSION_NONE) {
    //Start de sessie
    session_start();
}
?>