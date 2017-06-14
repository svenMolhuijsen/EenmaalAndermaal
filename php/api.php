<?php
include("core.php");
//wanneer api call wordt gedaan
if (!empty($_GET['action'])) {
    $action = $_GET['action'];

    $data = [];

    foreach ($_POST as $key => $value) {
        $data[$key] = htmlspecialchars(strip_tags($value));
    }

    switch ($action) {
        // Inloggen
        case 'login':
            login($data);
            break;
        // Uitloggen
        case 'logout':
            logout();
            break;
        case 'getNumRows':
            getNumRows($data);
            break;
        case 'getCategories' :
            $hoofdCategory = null;
            $hoofdCategory = trim($data['hoofdCategory']);
            $params = array(
                'hoofdCategory' => $hoofdCategory
            );
            getSubCategories($params);
            break;
        case 'search':
            search($data);
            break;
        case'getParentCategories':
            $category = trim($data['category']);
            getParentCategories($category);
            break;
        case 'biedingCheck':
            getHoogsteBod($data);
            break;
        case 'getVeilingInfo':
            getVeilingInfo($data);
            break;
        case 'getBiedingInfo':
            getBiedingInfo($data, $_SESSION['gebruiker']);
            break;
        case 'trending':
            trending();
            break;
        case 'registreer':
            registreer($data);
            break;
        case 'resetWachtwoord':
            resetWachtwoord($data);
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
        echo json_encode(['code' => 1, "message" => "Een van de velden is niet ingevuld"]);
        return;
    }
    //Check of de gebruikersnaam en wachtwoord combinatie bij elkaar hoort
    $result = executeQuery("SELECT TOP 1 gebruikersnaam, wachtwoord FROM gebruikers WHERE gebruikersnaam = ?", [$gebruikersnaam]);
    if ($result['code'] == 0) {
        if (password_verify($wachtwoord, $result['data'][0]["wachtwoord"])) {
            //Stel de sessie in
            $_SESSION['gebruiker'] = $gebruikersnaam;
            echo json_encode(['code' => 0, 'message' => 'succesvol ingelogd']);
            return;
        }
        echo json_encode(['code' => 1, 'message' => 'logingegevens kloppen niet']);
        return;
    }
    echo json_encode(['code' => 1, 'message' => 'logingegevens kloppen niet']);
    return;
}

//Uitloggen
function logout() {
    //Maak de sessie leeg
    session_unset();
    //Vernietig de sessie
    session_destroy();

    //Geef het resultaat terug
    echo json_encode(['code' => 0, 'message' => 'Successvol uitgelogd']);
}

function getNumRows($data)
{
    $searchterm = $data['searchterm'];
    $minprice = (float)$data['minprice'];
    $maxprice = (float)$data['maxprice'];
    $category = (int)$data['category'];
    $sortering = $data['sortering'];


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
    echo json_encode($result);
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
    echo json_encode($result);
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

    echo json_encode($result);

}

//Pak de subcategoriën van een opgegeven hoofdcategorie
function getSubCategories($data)
{
    if ($data['hoofdCategory'] == null) {
        //Geef de hoofdcategoriën als er geen is ingesteld
        $result = executeQuery("SELECT * FROM categorie WHERE superId IS NULL ORDER BY categorieNaam");
    } else {
        $result = executeQuery("SELECT * FROM categorie WHERE superId = ? ORDER BY categorieNaam", [$data['hoofdCategory']]);
    }
    echo json_encode($result);
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
    $hoofdcategorien = executeQuery("SELECT * FROM categorie WHERE superId IS NULL ORDER BY categorieNaam");

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
            $subcategorien = executeQuery("SELECT * FROM categorie WHERE superId = ? ORDER BY categorieNaam", [$hoofdcategorie['categorieId']]);

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

//Zet de subcategoriën neer
function setSubcategorien($hoofdcategorie)
{
    //Zoek de subcategoriën
    $hoofdcategorie = substr($hoofdcategorie, 12);
    $subcategorien = executeQuery("SELECT * FROM categorie WHERE superId = ? ORDER BY categorieNaam", [$hoofdcategorie]);

    //Zet voor elke subcategorie een image neer
    if ($subcategorien['code'] == 0) {
        for ($i = 0; $i < count($subcategorien['data']); $i++) {
            $subcategorie = $subcategorien['data'][$i];
            echo('<div class="column">');
            echo('<img rel="categorie-' . $subcategorie['superId'] . '" class="categorieImage thumbnail" src="http://placehold.it/600x600">');
            echo('</div>');
        }
    }
}

//Zoek het hoogste bod
function getHoogsteBod($data)
{
    echo json_encode(executeQuery("SELECT TOP 1 * FROM biedingen WHERE veilingId = ? ORDER BY biedingsBedrag DESC", [$data["veilingId"]]));
}

//Geef de info van de veiling en gebruiker
function getVeilingInfo($data)
{
   echo json_encode(executeQuery("SELECT * FROM veiling WHERE veilingId = ?", [$data["veilingId"]]));
}

//Geef de info van een bod
function getBiedingInfo($data, $gebruikersnaam){
    echo json_encode(['code' => 0, 'data' => ["gebruiker" => $gebruikersnaam, "veiling" => executeQuery("SELECT * FROM veiling WHERE veilingId = ?", [$data["veilingId"]])]]);
}

//Geeft alle landen
function getLanden()
{
    return executeQuery("SELECT  * FROM landen", null);
}

//Geeft terug of er veilingen in een categorie zitten
function checkVeilingenInCategorie($categorieId)
{
    //Zoek alle veilingen
    $veiling = executeQuery("SELECT count(*)  AS aantal FROM veiling WHERE categorieId = ?", [$categorieId]);

    if ($veiling['code'] == 0) {
        if ($veiling['data'][0]['aantal'] > 0) {
            return true;
        } else {
            return false;
        }
    }
    return null;
}

//Geef de 6 meest bezochte veilingen
function trending()
{
    echo json_encode(executeQuery("SELECT * FROM veiling WHERE veilingId IN(SELECT TOP 6 h.veilingId FROM history h, veiling v WHERE h.veilingId = v.veilingId AND CONVERT(DATE, v.eindDatum) > GETDATE() GROUP BY h.veilingId ORDER BY COUNT(h.veilingId) DESC)"));
}

//Registreren
function registreer($userInfo){
    //Kijk of de gebruikersnaam al bestaat
    $gebruikersnaamCheck = executeQuery("SELECT gebruikersnaam FROM gebruikers WHERE gebruikersnaam = ?", [$userInfo['gebruikersnaam']]);

    if ($gebruikersnaamCheck['code'] == 0) {

        echo json_encode(['code' => 0]);
        return;
    } elseif ($gebruikersnaamCheck['code'] == 1) {

        //Zet lege strings om naar nulls
        foreach ($userInfo as $key => $value){

            if (empty($userInfo[$key])){

                $value = null;
            }
        }

        //Voer de informatie in
        $registratie = executeQueryNoFetch('INSERT INTO gebruikers(gebruikersnaam, wachtwoord, voornaam, achternaam, geboortedatum, telefoonnmr, admin, land, provincie, postcode, plaatsnaam, straatnaam, huisnummer) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
            [$userInfo['gebruikersnaam'], password_hash($userInfo['wachtwoord'], PASSWORD_DEFAULT), $userInfo['voornaam'], $userInfo['achternaam'], $userInfo['gebdatum'], $userInfo['telnmr'], 0, $userInfo['land'], $userInfo['provincie'], $userInfo['postcode'], $userInfo['plaatsnaam'], $userInfo['straatnaam'], $userInfo['huisnummer']]);

        if ($registratie['code'] == 2){
            echo json_encode(['code' => 2]);
            return;
        }

        echo json_encode(['code' => 1]);
        return;
    }
}

//Verstuur een wachtwoord reset email
function verzendResetEmail($data){
    //Genereer een tijdelijk token
    $token = executeQuery("SELECT token from password_recovery WHERE id = ?", [$data["ID"]]);

    $naar = 'sinke.carsten95@gmail.com';
    $subject = 'Reset password';
    $txt = '<html><body><p>Click <a href="http://iproject34.icasites.nl/passrecovery.php?t='.$token['data'][0]["token"].'">this</a> link to reset your password</p></body></html>';
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'FROM: info@eenmaalandermaal.nl';
    mail($naar,$subject,$txt,$headers);

    echo json_encode(['code' => 0, 'data' => "success", "message" => "Een reset mail is verstuurd."]);
}

//Opnieuw instellen van een wachtwoord
function resetWachtwoord($data) {
    //Zorg dat er maar 1 token actief kan zijn per gebruiker
    executeQueryNoFetch("DELETE FROM password_recovery WHERE expire_Date < GETDATE()", []);
    $duplicateCheck = executeQuery("SELECT username FROM password_recovery WHERE username = ?", [$data['username']]);
    if ($duplicateCheck['code'] == 1) {
        //Maak een token aan
        $resetId = executeQuery("INSERT INTO password_recovery(username, token, expire_Date, created_Date) OUTPUT Inserted.ID VALUES(?,?,DATEADD(HOUR,4,GETDATE()),GETDATE())", [$data["username"], bin2hex(random_bytes(128))]);
        if ($resetId['code'] == 0) {
            //Stuur een mail voor de reset
            verzendResetEmail($resetId['data'][0]);
            return;
        } elseif ($resetId['code'] == 2) {
            //Wanneer er geen geldige gebruikersnaam wordt meegegeven
            echo json_encode(['code' => 1, "data" => "warning", "message" => "Ongeldige gebruikersnaam."]);
            return;
        }
    } elseif ($duplicateCheck['code'] == 0) {
        //Wanneer er al een token actief is voor de opgegeven gebruiker
        echo json_encode(['code' => 1, "data" => "warning", "message" => "U heeft al een reset aangevraagd."]);
        return;
    }
    echo json_encode($duplicateCheck);
}

?>
