<?php

/**
 * 
 */
abstract class Locatie
{
    protected $land;
    protected $provincie;
    protected $postcode;
    protected $plaatsnaam;
    protected $straatnaam;
    protected $huisnummer;

     /**
     * @param $column String kolomnaam
     * @param $oldVal $oldVal Waarde om te veranderen
     * @param $newVal $newVal Nieuwe waarde
     */
    protected
    abstract function update($column, $newVal);

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
        $this::update("land", $land);
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
        $this::update("provincie", $provincie);
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
        $this::update("postcode", $postcode);
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
        $this::update("plaatsnaam", $plaatsnaam);
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
        $this::update("straatnaam", $straatnaam);
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
        $this::update("huisnummer", $huisnummer);
        $this->huisnummer = $huisnummer;
    }

}
?>