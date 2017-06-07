<?php
class Categorie {
    private $categorieId;
    private $categorieNaam;
    private $superId;

    function __construct($categorieId){
        $categorien = executeQuery("SELECT * FROM categorie WHERE categorieId = ?", [$categorieId]);

        if ($categorien["code"] == 0) {
            $categorie = $categorien["data"][0];

            $this->categorieId = $categorie["categorieId"];
            $this->categorieNaam = $categorie["categorieNaam"];
            $this->superId = $categorie["superId"];
        }
    }

    private
    function update($column, $oldVal, $newVal)
    {
        executeQuery("UPDATE Categorie SET ? = ? WHERE ? = ?", [$column, $newVal, $column, $oldVal]);
    }

    /**
     * @return mixed
     */
    public function getCategorieId()
    {
        return $this->categorieId;
    }

    /**
     * @param mixed $categorieId
     */
    public function setCategorieId($categorieId)
    {
        $this::update("categorieId", $this->categorieId, $categorieId);
        $this->categorieId = $categorieId;
    }

    /**
     * @return mixed
     */
    public function getCategorieNaam()
    {
        return $this->categorieNaam;
    }

    /**
     * @param mixed $categorieNaam
     */
    public function setCategorieNaam($categorieNaam)
    {
        $this::update("categorieNaam", $this->categorieNaam, $categorieNaam);
        $this->categorieNaam = $categorieNaam;
    }

    /**
     * @return mixed
     */
    public function getSuperId()
    {
        return $this->superId;
    }

    /**
     * @param mixed $superId
     */
    public function setSuperId($superId)
    {
        $this::update("superId", $this->superId, $superId);
        $this->superId = $superId;
    }
}
?>