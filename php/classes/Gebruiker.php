<?php
class Gebruiker{

    private $gebruikerId;
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

    function Gebruiker($gebruikerId){
        $gebruiker = selectRecords("SELECT * FROM gebruikers WHERE gebruikerId = ?", array($gebruikerId))->fetch();

        $this->gebruikerId = $gebruiker["gebruikerId"];
        $this->wachtwoord = $gebruiker["wachtwoord"];
        $this->voornaam = $gebruiker["voornaam"];
        $this->achternaam = $gebruiker["achternaam"];
        $this->geboortedatum = $gebruiker["geboortedatum"];
        $this->emailAdres = $gebruiker["emailAdres"];
        $this->telefoonnmr = $gebruiker["telefoonnmr"];
        $this->verkoper = $gebruiker["verkoper"];
        $this->land = $gebruiker["land"];
        $this->provincie = $gebruiker["provincie"];
        $this->postcode = $gebruiker["postcode"];
        $this->plaatsnaam = $gebruiker["plaatsnaam"];
        $this->straatnaam = $gebruiker["straatnaam"];
        $this->huisnummer = $gebruiker["huisnummer"];
    }

    /**
     * @param $column Kolomnaam
     * @param $oldVal Oud val
     * @param $newVal Nieuw val
     */
    private function update($column, $oldVal, $newVal){
        voegRecordToe("UPDATE veiling SET ? = ? WHERE ? = ?", array($column, $newVal, $column, $oldVal));
    }

    /**
     * @return mixed
     */
    public function getGebruikerId()
    {
        return $this->gebruikerId;
    }

    /**
     * @param mixed $gebruikerId
     */
    public function setGebruikerId($gebruikerId)
    {
        update("gebruikerId", $this->gebruikerId, $gebruikerId);
        $this->gebruikerId = $gebruikerId;
    }

    /**
     * @return mixed
     */
    public function getWachtwoord()
    {
        return $this->wachtwoord;
    }

    /**
     * @param mixed $wachtwoord
     */
    public function setWachtwoord($wachtwoord)
    {
        update("wachtwoord", $this->wachtwoord, $wachtwoord);
        $this->wachtwoord = $wachtwoord;
    }

    /**
     * @return mixed
     */
    public function getVoornaam()
    {
        return $this->voornaam;
    }

    /**
     * @param mixed $voornaam
     */
    public function setVoornaam($voornaam)
    {
        update("voornaam", $this->voornaam, $voornaam);
        $this->voornaam = $voornaam;
    }

    /**
     * @return mixed
     */
    public function getAchternaam()
    {
        return $this->achternaam;
    }

    /**
     * @param mixed $achternaam
     */
    public function setAchternaam($achternaam)
    {
        update("achternaam", $this->achternaam, $achternaam);
        $this->achternaam = $achternaam;
    }

    /**
     * @return mixed
     */
    public function getGeboortedatum()
    {
        return $this->geboortedatum;
    }

    /**
     * @param mixed $geboortedatum
     */
    public function setGeboortedatum($geboortedatum)
    {
        update("geboortedatum", $this->geboortedatum, $geboortedatum);
        $this->geboortedatum = $geboortedatum;
    }

    /**
     * @return mixed
     */
    public function getEmailAdres()
    {
        return $this->emailAdres;
    }

    /**
     * @param mixed $emailAdres
     */
    public function setEmailAdres($emailAdres)
    {
        update("emailAdres", $this->emailAdres, $emailAdres);
        $this->emailAdres = $emailAdres;
    }

    /**
     * @return mixed
     */
    public function getTelefoonnmr()
    {
        return $this->telefoonnmr;
    }

    /**
     * @param mixed $telefoonnmr
     */
    public function setTelefoonnmr($telefoonnmr)
    {
        update("telefoonnmr", $this->telefoonnmr, $telefoonnmr);
        $this->telefoonnmr = $telefoonnmr;
    }

    /**
     * @return mixed
     */
    public function getVerkoper()
    {
        return $this->verkoper;
    }

    /**
     * @param mixed $verkoper
     */
    public function setVerkoper($verkoper)
    {
        update("verkoper", $this->verkoper, $verkoper);
        $this->verkoper = $verkoper;
    }

    /**
     * @return mixed
     */
    public function getLand()
    {
        return $this->land;
    }

    /**
     * @param mixed $land
     */
    public function setLand($land)
    {
        update("land", $this->land, $land);
        $this->land = $land;
    }

    /**
     * @return mixed
     */
    public function getProvincie()
    {
        return $this->provincie;
    }

    /**
     * @param mixed $provincie
     */
    public function setProvincie($provincie)
    {
        update("provincie", $this->provincie, $provincie);
        $this->provincie = $provincie;
    }

    /**
     * @return mixed
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * @param mixed $postcode
     */
    public function setPostcode($postcode)
    {
        update("postcode", $this->postcode, $postcode);
        $this->postcode = $postcode;
    }

    /**
     * @return mixed
     */
    public function getPlaatsnaam()
    {
        return $this->plaatsnaam;
    }

    /**
     * @param mixed $plaatsnaam
     */
    public function setPlaatsnaam($plaatsnaam)
    {
        update("plaatsnaam", $this->plaatsnaam, $plaatsnaam);
        $this->plaatsnaam = $plaatsnaam;
    }

    /**
     * @return mixed
     */
    public function getStraatnaam()
    {
        return $this->straatnaam;
    }

    /**
     * @param mixed $straatnaam
     */
    public function setStraatnaam($straatnaam)
    {
        update("straatnaam", $this->straatnaam, $straatnaam);
        $this->straatnaam = $straatnaam;
    }

    /**
     * @return mixed
     */
    public function getHuisnummer()
    {
        return $this->huisnummer;
    }

    /**
     * @param mixed $huisnummer
     */
    public function setHuisnummer($huisnummer)
    {
        update("huisnummer", $this->huisnummer, $huisnummer);
        $this->huisnummer = $huisnummer;
    }
}
?>