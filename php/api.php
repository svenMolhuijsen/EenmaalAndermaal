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

        case 'getCategories' :
            $hoofdCategory = null;
            $hoofdCategory = trim($_POST['hoofdCategory']);

            $params = array(
                'hoofdCategory' => $hoofdCategory
            );

            getSubCategories($params);
            break;
        case 'bieden':
            bieden($_POST);
            break;
        case 'biedingCheck':
            getHoogsteBod($_POST);
            break;
        case 'getVeilingInfo':
            getVeilingInfo($_POST);
            break;
        case 'sluitVeiling':
            sluitVeiling($_POST);
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


function getSubCategories($data)
{
    if ($data['hoofdCategory'] == null) {
        $result = executeQuery("SELECT * FROM categorie WHERE superId IS NULL");
    } else {
        $result = executeQuery("SELECT * FROM categorie WHERE superId = ? ", [$data['hoofdCategory']]);
    }
    stuurTerug($result);

}




function stuurTerug($data)
{

    global $user;
    if ($user == null) {
        $response = array_merge(['login' => false], $data);
    } else {
        $response = array_merge(['login' => true, 'user' => $user->toArray()], $data);
    }
    echo json_encode($response);

}

//genereren categorie-accordion
function categorieAccordion(){
    echo('
        <div class="side-nav-block medium-3 large-3 columns">
        <ul class="side-nav accordion" data-accordion data-allow-all-closed="true" data-multi-expand="false">
    ');

    $hoofdcategorien = executeQuery("SELECT * FROM categorie WHERE superId IS NULL");

    if($hoofdcategorien['code'] == 0) {
        for ($i = 0; $i < count($hoofdcategorien['data']); $i++) {
            $hoofdcategorie = $hoofdcategorien['data'][$i];

            echo('<li onclick="updateSubCategorie()" class="accordion-item" data-accordion-item>');
            echo('<a href="#" rel="categorie-'.$hoofdcategorie['categorieId'].'" class="hoofdcategorie accordion-title">' . $hoofdcategorie['categorieNaam'] . '</a>');
            echo('<div class="accordion-content show-for-small-only" data-tab-content>');

            $subcategorien = executeQuery("SELECT * FROM categorie WHERE superId = ?", [$hoofdcategorie['categorieId']]);

            if ($subcategorien['code'] == 0) {
                for ($j = 0; $j < count($subcategorien['data']); $j++) {
                    $subcategorie = $subcategorien['data'][$j];

                    echo('<a href="#" id="categorie-' . $subcategorie['categorieId'] . '">' . $subcategorie['categorieNaam'] . '</a>');
                }
            }
        }

        echo('</div></li></ul></div>');
    }
}

function setSubcategorien($hoofdcategorie){
    $hoofdcategorie = substr($hoofdcategorie, 12);
    $subcategorien = executeQuery("SELECT * FROM categorie WHERE superId = ?", [$hoofdcategorie]);

    if ($subcategorien['code'] == 0) {
        for ($i = 0; $i < count($subcategorien['data']); $i++) {
            $subcategorie = $subcategorien['data'][$i];
            echo('<div class="column">');
            echo('<img rel="categorie-' . $subcategorie['superId'] . '" class="categorieImage thumbnail" src="http://placehold.it/600x600">');
            echo('</div>');
        }
    }
}

//bieden
function bieden($bieding){
    executeQuery(
        "INSERT INTO biedingen(veilingId, email, biedingsTijd, biedingsBedrag) VALUES(?, ?, ?, ?)",
        [$bieding["veilingId"], $_SESSION["gebruiker"]->getEmail(), $bieding["biedingsTijd"], $bieding["biedingsBedrag"]]
    );
}

function getHoogsteBod($data){
    $hoogsteBod = executeQuery("SELECT TOP 1 * FROM biedingen WHERE veilingId = ? ORDER BY biedingsBedrag DESC", [$data["veilingId"]]);
    if($hoogsteBod["code"] == 0 || $hoogsteBod['code'] == 1){
        echo json_encode($hoogsteBod);
    }
    else{
        var_dump($hoogsteBod);
    }
}

function getVeilingInfo($data){
    echo json_encode(["gebruiker" => $_SESSION['gebruiker']->toArray(), "veiling" => executeQuery("SELECT * FROM veiling WHERE veilingId = ?", [$data["veilingId"]])]);
}

//veiling sluiten
function sluitVeiling($data){
    if(executeQuery("SELECT emailVerzonden FORM veiling WHERE veilingId = ?,", [$data["veilingId"]]) == 1){
        return;
    }else{
        executeQuery("UPDATE veiling SET emailVerzonden = 1 WHERE veilingId = ?",[$data["veilingId"]]);
        verzendEmail($data);
        return;
    }
}

//verzenden Email
function verzendEmail($data){
$to = "sinke.carsten95@gmail.com";
$subject = "verzendEmail";
$txt = "Hello world!";
$headers = "From: info@EenmaalAndermaal.nl";
mail($to,$subject,$txt,$headers);
}

?>
