<?php

class User
{

    private $wachtwoord;
    private $voornaam;
    private $achternaam;
    private $geboortedatum;
    private $emailAdres;
    private $telefoonnmr;
    private $verkoper;
    private $land;
    private $provincie;
    private $postcode;
    private $plaatsnaam;
    private $straatnaam;
    private $huisnummer;

    function __construct($emailAdres)
    {
        $gebruiker = executeQuery("SELECT * FROM gebruikers WHERE gebruikerId = ?", [$emailAdres]);
        if ($gebruiker['code'] == 0) {

            $this->emailAdres = $gebruiker['data']["emailAdres"];
            $this->wachtwoord = $gebruiker['data']["wachtwoord"];
            $this->voornaam = $gebruiker['data']["voornaam"];
            $this->achternaam = $gebruiker['data']["achternaam"];
            $this->geboortedatum = $gebruiker['data']["geboortedatum"];
            $this->telefoonnmr = $gebruiker['data']["telefoonnmr"];
            $this->verkoper = $gebruiker['data']["verkoper"];
            $this->land = $gebruiker['data']["land"];
            $this->provincie = $gebruiker['data']["provincie"];
            $this->postcode = $gebruiker['data']["postcode"];
            $this->plaatsnaam = $gebruiker['data']["plaatsnaam"];
            $this->straatnaam = $gebruiker['data']["straatnaam"];
            $this->huisnummer = $gebruiker['data']["huisnummer"];
        }
    }

    public static function newGebruiker($email, $wachtwoord, $voornaam, $achternaam, $geboortedatum, $teloonmr, $verkoper, $land, $provincie, $postcode, $plaatsnaam, $straatnaam, $huisnummer)
    {
        voegRecordToe("INSERT INTO Gebruikers (email, wachtwoord, voormaam, achternaam, geboortedatum, telefoonmr, verkoper, land, provincie, postcode, plaatsnaam, straatnaam, huisnummer)
                                               ?      ?           ?         ?           ?               ?          ?          ?     ?         ?         ?           ?           ?",
            [$email, $wachtwoord, $voornaam, $achternaam, $geboortedatum, $teloonmr, $verkoper, $land, $provincie, $postcode, $plaatsnaam, $straatnaam, $huisnummer]);
    }

    /**
     * @return mixed
     */
    public
    function getGebruikerId()
    {
        return $this->gebruikerId;
    }

    /**
     * @param mixed $gebruikerId
     */
    public
    function setGebruikerId($gebruikerId)
    {
        update("gebruikerId", $this->gebruikerId, $gebruikerId);
        $this->gebruikerId = $gebruikerId;
    }

    /**
     * @return mixed
     */
    public
    function getWachtwoord()
    {
        return $this->wachtwoord;
    }

    /**
     * @param mixed $wachtwoord
     */
    public
    function setWachtwoord($wachtwoord)
    {
        update("wachtwoord", $this->wachtwoord, $wachtwoord);
        $this->wachtwoord = $wachtwoord;
    }

    /**
     * @return mixed
     */
    public
    function getVoornaam()
    {
        return $this->voornaam;
    }

    /**
     * @param mixed $voornaam
     */
    public
    function setVoornaam($voornaam)
    {
        update("voornaam", $this->voornaam, $voornaam);
        $this->voornaam = $voornaam;
    }

    /**
     * @return mixed
     */
    public
    function getAchternaam()
    {
        return $this->achternaam;
    }

    /**
     * @param mixed $achternaam
     */
    public
    function setAchternaam($achternaam)
    {
        update("achternaam", $this->achternaam, $achternaam);
        $this->achternaam = $achternaam;
    }

    /**
     * @return mixed
     */
    public
    function getGeboortedatum()
    {
        return $this->geboortedatum;
    }

    /**
     * @param mixed $geboortedatum
     */
    public
    function setGeboortedatum($geboortedatum)
    {
        update("geboortedatum", $this->geboortedatum, $geboortedatum);
        $this->geboortedatum = $geboortedatum;
    }

    /**
     * @return mixed
     */
    public
    function getEmailAdres()
    {
        return $this->emailAdres;
    }

    /**
     * @param mixed $emailAdres
     */
    public
    function setEmailAdres($emailAdres)
    {
        update("emailAdres", $this->emailAdres, $emailAdres);
        $this->emailAdres = $emailAdres;
    }

    /**
     * @return mixed
     */
    public
    function getTelefoonnmr()
    {
        return $this->telefoonnmr;
    }

    /**
     * @param mixed $telefoonnmr
     */
    public
    function setTelefoonnmr($telefoonnmr)
    {
        update("telefoonnmr", $this->telefoonnmr, $telefoonnmr);
        $this->telefoonnmr = $telefoonnmr;
    }

    /**
     * @return mixed
     */
    public
    function getVerkoper()
    {
        return $this->verkoper;
    }

    /**
     * @param mixed $verkoper
     */
    public
    function setVerkoper($verkoper)
    {
        update("verkoper", $this->verkoper, $verkoper);
        $this->verkoper = $verkoper;
    }

    /**
     * @return mixed
     */
    public
    function getLand()
    {
        return $this->land;
    }

    /**
     * @param mixed $land
     */
    public
    function setLand($land)
    {
        update("land", $this->land, $land);
        $this->land = $land;
    }

    /**
     * @return mixed
     */
    public
    function getProvincie()
    {
        return $this->provincie;
    }

    /**
     * @param mixed $provincie
     */
    public
    function setProvincie($provincie)
    {
        update("provincie", $this->provincie, $provincie);
        $this->provincie = $provincie;
    }

    /**
     * @return mixed
     */
    public
    function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * @param mixed $postcode
     */
    public
    function setPostcode($postcode)
    {
        update("postcode", $this->postcode, $postcode);
        $this->postcode = $postcode;
    }

    /**
     * @return mixed
     */
    public
    function getPlaatsnaam()
    {
        return $this->plaatsnaam;
    }

    /**
     * @param mixed $plaatsnaam
     */
    public
    function setPlaatsnaam($plaatsnaam)
    {
        update("plaatsnaam", $this->plaatsnaam, $plaatsnaam);
        $this->plaatsnaam = $plaatsnaam;
    }

    /**
     * @return mixed
     */
    public
    function getStraatnaam()
    {
        return $this->straatnaam;
    }

    /**
     * @param mixed $straatnaam
     */
    public
    function setStraatnaam($straatnaam)
    {
        update("straatnaam", $this->straatnaam, $straatnaam);
        $this->straatnaam = $straatnaam;
    }

    /**
     * @return mixed
     */
    public
    function getHuisnummer()
    {
        return $this->huisnummer;
    }

    /**
     * @param mixed $huisnummer
     */
    public
    function setHuisnummer($huisnummer)
    {
        update("huisnummer", $this->huisnummer, $huisnummer);
        $this->huisnummer = $huisnummer;
    }

    /**
     * @param $column Kolomnaam
     * @param $oldVal Oud val
     * @param $newVal Nieuw val
     */
    private
    function update($column, $oldVal, $newVal)
    {
        voegRecordToe("UPDATE veiling SET ? = ? WHERE ? = ?", array($column, $newVal, $column, $oldVal));
    }
}

?>