<?php
include('core.php');

if (!empty($_GET['action'])) {
    $action = $_GET['action'];

    $data = [];

    foreach ($_POST as $key => $value) {
        $data[$key] = htmlspecialchars(strip_tags($value));
    }

    $loginStatus = loginStatus($_SESSION['gebruiker']);

    if (isset($loginStatus)) {
        if ($action == 'aanpassenGegevens') {
            pasgegevensaan($data, $_SESSION['gebruiker']);
            $loginStatus = 0;
        }

        if ($loginStatus === 1) {
            switch ($action) {
                case 'maakVeilingAan':
                    checkFiles($data, $_FILES);
                    break;
                case 'bieden':
                    bieden($data, $_SESSION['gebruiker']);
                    break;
                default:
                    header('HTTP/1.0 404 NOT FOUND');
                    break;
            }
        } elseif ($loginStatus === 2) {
            switch ($action) {
                case 'addCategorieToDatabase':
                    nieuweCategorieToevoegen($data);
                    break;
                case 'sluitVeilingen':
                    sluitVeilingen();
                    break;
                case 'beeindigVeiling':
                    beeindigVeiling($data);
                    break;
                case 'verwijderVeiling':
                    verwijderVeiling($data);
                    break;
                case 'verplaatsVeiling':
                    verplaatsVeiling($data);
                    break;
                case 'veranderAdminStatus':
                    veranderAdminStatus($data);
                    break;
                case 'getGebruikersgegevens':
                    gebruikersgegevens($data);
                    break;
                default:
                    header('HTTP/1.0 404 NOT FOUND');
                    break;
            }
        }
    }
}

function loginStatus($gebruikersnaam){
    if (isset($gebruikersnaam)) {
        $gebruiker = executeQuery("SELECT * FROM gebruikers WHERE gebruikersnaam = ?", [$gebruikersnaam]);

        if ($gebruiker['data'][0]['admin'] == 1) {
            //Ingelogd als admin
            return 2;
        }
        //Ingelogd als gebruiker
        return 1;
    }
    //Niet ingelogd
    return 0;
}

//bieden
function bieden($bieding, $gebruikersnaam)
{
    //Zet de bieding in de database
    $bieding = executeQueryNoFetch(
        "INSERT INTO biedingen(veilingId, gebruikersnaam, biedingsTijd, biedingsBedrag) VALUES(?, ?, ?, ?)",
        [$bieding["veilingId"], $gebruikersnaam, $bieding["biedingsTijd"], $bieding["biedingsBedrag"]]
    );
}


//Sluit veilingen die afgelopen zijn
function sluitVeilingen(){
    //Zoek afgelopen veilingen
    $veilingen = executeQuery("SELECT * FROM veiling WHERE eindDatum < GETDATE() AND veilingGestopt = 0");

    //Geef aan wie de winnaar is voor elke afgelopen veiling
    foreach ($veilingen['data'] as $veiling) {
        executeQueryNoFetch("UPDATE veiling SET koperGebruikersnaam = (SELECT TOP 1 gebruikersnaam FROM biedingen WHERE veilingId = ? ORDER BY biedingsBedrag DESC), verkoopPrijs = (SELECT TOP 1 biedingsBedrag FROM biedingen WHERE veilingId = ? ORDER BY biedingsBedrag DESC), veilingGestopt = 1 WHERE veilingId = ?", [$veiling["veilingId"],$veiling["veilingId"],$veiling["veilingId"]]);
        //Deel het sluiten mee
        verzendEmail($veiling);
    }
}

//Beëindig een veiling handmatig
function beeindigVeiling($veiling){
    //Beëindig de veiling en geef de winnaar aan
    executeQueryNoFetch("UPDATE veiling SET eindDatum = GETDATE(), koperGebruikersnaam = (SELECT TOP 1 gebruikersnaam FROM biedingen WHERE veilingId = ? ORDER BY biedingsBedrag DESC), verkoopPrijs = (SELECT TOP 1 biedingsBedrag FROM biedingen WHERE veilingId = ? ORDER BY biedingsBedrag DESC), veilingGestopt = 1 WHERE veilingId = ?", [$veiling["veilingId"],$veiling["veilingId"],$veiling["veilingId"]]);
    //Deel dit mee
    verzendEmail($veiling);
}

//Verstuur een email
function verzendEmail($data){
    //Veilinginfo
    $veiling = executeQuery("SELECT * FROM veiling WHERE veilingId = ?",[$data["veilingId"]]);
    $veiling = $veiling['data'][0];

    if ($veiling["koperGebruikersnaam"]) {
       $gebruikerInfo = executeQuery("SELECT email FROM gebruikers WHERE username = ?", [$veiling["koperGebruikersnaam"]]);
       $gebruikerEmail = $gebruikerInfo['data'][0]["email"];

       if ($gebruikerEmail) {
           $naar = $gebruikerEmail;          
       } else {
           $naar = "sinke.carsten95@gmail.com";
       }

        //Onderwerp
        $subject = "Gewonnen veiling";
           
        //Bericht
        $txt = ' Veiling: '.$veiling["titel"].' is gewonnen door '.$veiling["koperGebruikersnaam"].'
                Veiling gegevens:
                Veiling Id: '.$veiling["veilingId"].'
                Titel: '.$veiling["titel"].'</td>
                Verkoper: '.$veiling["verkoperGebruikersnaam"].'
                Koper: '.$veiling["koperGebruikersnaam"].'
                Verkoop prijs: '.$veiling["verkoopPrijs"].'';

        $headers = "From: info@EenmaalAndermaal.nl";
        
        mail($naar,$subject,$txt,$headers);

        //Mail naar verkoper
        $verkoperInfo = executeQuery("SELECT email FROM gebruikers WHERE username = ?", [$data["verkoperGebruikersnaam"]]);
        $verkoperEmail = $verkoperInfo["data"][0]["email"];

        if ($verkoperEmail) {
            $naar = $verkoperEmail;
        } else {
            $naar = "sinke.carsten95@gmail.com";
        }

        mail($naar,$subject,$txt,$headers);

    } else {
        $verkoperInfo = executeQuery("SELECT email FROM gebruikers WHERE username = ?", [$data["verkoperGebruikersnaam"]]);
        $verkoperEmail = $verkoperInfo["data"][0]["email"];

        if ($verkoperEmail) {
            $naar = $verkoperEmail;
        } else {
            $naar = "sinke.carsten95@gmail.com";
        }

        $subject = "Veiling is niet verkocht";

        $txt = "Veiling: ".$veiling["titel"]."is niet verkocht
                Veiling gegevens:
                VeilingId: ".$veiling["veilingId"]."
                Titel: ".$veiling["titel"]."
                Verkoper: ".$veiling["verkoperGebruikersnaam"]."";
        $headers = "From info@eenmaalAndermaal.nl";

        mail($naar,$subject,$txt,$headers);
    }
}

//registreren van veiling
function checkFiles($data, $files)
{
    $feedbacks = array();
    $uploadOk = true;

    //Loop door alle files heen
    foreach ($files as $file) {
        //Feedback op de huidig file
        $feedback = array();
        //Pak de filetype van de image
        $imageFileType = pathinfo($file['name'], PATHINFO_EXTENSION);

        //Check het tegen een aantal filetypes
        if (strtolower($imageFileType) != "jpg" && strtolower($imageFileType) != "png" && strtolower($imageFileType) != "jpeg"
            && strtolower($imageFileType) != "gif"
        ) {
            array_push($feedback, $file['name'] . ": Alleen JPG, JPEG, PNG & GIF bestanden zijn toegestaan");
            $uploadOk = false;
        }

        //Check de filesize
        if ($file["size"] > 50000000) {
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
        $response = aanmakenveiling($data, $_SESSION['gebruiker']);
    } else {
        $response = array('code' => 1, 'message' => $feedbacks);
    }

    echo json_encode($response);
}

//Maak de veiling aan
function aanmakenveiling($veilingInfo, $verkoperGebruikersnaam)
{
    //Zet wat info klaar die JS niet klaar kon zetten
    $veilingInfo['categorieId'] = intval($veilingInfo['categorieId']);
    $veilingInfo['startPrijs'] = intval($veilingInfo['startPrijs']);
    $veilingInfo['verkoopPrijs'] = null;
    $veilingInfo['koperGebruikersnaam'] = null;
    $veilingInfo['betalingswijze'] = 'IDEAL';
    $veilingInfo['verzendwijze'] = 'POSTNL';

    //Haal de info van de verkoper op
    $gebruiker = executeQuery("SELECT TOP 01 * FROM gebruikers WHERE gebruikersnaam = ?", [$verkoperGebruikersnaam])['data'][0];

    //Default waardes voor verkooplocatie
    if (empty($veilingInfo['postcode'])) {
        $veilingInfo['postcode'] = $gebruiker['postcode'];
    }
    if (empty($veilingInfo['provincie'])) {
        $veilingInfo['provincie'] = $gebruiker['provincie'];
    }
    if (empty($veilingInfo['plaatsnaam'])) {
        $veilingInfo['plaatsnaam'] = $gebruiker['plaatsnaam'];
    }
    if (empty($veilingInfo['straatnaam'])) {
        $veilingInfo['straatnaam'] = $gebruiker['straatnaam'];
    }
    if (empty($veilingInfo['huisnummer'])) {
        $veilingInfo['huisnummer'] = $gebruiker['huisnummer'];
    }

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
        $veilingInfo['land'], $verkoperGebruikersnaam, $veilingInfo['koperGebruikersnaam'],
        $veilingInfo['startPrijs'], $veilingInfo['verkoopPrijs'], $veilingInfo['provincie'],
        $veilingInfo['plaatsnaam'], $veilingInfo['straatnaam'], $veilingInfo['huisnummer'],
        $veilingInfo['betalingswijze'], $veilingInfo['verzendwijze'], $veilingInfo['beginDatum'],
        $veilingInfo['eindDatum'], $veilingInfo['conditie'], $veilingInfo['thumbNail'], $veilingInfo['veilingGestopt']
    ]);

    if ($veiling['code'] == 0) {
        //Pak het veilingId van de zojuist aangemaakte veiling
        $veilingId = executeQuery("SELECT veilingId FROM veiling WHERE titel = ? AND beschrijving = ? AND verkoperGebruikersnaam = ? AND beginDatum = ?",
            [$veilingInfo['titel'], $veilingInfo['beschrijving'], $verkoperGebruikersnaam, $veilingInfo['beginDatum']]);
        if ($veilingId['code'] == 0) {
            //Upload de files
            return uploadFiles($veilingId['data'][0]['veilingId'], $_SERVER['DOCUMENT_ROOT']);
        }
        return array('code' => 2, 'message' => 'Aangemaakte veiling niet gevonden');
    }
    return array('code' => 2, 'message' => 'Er was een error met het aanmaken van de veiling.');
}

//Uploaden van files
function uploadFiles($veilingId, $root) {
    //Geef de files een prefix-code en zet de directories klaar
    $prefix = date('Ymdhms').rand(0, 999);
    $uploaddirPrefix = $root.'/';
    $uploaddir = 'upload/';

    //Loop door de files heen
    foreach ($_FILES as $key => $file) {
        //Geef aan waar de file heen moet
        $targetFile = $uploaddirPrefix.$uploaddir.$prefix.basename($file['name']);
        //Upload de file
        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            //Zet de thumbnail in de database
            if ($key == 'thumbnail' && $key !== 0) {
                executeQueryNoFetch("UPDATE veiling SET thumbNail = ? WHERE veilingId = ?", [$uploaddir.$prefix.basename($file['name']), $veilingId]);
                continue;
            }
            //Zet de images in de database
            executeQueryNoFetch("INSERT INTO veilingFoto(veilingId, fotoPath) VALUES(?, ?)", [$veilingId, $uploaddir.$prefix.basename($file['name'])]);
        } else {
            return array('code' => 2, 'message' => 'Er ging iets fout met het uploaden van de file: '.$file['name']);
        }
    }

    return array('code' => 0, 'message' => 'Uw veiling is aangemaakt.');
}

//Maak een nieuwe categorie aan
function nieuweCategorieToevoegen($categorie)
{
    //Wanneer er veilingen in de categorie zitten
    if (checkVeilingenInCategorie($categorie["superId"])) {
        //Maak een "Overige" subcategorie aan
        executeQueryNoFetch("INSERT INTO categorie(categorieNaam, superId) VALUES('Overige', ?)", [$categorie["superId"]]);

        //Zoek het categorieId van de "Overige"
        $overigCategorieId = executeQuery("SELECT categorieId FROM categorie WHERE superId = ? AND categorieNaam = 'Overige'", [$categorie["superId"]]);

        //Verplaats alle veilingen naar "Overige"
        executeQueryNoFetch("UPDATE veiling SET categorieId = ? WHERE categorieId = ?", [$overigCategorieId['data'][0]['categorieId'], $categorie["superId"]]);

        //Maak een nieuwe categorie aan
        voegCategorieToe($categorie);

    } else {
        voegCategorieToe($categorie);
    }
}

//Maak een categorie aan
function voegCategorieToe($categorie)
{
    //Zet de nieuwe categorie op de juiste plaats
    echo json_encode(executeQueryNoFetch("INSERT INTO categorie(categorieNaam, superId) VALUES (?, ?)", [
        $categorie["categorieNaam"],
        $categorie["superId"]
    ]));
}

//Aanpassen van gebruikergegevens
function pasgegevensaan($gegevens, $gebruikersnaam) {
    //Haal de oude gegevens op
    $gebruiker = new User($gebruikersnaam);

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
        executeQueryNoFetch("UPDATE gebruikers SET plaatsnaam = ? WHERE gebruikersnaam = ?", [$gegevens['NEWplaats'], $gebruikersnaam]);
    }
    if (!empty($gegevens['NEWprovincie'])) {
        executeQueryNoFetch("UPDATE gebruikers SET provincie = ? WHERE gebruikersnaam = ?", [$gegevens['NEWprovincie'], $gebruikersnaam]);
    }
    if (!empty($gegevens['NEWstraat'])) {
        executeQueryNoFetch("UPDATE gebruikers SET straatnaam = ? WHERE gebruikersnaam = ?", [$gegevens['NEWstraat'], $gebruikersnaam]);
    }
    if (!empty($gegevens['NEWpostcode'])) {
        executeQueryNoFetch("UPDATE gebruikers SET postcode = ? WHERE gebruikersnaam = ?", [$gegevens['NEWpostcode'], $gebruikersnaam]);
    }
    if (!empty($gegevens['NEWtelefoonnummer'])) {
        executeQueryNoFetch("UPDATE gebruikers SET telefoonnmr = ? WHERE gebruikersnaam = ?", [$gegevens['NEWtelefoonnummer'], $gebruikersnaam]);
    }
}

//Verwijder een veiling
function verwijderVeiling($veiling){
    //Verwijder alle biedingen op de veiling
    executeQueryNoFetch("DELETE FROM biedingen WHERE veilingId = ?", [$veiling["veilingId"]]);

    //Verwijder alle keren dat de veiling bekeken is
    executeQueryNoFetch("DELETE FROM history WHERE veilingId = ?", [$veiling["veilingId"]]);

    //Verwijder alle foto's van de veiling
    executeQueryNoFetch("DELETE FROM veilingFoto WHERE veilingId = ?", [$veiling["veilingId"]]);

    //Verwijder de veiling zelf
    executeQueryNoFetch("DELETE FROM veiling WHERE veilingId = ?", [$veiling["veilingId"]]);
}

//Verplaats een veiling
function verplaatsVeiling($veiling){
    //Zet een veiling naar een andere categorie
    executeQueryNoFetch("UPDATE veiling SET categorieId = ? WHERE veilingId = ?", [$veiling["categorieId"], $veiling["veilingId"]]);
}

function gebruikersgegevens($data){
    echo json_encode(executeQuery("SELECT gebruikersnaam, voornaam, achternaam, geboortedatum, admin FROM gebruikers WHERE gebruikersnaam = ?", [$data["gebruikersnaam"]]));
}

function veranderAdminStatus($data){
    executeQueryNoFetch("UPDATE gebruikers SET admin = admin ^ 1 WHERE gebruikersnaam = ?", [$data["gebruikersnaam"]]);
}

?>