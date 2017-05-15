<?php
class Bieding {
    private $veilingId;
    private $email;
    private $biedingsTijd;
    private $biedingsBedrag;

    function __construct($veilingId) {
        $biedingen = executeQuery("SELECT * FROM biedingen WHERE veilingId = ?", [$veilingId]);

        if($biedingen["code"] == 0){
            $bieding = $biedingen["data"][0];

            $this->veilingId = $bieding["veilingId"];
            $this->email = $bieding["email"];
            $this->biedingsTijd = $bieding["biedingsTijd"];
            $this->biedingsBedrag = $bieding["biedingsBedrag"];
        }
    }

    public function toArray()
    {
        return [
            'veilingId' => $this->veilingId,
            'email' => $this->email,
            'biedingsTijd' => $this->biedingsTijd,
            'biedingsBedrag' => $this->biedingsBedrag
        ];
    }

    private
    function update($column, $oldVal, $newVal)
    {
        executeQuery("UPDATE Categorie SET ? = ? WHERE ? = ?", [$column, $newVal, $column, $oldVal]);
    }

    /**
     * @return mixed
     */
    public function getVeilingId()
    {
        return $this->veilingId;
    }

    /**
     * @param mixed $veilingId
     */
    public function setVeilingId($veilingId)
    {
        $this::update("veilingId", $this->veilingId, $veilingId);
        $this->veilingId = $veilingId;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this::update("email", $this->email, $email);
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getBiedingsTijd()
    {
        return $this->biedingsTijd;
    }

    /**
     * @param mixed $biedingsTijd
     */
    public function setBiedingsTijd($biedingsTijd)
    {
        $this::update("biedingsTijd", $this->biedingsTijd, $biedingsTijd);
        $this->biedingsTijd = $biedingsTijd;
    }

    /**
     * @return mixed
     */
    public function getBiedingsBedrag()
    {
        return $this->biedingsBedrag;
    }

    /**
     * @param mixed $biedingsBedrag
     */
    public function setBiedingsBedrag($biedingsBedrag)
    {
        $this::update("biedingsBedrag", $this->biedingsBedrag, $biedingsBedrag);
        $this->biedingsBedrag = $biedingsBedrag;
    }

}