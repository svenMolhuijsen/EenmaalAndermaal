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
        case 'search':
            search($_POST);

            break;
        case'getParentCategories':
            $category = trim($_POST['category']);
            getParentCategories($category);
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
        case 'MaakVeilingAan':
            aanmakenveiling($_POST);
            break;
        case 'addCategorieToDatabase':
            nieuweCategorieToevoegen($_POST);
            break;
        case 'AanpassenGegevens':
            pasgegevensaan($_POST);
            break;
        case 'uploadFile':
            uploadFile();
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

function search()
{
    $searchterm = $_POST['searchterm'];
    $minprice = (float)$_POST['minprice'];
    $maxprice = (float)$_POST['maxprice'];
    $category = (int)$_POST['category'];
    if ($category == null) {
        $result = executeQuery(
            ";with category_tree as 
(
   select categorieId
   from categorie
   where superId IS NULL
   union all
   select C.categorieId
   from categorie c
   join category_tree p on C.superId = P.categorieId 
) 

SELECT DISTINCT TOP 100 V.veilingId, V.titel, V.eindDatum,V.categorieId, C.categorieNaam, V.thumbNail, MAX(B.biedingsBedrag) AS hoogsteBieding
FROM veiling V INNER JOIN categorie C ON V.categorieId = C.categorieId  LEFT JOIN biedingen B ON B.veilingId = V.veilingId
WHERE V.titel LIKE '%'+?+'%' AND 
V.eindDatum >= GETDATE()  AND
V.beginDatum <= GETDATE() AND
(V.categorieId = ? OR
V.categorieId IN (
SELECT categorieId
FROM category_tree
))
GROUP BY V.veilingId, V.titel, V.eindDatum,V.categorieId,V.verkoopPrijs, C.categorieNaam, V.thumbNail
HAVING (MAX(B.biedingsBedrag)>=? AND MAX(B.biedingsBedrag)<=?)OR MAX(B.biedingsBedrag) IS NULL
ORDER BY hoogsteBieding DESC LIMIT 10
", [$searchterm, $category, $minprice, $maxprice]);

    } else {

        $result = executeQuery(
            ";with category_tree as 
(
   select categorieId
   from categorie
   where superId =?
   union all
   select C.categorieId
   from categorie c
   join category_tree p on C.superId = P.categorieId 
) 

SELECT DISTINCT TOP 12 V.veilingId, V.titel, V.eindDatum,V.categorieId, C.categorieNaam, V.thumbNail, MAX(B.biedingsBedrag) AS hoogsteBieding
FROM veiling V INNER JOIN categorie C ON V.categorieId = C.categorieId  LEFT JOIN biedingen B ON B.veilingId = V.veilingId
WHERE V.titel LIKE '%'+?+'%' AND 
V.eindDatum >= GETDATE()  AND
V.beginDatum <= GETDATE() AND
(V.categorieId = ? OR
V.categorieId IN (
SELECT categorieId
FROM category_tree
))
GROUP BY V.veilingId, V.titel, V.eindDatum,V.categorieId,V.verkoopPrijs, C.categorieNaam, V.thumbNail
HAVING (MAX(B.biedingsBedrag)>=? AND MAX(B.biedingsBedrag)<=?)OR MAX(B.biedingsBedrag) IS NULL
ORDER BY hoogsteBieding DESC
", [$category, $searchterm, $category, $minprice, $maxprice]);
    }
    stuurTerug($result);
}

function getParentCategories($category)
{
    $result = executeQuery(";with category_tree as (
   select categorieId, categorieNaam, superId
   from categorie
   where categorieId = ? -- this is the starting point you want in your recursion
   union all
   select C.categorieId, C.categorieNaam, C.superId
   from categorie c
   join category_tree p on C.categorieId = P.superId  -- this is the recursion
   -- Since your parent id is not NULL the recursion will happen continously.
   -- For that we apply the condition C.id<>C.parentid 

) 
-- Here you can insert directly to a temp table without CREATE TABLE synthax
select *
from category_tree
OPTION (MAXRECURSION 0)
", [$category]);

    stuurTerug($result);

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
function categorieAccordion()
{
    echo('
        <div class="side-nav-block medium-3 large-3 columns">
        <ul class="side-nav accordion" data-accordion data-allow-all-closed="true" data-multi-expand="false">
    ');

    $hoofdcategorien = executeQuery("SELECT * FROM categorie WHERE superId IS NULL");

    if ($hoofdcategorien['code'] == 0) {
        for ($i = 0; $i < count($hoofdcategorien['data']); $i++) {
            $hoofdcategorie = $hoofdcategorien['data'][$i];

            echo('<li onclick="updateSubCategorie()" class="accordion-item" data-accordion-item>');
            echo('<a href="#" rel="categorie-' . $hoofdcategorie['categorieId'] . '" class="hoofdcategorie accordion-title">' . $hoofdcategorie['categorieNaam'] . '</a>');
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

function setSubcategorien($hoofdcategorie)
{
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
function bieden($bieding)
{
    executeQuery(
        "INSERT INTO biedingen(veilingId, email, biedingsTijd, biedingsBedrag) VALUES(?, ?, ?, ?)",
        [$bieding["veilingId"], $_SESSION["gebruiker"]->getEmail(), $bieding["biedingsTijd"], $bieding["biedingsBedrag"]]
    );
}

function getHoogsteBod($data)
{
    $hoogsteBod = executeQuery("SELECT TOP 1 * FROM biedingen WHERE veilingId = ? ORDER BY biedingsBedrag DESC", [$data["veilingId"]]);
    if ($hoogsteBod["code"] == 0 || $hoogsteBod['code'] == 1) {
        echo json_encode($hoogsteBod);
    } else {
        var_dump($hoogsteBod);
    }
}

function getVeilingInfo($data)
{
    echo json_encode(["gebruiker" => $_SESSION['gebruiker']->toArray(), "veiling" => executeQuery("SELECT * FROM veiling WHERE veilingId = ?", [$data["veilingId"]])]);
}

//registreren van veiling
function aanmakenveiling($veiling){
    $veiling['verkoperGebruikersnaam'] = $_SESSION['gebruiker']->getGebruikersnaam();
    $veiling['koperGebruikersnaam'] = null;
    $veiling['beginDatum'] = date("Y-m-d H:m:s");
    $veiling['categorieId'] = intval($veiling['categorieId']);
    $veiling['startPrijs'] = intval($veiling['startPrijs']);
    $veiling['verkoopPrijs'] = intval($veiling['verkoopPrijs']);
    $veiling['betalingswijze'] = 'IDEAL';
    $veiling['verzendwijze'] = 'POSTNL';
    foreach($veiling as $key){
        if(empty($veiling[$key])){
            $veiling[$key] = null;
        }
    }
    $veiling['veilingGestopt'] = false;

    var_dump($veiling);

    $superVeiling = executeQueryNoFetch("INSERT INTO veiling VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [
        $veiling['titel'], $veiling['beschrijving'], $veiling['categorieId'], $veiling['postcode'],
        $veiling['land'], $veiling['verkoperGebruikersnaam'], $veiling['koperGebruikersnaam'],
        $veiling['startPrijs'], $veiling['verkoopPrijs'], $veiling['provincie'],
        $veiling['plaatsnaam'], $veiling['straatnaam'], $veiling['huisnummer'],
        $veiling['betalingswijze'], $veiling['verzendwijze'], $veiling['beginDatum'],
        $veiling['eindDatum'], $veiling['conditie'], $veiling['thumbNail'], $veiling['veilingGestopt']
    ]);

    var_dump($superVeiling);
}

function uploadFile()
{
    $data = array();
    $error = false;
    $files = array();

    $uploaddir = $_SERVER["DOCUMENT_ROOT"].'/img/uploads/';

    foreach($_FILES as $file)
    {
        if(move_uploaded_file($file['tmp_name'], $uploaddir.basename($file['name'])))
        {
            $files[] = $uploaddir.$file['name'];
        }
        else
        {
            $error = true;
        }
    }

    $data = ($error) ? array('error' => 'There was an error uploading your files') : array('file' => basename($files[0]));

    echo json_encode($data);
}

function getLanden()
{
    $Land = executeQuery("SELECT  * FROM landen", null);
    return $Land;
}
function checkVeilingenInCategorie($categorieId){
    $veiling = executeQuery("SELECT count(*)  AS aantal FROM veiling WHERE categorieId = ?", [$categorieId]);

    if($veiling['code'] == 0) {
        if ($veiling['data'][0]['aantal'] > 0) {
            print('Er zitten veilingen in deze categorie');
            return true;
        } else {
            print('Er zitten GEEN veilingen in deze categorie');
            return false;
        }
    }
    else{
        var_dump($veiling);
    }
}

function pasgegevensaan($gegevens){
$gebruikersnaam = "admul";/*
$user = new User($gebruikersnaam);
$user->setWachtwoord($gegevens['NEWpassword']);
$user->setVoornaam($gegevens['NEWname']);
$user->setGeboortedatum($gegevens['NEWbirthday']);*/
executeQuery("UPDATE gebruikers SET wachtwoord = ? WHERE gebruikersNaam = ?",[$gegevens['NEWpassword'] ,$gebruikersnaam]);
executeQuery("UPDATE gebruikers SET voornaam = ? WHERE gebruikersNaam = ?", [ $gegevens['NEWname'] ,$gebruikersnaam] );
    executeQuery("UPDATE gebruikers SET geboortedatum ? WHERE gebruikersNaam = ?",[$gegevens['NEWgeboortedatum'] ,$gebruikersnaam]);
    executeQuery("UPDATE gebruikers SET provincie = ? WHERE gebruikersNaam = ?",[$gegevens['NEWprovincie'] ,$gebruikersnaam]);
    executeQuery("UPDATE gebruikers SET plaatsnaam = ? WHERE gebruikersNaam = ?",[$gegevens['NEWplaats'] ,$gebruikersnaam]);
    executeQuery("UPDATE gebruikers SET straatnaam = ? WHERE gebruikersNaam = ?",[$gegevens['NEWstraat'] ,$gebruikersnaam]);
    executeQuery("UPDATE gebruikers SET huisnummer = ? WHERE gebruikersNaam = ?",[$gegevens['NEWhuisnummer'] ,$gebruikersnaam]);
    executeQuery("UPDATE gebruikers SET telefoonnmr = ? WHERE gebruikersNaam = ?",[$gegevens['NEWtelefoonnummer'] ,$gebruikersnaam]);
}

function nieuweCategorieToevoegen($categorie){
    if(checkVeilingenInCategorie($categorie["superId"])){
        executeQueryNoFetch("INSERT INTO categorie(categorieNaam, superId) VALUES('Overige', ?)", [$categorie["superId"]]);

        $overigCategorieId = executeQuery("SELECT categorieId FROM categorie WHERE superId = ? AND categorieNaam = 'Overige'",[$categorie["superId"]]);

        executeQueryNoFetch("UPDATE veiling SET categorieId = ? WHERE categorieId = ?", [$overigCategorieId['data'][0]['categorieId'], $categorie["superId"]]);

        voegCategorieToe($categorie);

        echo $overigCategorieId['data'][0]['categorieId'];
        var_dump($categorie["superId"]);
    }
    else {
        voegCategorieToe($categorie);
    }
}

function voegCategorieToe($categorie){
    executeQueryNoFetch("INSERT INTO categorie(categorieNaam, superId) VALUES (?, ?)", [
        $categorie["categorieNaam"],
        $categorie["superId"]
    ]);
}
?>
