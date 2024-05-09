<?php

require_once 'db.php';

class controleur
{
    private $conn;

    public function __construct()
    {
        $dbConnection = new DBConnection();
        $this->conn = $dbConnection->getConnection();
    }

    public function zoekkentekenOpId($kentekenid)
    {
        $query = "SELECT kentekenid, naam, kenteken, tijd, datum, bedrijf FROM kentekenen WHERE kentekenid = ?";
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

    public function getAllekentekenen()
    {
        $query = "SELECT kentekenid, naam, kenteken, tijd, datum, bedrijf FROM kentekenen";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Voorbereiden mislukt: (" . $this->conn->errno . ") " . $this->conn->error);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $allekentekenen = array();

        while ($row = $result->fetch_assoc()) {
            $allekentekenen[] = $row;
        }

        return $allekentekenen;
    }
    public function createcontroleur( $naam, $kenteken, $tijd, $datum, $bedrijf, $beschrijving ,$longitude, $latitude , $afbeelding)
    {
        $latitude = ($latitude !== null) ? $latitude : 0;
        $longitude = ($longitude !== null) ? $longitude : 0;

        $query = "INSERT INTO kenteken (naam, kenteken, tijd, datum, bedrijf, beschrijving, longitude , latitude , afbeelding) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Voorbereiden mislukt: (" . $this->conn->errno . ") " . $this->conn->error);
        }

        $stmt->bind_param("ssssdds", $naam, $kenteken, $tijd, $datum , $bedrijf , $beschrijving ,$longitude , $latitude, $afbeelding);

        if ($stmt->execute()) {
            $controleurid = $stmt->insert_id;
            return ["controleurid" => $controleurid, "latitude" => $latitude, "longitude" => $longitude];
        } else {
            die("Uitvoeren mislukt: (" . $stmt->errno . ") " . $stmt->error);
        }
    }
}