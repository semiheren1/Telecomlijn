<?php

require_once 'db.php';

class Kenteken
{
    private $conn;

    public function __construct()
    {
        $dbConnection = new DBConnection();
        $this->conn = $dbConnection->getConnection();
    }

    public function createKenteken($naam, $kenteken, $tijd, $datum, $bedrijf )
    {


        $query = "INSERT INTO kenteken (naam, kenteken, tijd, datum, bedrijf) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Voorbereiden mislukt: (" . $this->conn->errno . ") " . $this->conn->error);
        }

        $stmt->bind_param("sssss", $naam, $kenteken, $tijd, $datum, $bedrijf);

        if ($stmt->execute()) {
            $kentekenid = $stmt->insert_id;
            return ["kentekenid" => $kentekenid];
        } else {
            die("Uitvoeren mislukt: (" . $stmt->errno . ") " . $stmt->error);
        }
    }

    public function verwijderOudeKentekens()
    {
        $vervaltermijn = strtotime("-14 days");
        $vervaltermijnDatum = date("Y-m-d", $vervaltermijn);

        $query = "DELETE FROM kenteken WHERE datum < ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Voorbereiden mislukt: (" . $this->conn->errno . ") " . $this->conn->error);
        }

        $stmt->bind_param("s", $vervaltermijnDatum);

        if ($stmt->execute()) {
            // Verwijderen van oude Kenteken succesvol
        } else {
            die("Uitvoeren mislukt: (" . $stmt->errno . ") " . $stmt->error);
        }
    }
    public function deleteKenteken($kentekenid)
    {
        $query = "DELETE FROM kenteken WHERE kentkenid = ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Voorbereiden mislukt: (" . $this->conn->errno . ") " . $this->conn->error);
        }

        $stmt->bind_param("i", $kentekenid);

        if ($stmt->execute()) {
            // Kenteken succesvol verwijderd
        } else {
            die("Uitvoeren mislukt: (" . $stmt->errno . ") " . $stmt->error);
        }
    }
}
?>
