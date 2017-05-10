<?php
include("core.php");
//wanneer api call wordt gedaan
if (!empty($_GET['action'])) {
    $action = $_GET['action'];
    switch ($action) {
        // Inloggen
        case 'login':
            $params = array($_POST['mail'], $_POST['password']);
            login($params);
            break;
        // Uitloggen
        case 'logout':
            logout();
            break;

        // Wachtwoord vergeten
        case 'forgotPassword':
            $params = array($_POST['mail']);
            forgotPassword($params);
            break;

        // Wachtwoord wijzigen
        case 'changePassword':
            $params = array($_POST['oldPassword'], $_POST['newPassword']);
            changePassword($params);
            break;

        default:
            header('HTTP/1.0 404 NOT FOUND');
            break;
    }
}

// Inloggen
function login($params)
{
    // JSON decoden
    $params = json_decode($params);

    // Variabelen uit object halen
    $mail = $params->mail;
    $password = $params->password;

    if (empty($mail) || empty($password)) {
        $a_result = array('status' => 'unsuccessful');
    }

    //Selecteert dit email uit de database
    $query = $pdo->prepare("SELECT * FROM Customer WHERE customer_mail_address=?");
    $query->execute(["$userMail[1]"]);
    $result = $query->fetch();

    if (password_verify($password[1], $result["password"])) {
        $_SESSION['email'] = $mail;

        // Gelukt
        $a_result = array('status' => 'success',);
    }

    // Resultaat terugsturen
    echo json_encode($a_result);
}

function logout()
{
    session_destroy();
    if ($_SESSION != null) {
        $a_result = ['status' => 'unsuccessful'];
    } else {
        $a_result = ['status' => 'success'];
    }
    echo json_encode($a_result);
}

//opvragen categoriën
function getMainCategories(){
    $query = "SELECT c.categorieNaam FROM categorie c WHERE superId IS NULL";
    $result = executeQuery($query);
    var_dump($result);
}