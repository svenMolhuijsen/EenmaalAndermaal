<?php
include("core.php");
//wanneer api call wordt gedaan
if (!empty($_GET['action'])) {
    $action = $_GET['action'];
    switch ($action) {
        // Inloggen
        case 'login':
            login($_POST);
            break;
        // Uitloggen
        case 'logout':
            logout();
            break;
        case 'getNumRows':
            getNumRows();
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
        case 'getBiedingInfo':
            getBiedingInfo($_POST);
            break;
        case 'sluitVeiling':
            sluitVeiling($_POST);
            break;
        case 'MaakVeilingAan':
            checkFiles();
            break;
        case 'addCategorieToDatabase':
            nieuweCategorieToevoegen($_POST);
            break;
        case 'AanpassenGegevens':
            pasgegevensaan($_POST);
            break;
        case 'trending':
            trending();
            break;
        case 'beindigveiling':
            beindigveiling($_POST);
            break;
        case 'verwijderVeiling':
            verwijderVeiling($_POST);
            break;
        case 'verplaatsVeiling':
            verplaatsVeiling($_POST);
            break;
        default:
            header('HTTP/1.0 404 NOT FOUND');
            break;

    }
}

// Inloggen
function login($params)
{
    $gebruikersnaam = $params["gebruikersnaam"];
    $wachtwoord = $params["wachtwoord"];

    if (empty($gebruikersnaam) || empty($wachtwoord)) {
        $response = ['status' => 'error', "message" => "Een van de velden is niet ingevuld"];
    } else {
        $result = executeQuery("SELECT TOP 1 gebruikersnaam, wachtwoord FROM gebruikers WHERE gebruikersnaam = ?", [$gebruikersnaam]);
        if ($result['code'] == 0) {
            if ($wachtwoord == $result['data'][0]["wachtwoord"]) {
                $_SESSION['gebruiker'] = $gebruikersnaam;
                $response = ['status' => 'success', 'code' => 0, 'message' => 'succesvol ingelogd'];
            }
        }
        else {
            $response = ['status' => 'error', 'code' => 3, 'message' => 'logingegevens kloppen niet'];
        }
    }

    echo json_encode($response);
}

function logout() {
    session_unset();
    session_destroy();
    if ($_SESSION != null) {
        $a_result = ['loggedOut' => false];
    }
    else {
        $a_result = ['loggedOut' => true];
    }

    echo json_encode($a_result);
}

function getNumRows()
{
    $searchterm = $_POST['searchterm'];
    $minprice = (float)$_POST['minprice'];
    $maxprice = (float)$_POST['maxprice'];
    $category = (int)$_POST['category'];
    $sortering = $_POST['sortering'];


    switch ($sortering) {
        case 'Date ASC':
            $order = 'V.eindDatum ASC';
            Break;
        case 'Date DESC':
            $order = 'V.eindDatum DESC';
            break;
        case 'Title ASC':
            $order = 'V.titel ASC';
            break;
        case 'startPrijs ASC':
            $order = 'V.startPrijs ASC';
            break;
        case 'startPrijs DESC':
            $order = 'V.startPrijs DESC';
            break;
        default:
            $order = 'V.titel ASC';
    }

    if ($category == 'null') {
        $result = executeQuery(
            "


;with category_tree as 
(
   select categorieId
   from categorie
   where superId IS NULL
   union all
   select C.categorieId
   from categorie c
   join category_tree p on C.superId = P.categorieId 
) 

SELECT  COUNT(*) AS numRows
FROM veiling V INNER JOIN categorie C ON V.categorieId = C.categorieId  LEFT JOIN biedingen B ON B.veilingId = V.veilingId
WHERE V.titel LIKE '%'+?+'%' AND 
V.eindDatum >= GETDATE()  AND
V.beginDatum <= GETDATE() AND
(V.categorieId = ? OR
V.categorieId IN (
SELECT categorieId
FROM category_tree
))
AND ((V.startPrijs>=? AND V.startPrijs<=?)OR V.startPrijs IS NULL)
HAVING ((MAX(B.biedingsBedrag)>=? AND MAX(B.biedingsBedrag)<=?)OR MAX(B.biedingsBedrag) IS NULL)"
            , [$searchterm, $category, $minprice, $maxprice, $minprice, $maxprice]);

    } else {

        $result = executeQuery(
            "
;with category_tree as 
(
   select categorieId
   from categorie
   where superId =?
   union all
   select C.categorieId
   from categorie c
   join category_tree p on C.superId = P.categorieId 
) 

SELECT COUNT(*) AS numRows
FROM veiling V INNER JOIN categorie C ON V.categorieId = C.categorieId  LEFT JOIN biedingen B ON B.veilingId = V.veilingId
WHERE V.titel LIKE '%'+?+'%' AND 
V.eindDatum >= GETDATE()  AND
V.beginDatum <= GETDATE() AND
(V.categorieId = ? OR
V.categorieId IN (
SELECT categorieId
FROM category_tree
))
AND ((V.startPrijs>=? AND V.startPrijs<=?)OR V.startPrijs IS NULL)
HAVING ((MAX(B.biedingsBedrag)>=? AND MAX(B.biedingsBedrag)<=?)OR MAX(B.biedingsBedrag) IS NULL)"
            , [$category, $searchterm, $category, $minprice, $maxprice, $minprice, $maxprice]);
    }
    stuurTerug($result);
}

function search()
{
    $searchterm = $_POST['searchterm'];
    $minprice = (float)$_POST['minprice'];
    $maxprice = (float)$_POST['maxprice'];
    $category = (int)$_POST['category'];
    $sortering = $_POST['sortering'];
    $numrows = (int)$_POST['numrows'];
    $page = (int)$_POST['page'];

    switch ($sortering) {
        case 'Date ASC':
            $order = 'V.eindDatum ASC';
            Break;
        case 'Date DESC':
            $order = 'V.eindDatum DESC';
            break;
        case 'Title ASC':
            $order = 'V.titel ASC';
            break;
        case 'startPrijs ASC':
            $order = 'V.startPrijs ASC';
            break;
        case 'startPrijs DESC':
            $order = 'V.startPrijs DESC';
            break;
        default:
            $order = 'V.titel ASC';
    }

    if ($category == 'null') {
        $result = executeQuery(
            "
DECLARE @NUMROWS AS int = ?
DECLARE @PAGE AS int = ?

;with category_tree as 
(
   select categorieId
   from categorie
   where superId IS NULL
   union all
   select C.categorieId
   from categorie c
   join category_tree p on C.superId = P.categorieId 
) 

SELECT DISTINCT V.veilingId, V.titel, V.eindDatum,V.categorieId, C.categorieNaam, V.thumbNail, V.startPrijs, MAX(B.biedingsBedrag) AS hoogsteBieding
FROM veiling V INNER JOIN categorie C ON V.categorieId = C.categorieId  LEFT JOIN biedingen B ON B.veilingId = V.veilingId
WHERE V.titel LIKE '%'+?+'%' AND 
V.eindDatum >= GETDATE()  AND
V.beginDatum <= GETDATE() AND
(V.categorieId = ? OR
V.categorieId IN (
SELECT categorieId
FROM category_tree
))
GROUP BY V.veilingId, V.titel, V.eindDatum,V.categorieId,V.verkoopPrijs, C.categorieNaam, V.thumbNail, V.startPrijs
HAVING ((MAX(B.biedingsBedrag)>=? AND MAX(B.biedingsBedrag)<=?)OR MAX(B.biedingsBedrag) IS NULL) AND ((V.startPrijs>=? AND V.startPrijs<=?)OR V.startPrijs IS NULL)
ORDER BY " . $order . "
OFFSET	 @PAGE*@NUMROWS	ROWS
FETCH NEXT	@NUMROWS ROWS ONLY", [$numrows, $page, $searchterm, $category, $minprice, $maxprice, $minprice, $maxprice]);

    } else {

        $result = executeQuery(
            "
DECLARE @NUMROWS AS int = ?
DECLARE @PAGE AS int = ?

;with category_tree as 
(
   select categorieId
   from categorie
   where superId =?
   union all
   select C.categorieId
   from categorie c
   join category_tree p on C.superId = P.categorieId 
) 

SELECT DISTINCT V.veilingId, V.titel, V.eindDatum,V.categorieId, C.categorieNaam,V.startPrijs, V.thumbNail, MAX(B.biedingsBedrag) AS hoogsteBieding
FROM veiling V INNER JOIN categorie C ON V.categorieId = C.categorieId  LEFT JOIN biedingen B ON B.veilingId = V.veilingId
WHERE V.titel LIKE '%'+?+'%' AND 
V.eindDatum >= GETDATE()  AND
V.beginDatum <= GETDATE() AND
(V.categorieId = ? OR
V.categorieId IN (
SELECT categorieId
FROM category_tree
))
GROUP BY V.veilingId, V.titel, V.eindDatum,V.categorieId,V.verkoopPrijs, C.categorieNaam, V.thumbNail, V.startPrijs
HAVING ((MAX(B.biedingsBedrag)>=? AND MAX(B.biedingsBedrag)<=?)OR MAX(B.biedingsBedrag) IS NULL) AND ((V.startPrijs>=? AND V.startPrijs<=?)OR V.startPrijs IS NULL)
ORDER BY " . $order . "
OFFSET	 @PAGE*@NUMROWS	ROWS
FETCH NEXT	@NUMROWS ROWS ONLY", [$numrows, $page, $category, $searchterm, $category, $minprice, $maxprice, $minprice, $maxprice]);
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
    echo json_encode($data);
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
    $bieding = executeQueryNoFetch(
        "INSERT INTO biedingen(veilingId, gebruikersnaam, biedingsTijd, biedingsBedrag) VALUES(?, ?, ?, ?)",
        [$bieding["veilingId"], $_SESSION["gebruiker"], $bieding["biedingsTijd"], $bieding["biedingsBedrag"]]
    );

    if($bieding['code'] == 2) {
        var_dump($bieding);
    }
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
   stuurTerug(executeQuery("SELECT * FROM veiling WHERE veilingId = ?", [$data["veilingId"]]));
}

function getBiedingInfo($data){
    echo json_encode(["gebruiker" => $_SESSION['gebruiker'], "veiling" => executeQuery("SELECT * FROM veiling WHERE veilingId = ?", [$data["veilingId"]])]);
}

//registreren van veiling
function checkFiles()
{
    $feedbacks = array();
    $uploadOk = true;

    foreach ($_FILES as $file) {
        $feedback = array();
        $imageFileType = pathinfo($file['name'], PATHINFO_EXTENSION);

        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            array_push($feedback, $file['name'] . ": Alleen JPG, JPEG, PNG & GIF bestanden zijn toegestaan");
            $uploadOk = false;
        }

        if ($file["size"] > 500000) {
            array_push($feedback, $file['name'] . ": Bestand is te groot");
            $uploadOk = false;
        }

        if (!empty($feedback)) {
            array_push($feedbacks, $feedback);
        }
    }

    if ($uploadOk) {
        $response = aanmakenveiling($_POST, $_FILES['thumbnail']);
    } else {
        $response = array('status' => 'userError', 'feedback' => $feedbacks);
    }

    echo json_encode($response);
}

function aanmakenveiling($veilingInfo)
{
    $veilingInfo['verkoperGebruikersnaam'] = $_SESSION['gebruiker']->getGebruikersnaam();
    $veilingInfo['categorieId'] = intval($veilingInfo['categorieId']);
    $veilingInfo['startPrijs'] = intval($veilingInfo['startPrijs']);
    $veilingInfo['verkoopPrijs'] = null;
    $veilingInfo['koperGebruikersnaam'] = null;
    $veilingInfo['betalingswijze'] = 'IDEAL';
    $veilingInfo['verzendwijze'] = 'POSTNL';
    foreach ($veilingInfo as $key => $value) {
        if (empty($veilingInfo[$key])) {
            $veilingInfo[$key] = null;
        }
    }
    $veilingInfo['thumbNail'] = "";
    $veilingInfo['veilingGestopt'] = false;

    $veiling = executeQueryNoFetch("INSERT INTO veiling VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [
        $veilingInfo['titel'], $veilingInfo['beschrijving'], $veilingInfo['categorieId'], $veilingInfo['postcode'],
        $veilingInfo['land'], $veilingInfo['verkoperGebruikersnaam'], $veilingInfo['koperGebruikersnaam'],
        $veilingInfo['startPrijs'], $veilingInfo['verkoopPrijs'], $veilingInfo['provincie'],
        $veilingInfo['plaatsnaam'], $veilingInfo['straatnaam'], $veilingInfo['huisnummer'],
        $veilingInfo['betalingswijze'], $veilingInfo['verzendwijze'], $veilingInfo['beginDatum'],
        $veilingInfo['eindDatum'], $veilingInfo['conditie'], $veilingInfo['thumbNail'], $veilingInfo['veilingGestopt']
    ]);

    if ($veiling['code'] == 0) {
        $veilingId = executeQuery("SELECT veilingId FROM veiling WHERE titel = ? AND beschrijving = ? AND verkoperGebruikersnaam = ? AND beginDatum = ?",
            [$veilingInfo['titel'], $veilingInfo['beschrijving'], $veilingInfo['verkoperGebruikersnaam'], $veilingInfo['beginDatum']]);
        if ($veilingId['code'] == 0) {
            return uploadFiles($veilingId['data'][0]['veilingId']);
        } else {
            var_dump($veilingId);
        }
    } else {
        var_dump($veiling);
        return array('status' => 'error', 'message' => 'Er was een error met het aanmaken van de veiling.');
    }
}

function uploadFiles($veilingId)
{
    $prefix = date('Ymdhms').rand(0, 999);
    $uploaddirPrefix = $_SERVER['DOCUMENT_ROOT'].'/';
    $uploaddir = 'upload/';
    $error = false;

    foreach ($_FILES as $key => $file) {
        $targetFile = $uploaddirPrefix.$uploaddir.$prefix.basename($file['name']);
        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            if($key == 'thumbnail' && $key !== 0){
                executeQueryNoFetch("UPDATE veiling SET thumbNail = ? WHERE veilingId = ?", [$uploaddir.$prefix.basename($file['name']), $veilingId]);
                continue;
            }
                executeQueryNoFetch("INSERT INTO veilingFoto(veilingId, fotoPath) VALUES(?, ?)", [$veilingId, $uploaddir.$prefix.basename($file['name'])]);
        } else {
            $error = true;
        }
    }

    if ($error) {
        return array('status' => 'error', 'message' => 'Er ging iets fout met het uploaden van de files.');
    } else {
        return array('status' => 'success', 'message' => 'Uw veiling is aangemaakt.');
    }
}

function getLanden()
{
    return executeQuery("SELECT  * FROM landen", null);
}

function checkVeilingenInCategorie($categorieId)
{
    $veiling = executeQuery("SELECT count(*)  AS aantal FROM veiling WHERE categorieId = ?", [$categorieId]);

    if ($veiling['code'] == 0) {
        if ($veiling['data'][0]['aantal'] > 0) {
            print('Er zitten veilingen in deze categorie');
            return true;
        } else {
            print('Er zitten GEEN veilingen in deze categorie');
            return false;
        }
    }
    else {
        var_dump($veiling);
    }
}

function pasgegevensaan($gegevens) {
    $fetchPassword = executeQuery("SELECT wachtwoord FROM gebruikers where gebruikersNaam = ?", [$_SESSION['gebruiker']->getGebruikersnaam()]);

    if (!empty($gegevens['NEWpassword'])) {
        if (password_verify($gegevens['OLDpassword'], $fetchPassword['data'][0]['wachtwoord'])) {
            $passwordnew = password_hash($gegevens['NEWpassword'], PASSWORD_BCRYPT);
            $_SESSION['gebruiker']->setWachtwoord($passwordnew);
        }
    }
    if (!empty($gegevens['NEWplaats'])) {
        $_SESSION['gebruiker']->setPlaatsnaam($gegevens['NEWplaats']);
    }
    if (!empty($gegevens['NEWprovincie'])) {
        $_SESSION['gebruiker']->setProvincie($gegevens['NEWprovincie']);
    }
    if (!empty($gegevens['NEWstraat'])) {
        $_SESSION['gebruiker']->setStraatnaam($gegevens['NEWstraat']);
    }
    if (!empty($gegevens['NEWpostcode'])) {
        $_SESSION['gebruiker']->setPostcode($gegevens['NEWpostcode']);
    }
    if (!empty($gegevens['NEWtelefoonnummer'])) {
        $_SESSION['gebruiker']->setTelefoonnmr($gegevens['NEWtelefoonnummer']);
    }
}

function nieuweCategorieToevoegen($categorie)
{
    if (checkVeilingenInCategorie($categorie["superId"])) {
        executeQueryNoFetch("INSERT INTO categorie(categorieNaam, superId) VALUES('Overige', ?)", [$categorie["superId"]]);

        $overigCategorieId = executeQuery("SELECT categorieId FROM categorie WHERE superId = ? AND categorieNaam = 'Overige'", [$categorie["superId"]]);

        executeQueryNoFetch("UPDATE veiling SET categorieId = ? WHERE categorieId = ?", [$overigCategorieId['data'][0]['categorieId'], $categorie["superId"]]);

        voegCategorieToe($categorie);

        echo $overigCategorieId['data'][0]['categorieId'];
        var_dump($categorie["superId"]);
    } else {
        voegCategorieToe($categorie);
    }
}

function voegCategorieToe($categorie)
{
    executeQueryNoFetch("INSERT INTO categorie(categorieNaam, superId) VALUES (?, ?)", [
        $categorie["categorieNaam"],
        $categorie["superId"]
    ]);
}

function trending()
{
    stuurTerug(executeQuery("SELECT TOP 6 * FROM veiling v WHERE v.veilingGestopt = 0 AND v.veilingId IN (SELECT veilingId FROM history) ORDER BY (COUNT(veilingId) OVER(PARTITION BY veilingId)) DESC"));
}

function beindigVeiling($veiling){
    executeQueryNoFetch("UPDATE veiling SET eindDatum = GETDATE(), veilingGestopt = 1 WHERE veilingId = ?",[$veiling["veilingId"]]);
    //verzend email functie toevoegen voor dit veilingId
}

function verwijderVeiling($veiling){
    executeQueryNoFetch("DELETE FROM biedingen WHERE veilingId = ?", [$veiling["veilingId"]]);
    executeQueryNoFetch("DELETE FROM history WHERE veilingId = ?", [$veiling["veilingId"]]);
    executeQueryNoFetch("DELETE FROM veilingFoto WHERE veilingId = ?", [$veiling["veilingId"]]);
    executeQueryNoFetch("DELETE FROM veiling WHERE veilingId = ?", [$veiling["veilingId"]]);
}

function verplaatsVeiling($veiling){
    executeQueryNoFetch("UPDATE veiling SET categorieId = ? WHERE veilingId = ?", [$veiling["categorieId"], $veiling["veilingId"]]);
}

?>
