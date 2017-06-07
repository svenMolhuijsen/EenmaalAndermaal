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
        case 'sluitVeilingen':
            sluitVeilingen();
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
        case 'registreer':
            registreer($_POST);
            break;
        case 'resetWachtwoord':
            resetWachtwoord($_POST);
            break;
        case 'veranderWachtwoord':
            veranderWachtwoord($_POST);
            break;
        default:
            header('HTTP/1.0 404 NOT FOUND');
            break;

    }
}

//Inloggen
function login($params)
{
    //Splits de informatie
    $gebruikersnaam = $params["gebruikersnaam"];
    $wachtwoord = $params["wachtwoord"];

    //Check of de velden gevuld zijn
    if (empty($gebruikersnaam) || empty($wachtwoord)) {
        $response = ['status' => 'error', "message" => "Een van de velden is niet ingevuld"];
    } else {
        //Check of de gebruikersnaam en wachtwoord combinatie bij elkaar hoort
        $result = executeQuery("SELECT TOP 1 gebruikersnaam, wachtwoord FROM gebruikers WHERE gebruikersnaam = ?", [$gebruikersnaam]);
        if ($result['code'] == 0) {
            if (password_verify($wachtwoord, $result['data'][0]["wachtwoord"])) {
                //Stel de sessie in
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

//Uitloggen
function logout() {
    //Maak de sessie leeg
    session_unset();
    //Vernietig de sessie
    session_destroy();

    //Geef het resultaat terug
    if ($_SESSION != null) {
        $result = ['loggedOut' => false];
    }
    else {
        $result = ['loggedOut' => true];
    }

    echo json_encode($result);
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
            break;
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

function search($input)
{
    $searchterm = $input['searchterm'];
    $minprice = (float)$input['minprice'];
    $maxprice = (float)$input['maxprice'];
    $category = (int)$input['category'];
    $sortering = $input['sortering'];
    $numrows = (int)$input['numrows'];
    $page = (int)$input['page'];

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
    //Maak het accordion aan
    echo('
        <div class="side-nav-block medium-3 large-3 columns">
        <ul class="side-nav accordion" data-accordion data-allow-all-closed="true" data-multi-expand="false">
    ');

    //Zoek de hoofdcategorien
    $hoofdcategorien = executeQuery("SELECT * FROM categorie WHERE superId IS NULL");

    //Check of ze gevonden zijn
    if ($hoofdcategorien['code'] == 0) {
        //Maak voor elke hoofdcategorie een accordion item aan
        for ($i = 0; $i < count($hoofdcategorien['data']); $i++) {
            $hoofdcategorie = $hoofdcategorien['data'][$i];

            //Maak de accordion items aan
            echo('<li onclick="updateSubCategorie()" class="accordion-item" data-accordion-item>');
            echo('<a href="#" rel="categorie-' . $hoofdcategorie['categorieId'] . '" class="hoofdcategorie accordion-title">' . $hoofdcategorie['categorieNaam'] . '</a>');
            echo('<div class="accordion-content show-for-small-only" data-tab-content>');

            //Zoek de subcategoriën van de hoofdcategorie
            $subcategorien = executeQuery("SELECT * FROM categorie WHERE superId = ?", [$hoofdcategorie['categorieId']]);

            if ($subcategorien['code'] == 0) {
                for ($j = 0; $j < count($subcategorien['data']); $j++) {
                    $subcategorie = $subcategorien['data'][$j];

                    //Zet de subcategoriën in de accordion
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
    //Zet de bieding in de database
    $bieding = executeQueryNoFetch(
        "INSERT INTO biedingen(veilingId, gebruikersnaam, biedingsTijd, biedingsBedrag) VALUES(?, ?, ?, ?)",
        [$bieding["veilingId"], $_SESSION["gebruiker"], $bieding["biedingsTijd"], $bieding["biedingsBedrag"]]
    );

    //Geef een error terug
    if ($bieding['code'] == 2) {
        var_dump($bieding);
    }
}

//Zoek het hoogste bod
function getHoogsteBod($data)
{
    $hoogsteBod = executeQuery("SELECT TOP 1 * FROM biedingen WHERE veilingId = ? ORDER BY biedingsBedrag DESC", [$data["veilingId"]]);
    if ($hoogsteBod["code"] == 0 || $hoogsteBod['code'] == 1) {
        echo json_encode($hoogsteBod);
    } else {
        var_dump($hoogsteBod);
    }
}

//Geef de info van de veiling en gebruiker
function getVeilingInfo($data)
{
   stuurTerug(executeQuery("SELECT * FROM veiling WHERE veilingId = ?", [$data["veilingId"]]));
}

//Geef de info van een bod
function getBiedingInfo($data){
    echo json_encode(["gebruiker" => $_SESSION['gebruiker'], "veiling" => executeQuery("SELECT * FROM veiling WHERE veilingId = ?", [$data["veilingId"]])]);
}

//registreren van veiling
function checkFiles()
{
    $feedbacks = array();
    $uploadOk = true;

    //Loop door alle files heen
    foreach ($_FILES as $file) {
        //Feedback op de huidig file
        $feedback = array();
        //Pak de filetype van de image
        $imageFileType = pathinfo($file['name'], PATHINFO_EXTENSION);

        //Check het tegen een aantal filetypes
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            array_push($feedback, $file['name'] . ": Alleen JPG, JPEG, PNG & GIF bestanden zijn toegestaan");
            $uploadOk = false;
        }

        //Check de filesize
        if ($file["size"] > 500000) {
            array_push($feedback, $file['name'] . ": Bestand is te groot");
            $uploadOk = false;
        }

        //Geef de feedback
        if (!empty($feedback)) {
            array_push($feedbacks, $feedback);
        }
    }

    //Ga door met het aanmaken van de veiling, mits het valideren goed is gegaan
    if ($uploadOk) {
        $response = aanmakenveiling($_POST);
    } else {
        $response = array('status' => 'userError', 'feedback' => $feedbacks);
    }

    echo json_encode($response);
}

//Maak de veiling aan
function aanmakenveiling($veilingInfo)
{
    //Zet wat info klaar die JS niet klaar kon zetten
    $veilingInfo['verkoperGebruikersnaam'] = $_SESSION['gebruiker'];
    $veilingInfo['categorieId'] = intval($veilingInfo['categorieId']);
    $veilingInfo['startPrijs'] = intval($veilingInfo['startPrijs']);
    $veilingInfo['verkoopPrijs'] = null;
    $veilingInfo['koperGebruikersnaam'] = null;
    $veilingInfo['betalingswijze'] = 'IDEAL';
    $veilingInfo['verzendwijze'] = 'POSTNL';
    //Maak nulls van lege velden
    foreach ($veilingInfo as $key => $value) {
        if (empty($veilingInfo[$key])) {
            $veilingInfo[$key] = null;
        }
    }
    $veilingInfo['thumbNail'] = "";
    $veilingInfo['veilingGestopt'] = false;

    //Maak de veiling aan
    $veiling = executeQueryNoFetch("INSERT INTO veiling VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [
        $veilingInfo['titel'], $veilingInfo['beschrijving'], $veilingInfo['categorieId'], $veilingInfo['postcode'],
        $veilingInfo['land'], $veilingInfo['verkoperGebruikersnaam'], $veilingInfo['koperGebruikersnaam'],
        $veilingInfo['startPrijs'], $veilingInfo['verkoopPrijs'], $veilingInfo['provincie'],
        $veilingInfo['plaatsnaam'], $veilingInfo['straatnaam'], $veilingInfo['huisnummer'],
        $veilingInfo['betalingswijze'], $veilingInfo['verzendwijze'], $veilingInfo['beginDatum'],
        $veilingInfo['eindDatum'], $veilingInfo['conditie'], $veilingInfo['thumbNail'], $veilingInfo['veilingGestopt']
    ]);

    if ($veiling['code'] == 0) {
        //Pak het veilingId van de zojuist aangemaakte veiling
        $veilingId = executeQuery("SELECT veilingId FROM veiling WHERE titel = ? AND beschrijving = ? AND verkoperGebruikersnaam = ? AND beginDatum = ?",
            [$veilingInfo['titel'], $veilingInfo['beschrijving'], $veilingInfo['verkoperGebruikersnaam'], $veilingInfo['beginDatum']]);
        if ($veilingId['code'] == 0) {
            //Upload de files
            return uploadFiles($veilingId['data'][0]['veilingId']);
        } else {
            var_dump($veilingId);
        }
    } else {
        var_dump($veiling);
        return array('status' => 'error', 'message' => 'Er was een error met het aanmaken van de veiling.');
    }
}

//Uploaden van files
function uploadFiles($veilingId) {
    //Geef de files een prefix-code en zet de directories klaar
    $prefix = date('Ymdhms').rand(0, 999);
    $uploaddirPrefix = $_SERVER['DOCUMENT_ROOT'].'/';
    $uploaddir = 'upload/';
    $error = false;

    //Loop door de files heen
    foreach ($_FILES as $key => $file) {
        //Geef aan waar de file heen moet
        $targetFile = $uploaddirPrefix.$uploaddir.$prefix.basename($file['name']);
        //Upload de file
        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            //Zet de thumbnail in de database
            if ($key == 'thumbnail' && $key !== 0){
                executeQueryNoFetch("UPDATE veiling SET thumbNail = ? WHERE veilingId = ?", [$uploaddir.$prefix.basename($file['name']), $veilingId]);
                continue;
            }
            //Zet de images in de database
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
    } else {
        var_dump($veiling);
    }
}

//Aanpassen van gebruikergegevens
function pasgegevensaan($gegevens) {
    //Haal de oude gegevens op
    $gebruiker = new User($_SESSION['gebruiker']);

    ////////////////////////////
    //Veranderen van gegevens
    ///////////////////////////
    if (!empty($gegevens['NEWpassword'])) {
        if (password_verify($gegevens['OLDpassword'], $gebruiker->getWachtwoord())) {
            $passwordnew = password_hash($gegevens['NEWpassword'], PASSWORD_BCRYPT);
            executeQueryNoFetch("UPDATE gebruikers SET wachtwoord = ? WHERE gebruikersnaam = ?", [$passwordnew, $gebruiker->getGebruikersnaam()]);
        }
    }
    if (!empty($gegevens['NEWplaats'])) {
        executeQueryNoFetch("UPDATE gebruikers SET plaatsnaam = ? WHERE gebruikersnaam = ?", [$gegevens['NEWplaats'], $_SESSION['gebruiker']]);
    }
    if (!empty($gegevens['NEWprovincie'])) {
        executeQueryNoFetch("UPDATE gebruikers SET provincie = ? WHERE gebruikersnaam = ?", [$gegevens['NEWprovincie'], $_SESSION['gebruiker']]);
    }
    if (!empty($gegevens['NEWstraat'])) {
        executeQueryNoFetch("UPDATE gebruikers SET straatnaam = ? WHERE gebruikersnaam = ?", [$gegevens['NEWstraat'], $_SESSION['gebruiker']]);
    }
    if (!empty($gegevens['NEWpostcode'])) {
        executeQueryNoFetch("UPDATE gebruikers SET postcode = ? WHERE gebruikersnaam = ?", [$gegevens['NEWpostcode'], $_SESSION['gebruiker']]);
    }
    if (!empty($gegevens['NEWtelefoonnummer'])) {
        executeQueryNoFetch("UPDATE gebruikers SET telefoonnmr = ? WHERE gebruikersnaam = ?", [$gegevens['NEWtelefoonnummer'], $_SESSION['gebruiker']]);
    }
    if (!empty($gegevens['NEWadmin'])) {
        executeQueryNoFetch("UPDATE gebruikers SET admin = ? WHERE gebruikersnaam = ?", [$gegevens['NEWadmin'], $_SESSION['gebruiker']]);
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

function verzendEmail($data){
    $veiling = executeQuery("SELECT * FROM veiling WHERE veilingId = ?",[$data["veilingId"]]);
    $veiling = $veiling['data'][0];
    $naar = "sinke.carsten95@gmail.com";
    $subject = "Gewonnen veiling";
    $txt = 'Veiling: '.$veiling["titel"].' is gewonnen door '.$veiling["koperGebruikersnaam"].'
        Veiling gegevens:
        Veiling Id: '.$veiling["veilingId"].'
        Titel: '.$veiling["titel"].'</td>
        Verkoper: '.$veiling["verkoperGebruikersnaam"].'
        Koper: '.$veiling["koperGebruikersnaam"].'
        Verkoop prijs: '.$veiling["verkoopPrijs"].'';

    $headers = "From: info@EenmaalAndermaal.nl";
    mail($naar,$subject,$txt,$headers);
}

function sluitVeilingen(){
    $veilingen = executeQuery("SELECT * FROM veiling WHERE eindDatum < GETDATE() AND veilingGestopt = 0");
    foreach ($veilingen['data'] as $veiling) {
        executeQueryNoFetch("UPDATE veiling SET koperGebruikersnaam = (SELECT TOP 1 gebruikersnaam FROM biedingen WHERE veilingId = ? ORDER BY biedingsBedrag DESC), verkoopPrijs = (SELECT TOP 1 biedingsBedrag FROM biedingen WHERE veilingId = ? ORDER BY biedingsBedrag DESC), veilingGestopt = 1 WHERE veilingId = ?", [$veiling["veilingId"],$veiling["veilingId"],$veiling["veilingId"]]);
        verzendEmail($veiling);
    }
}

function beindigVeiling($veiling){
    executeQueryNoFetch("UPDATE veiling SET koperGebruikersnaam = (SELECT TOP 1 gebruikersnaam FROM biedingen WHERE veilingId = ? ORDER BY biedingsBedrag DESC), verkoopPrijs = (SELECT TOP 1 biedingsBedrag FROM biedingen WHERE veilingId = ? ORDER BY biedingsBedrag DESC), veilingGestopt = 1 WHERE veilingId = ?", [$veiling["veilingId"],$veiling["veilingId"],$veiling["veilingId"]]);
    verzendEmail($veiling);
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

//Registreren
function registreer($userInfo){
    //Kijk of de gebruikersnaam al bestaat
    $gebruikersnaamCheck = executeQuery("SELECT gebruikersnaam FROM gebruikers WHERE gebruikersnaam = ?", [$userInfo['gebruikersnaam']]);

    if ($gebruikersnaamCheck['code'] == 0) {
        $responseCode = 0;
    } elseif ($gebruikersnaamCheck['code'] == 1) {
        $responseCode = 1;

        //Zet lege strings om naar nulls
        foreach ($userInfo as $key => $value){
            if (empty($userInfo[$key])){
                $userInfo[$key] = null;
            }
        }

        //Voer de informatie in
        $registratie = executeQueryNoFetch('INSERT INTO gebruikers(gebruikersnaam, wachtwoord, voornaam, achternaam, geboortedatum, telefoonnmr, land, provincie, postcode, plaatsnaam, straatnaam, huisnummer) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
            [$userInfo['gebruikersnaam'], $userInfo['wachtwoord'], $userInfo['voornaam'], $userInfo['achternaam'], $userInfo['gebdatum'], $userInfo['telnmr'], $userInfo['land'], $userInfo['provincie'], $userInfo['postcode'], $userInfo['plaatsnaam'], $userInfo['straatnaam'], $userInfo['huisnummer']]);
        if ($registratie['code'] == 2){
            $responseCode = $registratie;
        }
    } else {
        $responseCode = $gebruikersnaamCheck;
    }

    echo json_encode($responseCode);
}

function verzendResetEmail($data){
    $token = executeQuery("SELECT token from password_recovery WHERE id = ?", [$data["ID"]]);

    $naar = 'sinke.carsten95@gmail.com';
    $subject = 'Reset password';
    $txt = '<html><body><p>Click <a href="http://iproject34.icasites.nl/passrecovery.php?t='.$token['data'][0]["token"].'">this</a> link to reset your password</p></body></html>';
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'FROM: info@eenmaalandermaal.nl';
    mail($naar,$subject,$txt,$headers);

    echo json_encode(["resultClass" => "success", "message" => "Een reset mail is verstuurd."]);
}

function resetWachtwoord($data) {
    $duplicateCheck = executeQuery("SELECT username FROM password_recovery WHERE username = ?", [$data['username']]);
    if ($duplicateCheck['code'] == 1) {
        $resetId = executeQuery("INSERT INTO password_recovery(username, token, expire_Date, created_Date) OUTPUT Inserted.ID VALUES(?,?,DATEADD(HOUR,4,GETDATE()),GETDATE())", [$data["username"], bin2hex(random_bytes(128))]);
        if ($resetId['code'] == 0) {
            verzendResetEmail($resetId['data'][0]);
        } elseif ($resetId['code'] == 2) {
            echo json_encode(["resultClass" => "warning", "message" => "Ongeldige gebruikersnaam."]);
        }
    } elseif ($duplicateCheck['code'] == 0) {
        echo json_encode(["resultClass" => "warning", "message" => "U heeft al een reset aangevraagd."]);
    }
}

function veranderWachtwoord($data) {
    $username = executeQuery("SELECT username FROM password_recovery WHERE token = ?", [$data["token"]]);
    executeQueryNoFetch("DELETE FROM password_recovery WHERE token = ?", [$data['token']]);
    executeQueryNoFetch("UPDATE gebruikers SET wachtwoord = ? WHERE gebruikersnaam = ?", [password_hash($data["nieuwWachtwoord"], PASSWORD_DEFAULT), $username['data'][0]['username']]);
}

?>
