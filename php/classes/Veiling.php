<?php

//Alle informatie van een veiling in class-vorm
class Veiling extends Locatie
{
    //Eigenschappen van een veiling
    private $veilingId;
    private $titel;
    private $beschrijving;
    private $verkoperGebruikersnaam;
    private $koperGebruikersnaam;
    private $koperId;
    private $startPrijs;
    private $verkoopPrijs;
    private $verzendKosten;
    private $betalingswijze;
    private $verzendwijze;
    private $beginDatum;
    private $eindDatum;
    private $categorieId;
    private $code;
    private $veilingGestopt;
    private $thumbNail;

    public function __construct(){
    }

    //Vult de gegevens
    public function fill($veiling){
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
        $this->categorieId = $veiling["categorieId"];
        $this->veilingGestopt = $veiling["veilingGestopt"];
        $this->thumbNail = $veiling["thumbNail"];
    }

    //Constructor van een bestaande veiling
    public static function existingVeiling($veilingId) {
        //Maakt zichzelf aan
        $instance = new self();

        //Zoek de veilingInformatie
        $veilingen = executeQuery("SELECT TOP 1 * FROM veiling WHERE veilingId = ?", [$veilingId]);
        if ($veilingen['code'] == 0) {
            //Vult zichzelf wanneer de veiling gevonden is
            $instance->fill($veilingen['data'][0]);
        }
        //Geef de status code mee
        $instance->setCode($veilingen['code']);

        return $instance;
    }

    //Constructor voor een nog-niet-bestaande veiling
    public static function newVeiling($veiling) {
        $instance = new self();
        $instance->fill($veiling);
        return $instance;
    }

    //Update de veiling in de database
    protected
    function update($column, $newVal)
    {
         executeQuery("UPDATE veiling SET ? = ? WHERE veilingId = ?", [$column, $newVal, $this->veilingId]);
    }

    //////////////////////
    //Getters en setters
    //////////////////////
    public
    function getThumbNail(){
        return $this->thumbNail;
    }

    public
    function setThumbNail($thumbNail){
        $this::update("thumbNail", $thumbNail);
        $this->prefix = $thumbNail;
    }

    public
    function getCode(){
        return $this->code;
    }

    public
    function setCode($code){
        $this->code = $code;
    }

    public
    function getVeilingGestopt(){
        return $this->veilingGestopt;
    }
    //UPDATE veiling SET veilingGestopt = 0 WHERE veilingId = 6576921535
    public
    function setVeilingGestopt($veilingGestopt){
        //$this::update("veilingGestopt","veilingId", $this->veilingId, $veilingGestopt);
        //$this->veilingGestopt = $veilingGestopt;
        $hoogsteBod = executeQuery("SELECT top 1 gebruikersnaam, biedingsBedrag FROM biedingen WHERE veilingId = ? ORDER BY biedingsBedrag DESC ", [
            $this->veilingId
        ]);

        return executeQuery("UPDATE veiling SET veilingGestopt = ?, koperGebruikersnaam = ?, verkoopPrijs = ? WHERE veilingId = ? ",[
            $veilingGestopt,
            $hoogsteBod["data"][0]["gebruikersnaam"],
            $hoogsteBod["data"][0]["biedingsBedrag"],
            $this->veilingId

        ]);
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
        $this::update("titel", $titel);
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
        $this::update("beschrijving", $beschrijving);
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
        $this::update("verkoperGebruikersnaam", $verkoperGebruikersnaam);
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
        $this::update("koperGebruikersnaam", $koperGebruikersnaam);
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
        $this::update("startPrijs", $startPrijs);
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
        $this::update("verkoopPrijs", $verkoopPrijs);
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
        $this::update("verzendKosten", $verzendKosten);
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
        $this::update("betalingswijze", $betalingswijze);
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
        $this::update("verzendwijze", $verzendwijze);
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
        $this::update("beginDatum", $beginDatum);
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
        $this::update("eindDatum", $eindDatum);
        $this->eindDatum = $eindDatum;
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
        $this::update("categorieId", $categorieId);
        $this->categorieId = $categorieId;
    }
}
?>