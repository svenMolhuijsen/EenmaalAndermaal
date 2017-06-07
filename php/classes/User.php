<?php

class User extends Locatie
{
    private $wachtwoord;
    private $voornaam;
    private $achternaam;
    private $geboortedatum;
    private $gebruikersnaam;
    private $telefoonnmr;
    private $admin;

    function __construct($gebruikersnaam)
    {
        $gebruikers = executeQuery("SELECT * FROM gebruikers WHERE gebruikersnaam = ?", [$gebruikersnaam]);
        if ($gebruikers['code'] == 0) {
            $gebruiker = $gebruikers['data']['0'];

            $this->gebruikersnaam = $gebruiker["gebruikersnaam"];
            $this->wachtwoord = $gebruiker["wachtwoord"];
            $this->voornaam = $gebruiker["voornaam"];
            $this->achternaam = $gebruiker["achternaam"];
            $this->geboortedatum = $gebruiker["geboortedatum"];
            $this->telefoonnmr = $gebruiker["telefoonnmr"];
            $this->admin = $gebruiker["admin"];

            $this->land = $gebruiker['land'];
            $this->provincie = $gebruiker['provincie'];
            $this->postcode = $gebruiker['postcode'];
            $this->plaatsnaam = $gebruiker['plaatsnaam'];
            $this->straatnaam = $gebruiker['straatnaam'];
            $this->huisnummer = $gebruiker['huisnummer'];
            
        }
    }

    public static function newUser($gebruikersnaam, $wachtwoord, $voornaam, $achternaam, $geboortedatum, $teloonmr, $admin, $land, $provincie, $postcode, $plaatsnaam, $straatnaam, $huisnummer)
    {
        executeQuery("INSERT INTO Gebruikers (gebruikersnaam, wachtwoord, voormaam, achternaam, geboortedatum, telefoonmr, admin, land, provincie, postcode, plaatsnaam, straatnaam, huisnummer)
                      VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)",
            [$gebruikersnaam, $wachtwoord, $voornaam, $achternaam, $geboortedatum, $teloonmr, $admin, $land, $provincie, $postcode, $plaatsnaam, $straatnaam, $huisnummer]);
    }

    public function toArray()
    {
        return ['gebruikersnaam' => $this->gebruikersnaam,
            'voornaam' => $this->voornaam,
            'achternaam' => $this->achternaam,
            'geboortedatum' => $this->geboortedatum,
            'telefoonmr' => $this->telefoonnmr,
            'verkoper' => $this->admin,
            'land' => $this->land,
            'provincie' => $this->provincie,
            'postcode' => $this->postcode,
            'plaatsnaam' => $this->plaatsnaam,
            'straatnaam' => $this->straatnaam,
            'huisnummer' => $this->huisnummer
        ];
    }

    /**
     * @param $column String Kolomnaam
     * @param $oldVal $oldVal Oud val
     * @param $newVal $newVal Nieuw val
     */
    protected function update($column, $newVal)
    {
        $test = executeQueryNoFetch("UPDATE gebruikers SET ? = ? WHERE gebruikersnaam = ?", [$column, $newVal, $this->gebruikersnaam]);
    }

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
        $this::update("wachtwoord", $wachtwoord);
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
        $this::update("voornaam", $voornaam);
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
        $this::update("achternaam", $achternaam);
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
        $this::update("geboortedatum", $geboortedatum);
        $this->geboortedatum = $geboortedatum;
    }

    /**
     * @return mixed
     */
    public
    function getGebruikersnaam()
    {
        return $this->gebruikersnaam;
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
        $this::update("telefoonnmr", $telefoonnmr);
        $this->telefoonnmr = $telefoonnmr;
    }

    /**
     * @return mixed
     */
    public
    function getAdmin()
    {
        return $this->admin;
    }

    /**
     * @param mixed $verkoper
     */
    public
    function setAdmin($admin)
    {
        $this::update("admin", $admin);
        $this->admin = $admin;
    }
}

?>