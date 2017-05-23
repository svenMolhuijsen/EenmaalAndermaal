<?php

class Veiling
{
    private $code;
    private $veilingId;
    private $titel;
    private $beschrijving;
    private $verkoperGebruikersnaam;
    private $koperId;
    private $startPrijs;
    private $verkoopPrijs;
    private $verzendKosten;
    private $betalingswijze;
    private $verzendwijze;
    private $beginDatum;
    private $eindDatum;
    private $land;
    private $provincie;
    private $postcode;
    private $plaatsnaam;
    private $straatnaam;
    private $huisnummer;
    private $categorieId;

    public function __construct($veilingId)
    {
        $veilingen = executeQuery("SELECT * FROM veiling WHERE veilingId = ?", [$veilingId]);
        $this->code = $veilingen['code'];

        if ($veilingen['code'] == 0) {
            $veiling = $veilingen['data'][0];
            $this->veilingId = $veiling["veilingId"];
            $this->titel = $veiling["titel"];
            $this->beschrijving = $veiling["beschrijving"];
            $this->verkoperGebruikersnaam = $veiling["verkoperGebruikersnaam"];
            $this->koperGebruikersnaam = $veiling["koperGebruikersnaam"];
            $this->startPrijs = $veiling["startPrijs"];
            $this->verkoopPrijs = $veiling["verkoopPrijs"];
            $this->betalingswijze = $veiling["betalingswijze"];
            $this->verzendwijze = $veiling["verzendwijze"];
            $this->beginDatum = $veiling["beginDatum"];
            $this->eindDatum = $veiling["eindDatum"];
            $this->land = $veiling["land"];
            $this->provincie = $veiling["provincie"];
            $this->postcode = $veiling["postcode"];
            $this->plaatsnaam = $veiling["plaatsnaam"];
            $this->straatnaam = $veiling["straatnaam"];
            $this->huisnummer = $veiling["huisnummer"];
            $this->categorieId = $veiling["categorieId"];
            $this->veilingGestopt = $veiling["veilingGestopt"];
        }
    }

    /**
     * @param $column Kolomnaam
     * @param $oldVal Doelwaarde om te veranderen
     * @param $newVal Nieuwe waarde
     */
    private
    function update($column, $oldVal, $newVal)
    {
        return $result = executeQuery("UPDATE veiling SET ? = ? WHERE ? = ?", array($column, $newVal, $column, $oldVal));
    }

    public
    function getVeilingGestopt(){
        return $this->veilingGestopt;
    }

    public
    function setVeilingGestopt($veilingGestopt){
        $this::update("veilingGestopt", $this->veilingGestopt, $veilingGestopt);
        $this->veilingGestopt = $veilingGestopt;
    }

    public
    function getCode(){
        return $this->code;
    }

    /**
     * @return mixed
     */
    public
    function getVeilingId()
    {
        return $this->veilingId;
    }

    /**
     * @param mixed $veilingId
     */
    public
    function setVeilingId($veilingId)
    {
        $this::update("veilingId", $this->veilingId, $veilingId);
        $this->veilingId = $veilingId;
    }

    /**
     * @return mixed
     */
    public
    function getTitel()
    {
        return $this->titel;
    }

    /**
     * @param mixed $titel
     */
    public
    function setTitel($titel)
    {
        $this::update("titel", $this->titel, $titel);
        $this->titel = $titel;
    }

    /**
     * @return mixed
     */
    public
    function getBeschrijving()
    {
        return $this->beschrijving;
    }

    /**
     * @param mixed $beschrijving
     */
    public
    function setBeschrijving($beschrijving)
    {
        $this::update("beschrijving", $this->beschrijving, $beschrijving);
        $this->beschrijving = $beschrijving;
    }

    /**
     * @return mixed
     */
    public
    function getVerkoperGebruikersnaam()
    {
        return $this->verkoperGebruikersnaam;
    }

    /**
     * @param mixed $verkoperId
     */
    public
    function setVerkoperGebruikersnaam($verkoperGebruikersnaam)
    {
        $this::update("verkoperGebruikersnaam", $this->verkoperGebruikersnaam, $verkoperGebruikersnaam);
        $this->verkoperGebruikersnaam = $verkoperGebruikersnaam;
    }

    /**
     * @return mixed
     */
    public
    function getKoperGebruikersnaam()
    {
        return $this->koperGebruikersnaam;
    }

    /**
     * @param mixed $koperId
     */
    public
    function setKoperGebruikersnaam($koperGebruikersnaam)
    {
        $this::update("koperGebruikersnaam", $this->koperGebruikersnaam, $koperGebruikersnaam);
        $this->koperId = $koperGebruikersnaam;
    }

    /**
     * @return mixed
     */
    public
    function getStartPrijs()
    {
        return $this->startPrijs;
    }

    /**
     * @param mixed $startPrijs
     */
    public
    function setStartPrijs($startPrijs)
    {
        $this::update("startPrijs", $this->startPrijs, $startPrijs);
        $this->startPrijs = $startPrijs;
    }

    /**
     * @return mixed
     */
    public
    function getVerkoopPrijs()
    {
        return $this->verkoopPrijs;
    }

    /**
     * @param mixed $verkoopPrijs
     */
    public
    function setVerkoopPrijs($verkoopPrijs)
    {
        $this::update("verkoopPrijs", $this->verkoopPrijs, $verkoopPrijs);
        $this->verkoopPrijs = $verkoopPrijs;
    }

    /**
     * @return mixed
     */
    public
    function getVerzendKosten()
    {
        return $this->verzendKosten;
    }

    /**
     * @param mixed $verzendKosten
     */
    public
    function setVerzendKosten($verzendKosten)
    {
        $this::update("verzendKosten", $this->verzendKosten, $verzendKosten);
        $this->verzendKosten = $verzendKosten;
    }

    /**
     * @return mixed
     */
    public
    function getBetalingswijze()
    {
        return $this->betalingswijze;
    }

    /**
     * @param mixed $betalingswijze
     */
    public
    function setBetalingswijze($betalingswijze)
    {
        $this::update("betalingswijze", $this->betalingswijze, $betalingswijze);
        $this->betalingswijze = $betalingswijze;
    }

    /**
     * @return mixed
     */
    public
    function getVerzendwijze()
    {
        return $this->verzendwijze;
    }

    /**
     * @param mixed $verzendwijze
     */
    public
    function setVerzendwijze($verzendwijze)
    {
        $this::update("verzendwijze", $this->verzendwijze, $verzendwijze);
        $this->verzendwijze = $verzendwijze;
    }

    /**
     * @return mixed
     */
    public
    function getBeginDatum()
    {
        return $this->beginDatum;
    }

    /**
     * @param mixed $beginDatum
     */
    public
    function setBeginDatum($beginDatum)
    {
        $this::update("beginDatum", $this->beginDatum, $beginDatum);
        $this->beginDatum = $beginDatum;
    }

    /**
     * @return mixed
     */
    public
    function getEindDatum()
    {
        return $this->eindDatum;
    }

    /**
     * @param mixed $eindDatum
     */
    public
    function setEindDatum($eindDatum)
    {
        $this::update("eindDatum", $this->eindDatum, $eindDatum);
        $this->eindDatum = $eindDatum;
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
        $this::update("land", $this->land, $land);
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
        $this::update("provincie", $this->provincie, $provincie);
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
        $this::update("postcode", $this->postcode, $postcode);
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
        $this::update("plaatsnaam", $this->plaatsnaam, $plaatsnaam);
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
        $this::update("straatnaam", $this->straatnaam, $straatnaam);
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
        $this::update("huisnummer", $this->huisnummer, $huisnummer);
        $this->huisnummer = $huisnummer;
    }

    /**
     * @return mixed
     */
    public
    function getCategorieId()
    {
        return $this->categorieId;
    }

    /**
     * @param mixed $categorie
     */
    public
    function setCategorieId($categorieId)
    {
        $this::update("categorieId", $this->categorieId, $categorieId);
        $this->categorieId = $categorieId;
    }
}
?>