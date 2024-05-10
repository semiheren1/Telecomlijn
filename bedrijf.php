<?php
require_once 'db.php';

class bedrijf
{
    private $conn;

    public function __construct()
    {
        $dbConnection = new DBConnection();
        $this->conn = $dbConnection->getConnection();
    }


     public function createBedrijf($naam, $email, $adres, $postcode, $wachtwoord)
    {
        $query = "INSERT INTO bedrijf (naam, email, adres, postcode, wachtwoord) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Voorbereiden mislukt: (" . $this->conn->errno . ") " . $this->conn->error);
        }

        $hashedPassword = password_hash($wachtwoord, PASSWORD_DEFAULT);

        $stmt->bind_param("sssss", $naam, $email, $adres, $postcode, $hashedPassword);

        if ($stmt->execute()) {
            return true;
        } else {
            die("Uitvoeren mislukt: (" . $stmt->errno . ") " . $stmt->error);
        }
    }

     public function getAlleBedrijven()
     {
         $query = "SELECT bedrijfid, naam, email, adres, postcode, wachtwoord  FROM bedrijf";
         $stmt = $this->conn->prepare($query);

         if (!$stmt) {
             die("Voorbereiden mislukt: (" . $this->conn->errno . ") " . $this->conn->error);
         }

         $stmt->execute();
         $result = $stmt->get_result();

         $alleBedrijven = array();

         while ($row = $result->fetch_assoc()) {
             $alleBedrijven[] = $row;
         }

         return $alleBedrijven;
     }

    public function verwijderBedrijf($bedrijfid) {
        $query = "DELETE FROM bedrijf WHERE bedrijfid = ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            // Fout bij het voorbereiden van de query
            error_log("Voorbereiden mislukt: (" . $this->conn->errno . ") " . $this->conn->error);
            return false;
        }

        $stmt->bind_param("i", $bedrijfid);

        if (!$stmt->execute()) {
            // Fout bij het uitvoeren van de query
            error_log("Uitvoeren mislukt: (" . $stmt->errno . ") " . $stmt->error);
            return false;
        }

        return true; // Verwijdering succesvol
    }

    public function zoekBedrijfOpId($bedrijfid)
    {
        $query = "SELECT bedrijfid, naam, email, adres, postcode FROM bedrijf WHERE bedrijfid = ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Voorbereiden mislukt: (" . $this->conn->errno . ") " . $this->conn->error);
        }

        $stmt->bind_param("i", $bedrijfid); // 'i' staat voor integer
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc(); // Retourneer de gevonden beheerdergegevens
        } else {
            return null; // Geen beheerder gevonden met het opgegeven ID
        }
    }

    public function updateBedrijf($bedrijfid, $naam, $email, $adres, $postcode) {
        $query = "UPDATE bedrijf SET naam = ?, email = ?, adres = ?, postcode = ? WHERE bedrijfid = ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            // Error preparing query
            error_log("Voorbereiden mislukt: (" . $this->conn->errno . ") " . $this->conn->error);
            return false;
        }

        $stmt->bind_param("ssssi", $naam, $email, $adres, $postcode, $bedrijfid);

        if (!$stmt->execute()) {
            // Error executing query
            error_log("Uitvoeren mislukt: (" . $stmt->errno . ") " . $stmt->error);
            return false;
        }

        return true; // Update successful
    }



}


