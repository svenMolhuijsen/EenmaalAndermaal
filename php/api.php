<?php
include("core.php");
//wanneer api call wordt gedaan
if (!empty($_GET['action'])) {
    $action = $_GET['action'];
    switch ($action) {
        // Inloggen
        case 'login':
            $params = array(
                'email' => $_POST['email'],
                'password' => $_POST['password']);
            login($params);
            break;
        // Uitloggen
        case 'logout':
            logout();
            break;
        default:
            header('HTTP/1.0 404 NOT FOUND');
            break;
    }
}

// Inloggen
function login($params)
{
    // Variabelen uit object halen
    $mail = $params["email"];
    $password = $params["password"];
    global $user;
    $response = null;

    if (empty($mail) || empty($password)) {
        $response = ['status' => 'error', "message" => "Een van de velden is niet ingevuld"];
    } else {
        $result = executeQuery("SELECT email, wachtwoord FROM gebruikers WHERE email = ?", [$mail]);
        if ($result['code'] == 0) {
            if (password_verify($password, $result['data'][0]["wachtwoord"])) {
                //gebruiker gevonden en wachtwoord klopt
                $_SESSION['email'] = $mail;
                $user = new User($_SESSION['email']);
                $response = ['status' => 'success', 'code' => 0, 'message' => 'succesvol ingelogd'];
            } else {
                //wanneer gebruiker gevonden is, maar het wachtwoord niet klopt
                $response = ['status' => 'error', 'code' => 3, 'message' => 'logingegevens kloppen niet'];
            }
        } else {
            $response = $result;
        }
    }
    stuurTerug($response);

}

function logout()
{
//    session_destroy();
//    if ($_SESSION != null) {
//        $a_result = ['status' => 'unsuccessful'];
//    } else {
//        $a_result = ['status' => 'success'];
//    }
//    echo json_encode($a_result);
}

function stuurTerug($data)
{
    global $user;
    if ($user == null) {
        $response = array_merge(['login' => false], $data);
    } else {
        $response = array_merge(['login' => true, 'user' => $user->toArray()], $data);
    }
    echo json_encode($a_result);
}

//opvragen categoriën
function getMainCategories(){
    $query = "SELECT c.categorieNaam FROM categorie c WHERE superId IS NULL";
    $result = executeQuery($query);
    var_dump($result);
}