<?php

class Veiling
{

    private $veilingId;
    private $titel;
    private $beschrijving;
    private $verkoperId;
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
    private $categorie;

    public function __construct($veilingId)
    {
        $veiling = executeQuery("SELECT * FROM veiling WHERE veilingId = ?", [$veilingId]);
        if ($veiling['code'] = 0) {
            $this->veilingId = $veiling['data']["veilingId"];
            $this->titel = $veiling['data']["titel"];
            $this->beschrijving = $veiling['data']["beschrijving"];
            $this->verkoperId = $veiling['data']["verkoperId"];
            $this->koperId = $veiling['data']["koperId"];
            $this->startPrijs = $veiling['data']["startPrijs"];
            $this->verkoopPrijs = $veiling['data']["verkoopPrijs"];
            $this->verzendKosten = $veiling['data']["verzendKosten"];
            $this->betalingswijze = $veiling['data']["betalingswijze"];
            $this->verzendwijze = $veiling['data']["verzendwijze"];
            $this->beginDatum = $veiling['data']["beginDatum"];
            $this->eindDatum = $veiling['data']["eindDatum"];
            $this->land = $veiling['data']["land"];
            $this->provincie = $veiling['data']["provincie"];
            $this->postcode = $veiling['data']["postcode"];
            $this->plaatsnaam = $veiling['data']["plaatsnaam"];
            $this->straatnaam = $veiling['data']["straatnaam"];
            $this->huisnummer = $veiling['data']["huisnummmer"];
            $this->categorie = $veiling['data']['data']["categorie"];
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
        update("veilingId", $this->veilingId, $veilingId);
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
        update("titel", $this->titel, $titel);
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
        update("beschrijving", $this->beschrijving, $beschrijving);
        $this->beschrijving = $beschrijving;
    }

    /**
     * @return mixed
     */
    public
    function getVerkoperId()
    {
        return $this->verkoperId;
    }

    /**
     * @param mixed $verkoperId
     */
    public
    function setVerkoperId($verkoperId)
    {
        update("verkoperId", $this->verkoperId, $verkoperId);
        $this->verkoperId = $verkoperId;
    }

    /**
     * @return mixed
     */
    public
    function getKoperId()
    {
        return $this->koperId;
    }

    /**
     * @param mixed $koperId
     */
    public
    function setKoperId($koperId)
    {
        update("koperId", $this->koperId, $koperId);
        $this->koperId = $koperId;
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
        update("startPrijs", $this->startPrijs, $startPrijs);
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
        update("verkoopPrijs", $this->verkoopPrijs, $verkoopPrijs);
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
        update("verzendKosten", $this->verzendKosten, $verzendKosten);
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
        update("betalingswijze", $this->betalingswijze, $betalingswijze);
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
        update("verzendwijze", $this->verzendwijze, $verzendwijze);
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
        update("beginDatum", $this->beginDatum, $beginDatum);
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
        update("eindDatum", $this->eindDatum, $eindDatum);
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
     * @return mixed
     */
    public
    function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * @param mixed $categorie
     */
    public
    function setCategorie($categorie)
    {
        update("categorie", $this->categorie, $categorie);
        $this->categorie = $categorie;
    }
}
?>