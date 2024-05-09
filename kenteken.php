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

    public function zoekKentekenOpId($kentekenid)
    {
        $query = "SELECT kentekenid, naam, kenteken, tijd, datum, bedrijf FROM kenteken WHERE kentekenid = ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Voorbereiden mislukt: (" . $this->conn->errno . ") " . $this->conn->error);
        }

        $stmt->bind_param("i", $kentekenid); // 'i' staat voor integer
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc(); // Retourneer de gevonden kenteken
        } else {
            return null; // Geen kenteken gevonden met het opgegeven ID
        }
    }

    public function updateKenteken($kentekenid, $naam, $kenteken, $tijd, $datum, $bedrijf) {
        $query = "UPDATE kenteken SET naam = ?, kenteken = ?, tijd = ?, datum = ?, bedrijf = ? WHERE kentekenid = ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            // Error preparing query
            error_log("Voorbereiden mislukt: (" . $this->conn->errno . ") " . $this->conn->error);
            return false;
        }

        // Bind parameters to the prepared statement
        $stmt->bind_param("sssssi", $naam, $kenteken, $tijd, $datum, $bedrijf, $kentekenid);

        if (!$stmt->execute()) {
            // Error executing query
            error_log("Uitvoeren mislukt: (" . $stmt->errno . ") " . $stmt->error);
            return false;
        }

        return true; // Update successful
    }


    public function verwijderKenteken($kentekenid) {
        $query = "DELETE FROM kenteken WHERE kentekenid = ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            // Fout bij het voorbereiden van de query
            error_log("Voorbereiden mislukt: (" . $this->conn->errno . ") " . $this->conn->error);
            return false;
        }

        $stmt->bind_param("i", $kentekenid);

        if (!$stmt->execute()) {
            // Fout bij het uitvoeren van de query
            error_log("Uitvoeren mislukt: (" . $stmt->errno . ") " . $stmt->error);
            return false;
        }

        return true; // Verwijdering succesvol
    }

    public function getRecenteKentekens()
    {
        $query = "SELECT kentekenid, naam, kenteken, tijd, datum, bedrijf  FROM kenteken ORDER BY datum DESC LIMIT 5";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Voorbereiden mislukt: (" . $this->conn->errno . ") " . $this->conn->error);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $recenteKentekens = array();

        while ($row = $result->fetch_assoc()) {
            $recenteKentekens[] = $row;
        }

        return $recenteKentekens;
    }


}
?>
