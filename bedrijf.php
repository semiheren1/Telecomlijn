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

    public function create($snaam, $email, $adres, $postcode, $wachtwoord)
    {
        $query = "INSERT INTO bedrijf (naam, email, adres, postcode, wachtwoord) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Voorbereiden mislukt: (" . $this->conn->errno . ") " . $this->conn->error);
        }

        $hashedPassword = password_hash($wachtwoord, PASSWORD_DEFAULT);

        $stmt->bind_param("ssssss", $snaam, $email, $adres, $postcode, $hashedPassword);

        if ($stmt->execute()) {
            return true;
        } else {
            die("Uitvoeren mislukt: (" . $stmt->errno . ") " . $stmt->error);
        }
    }

    public function validatebedrijf($naam, $wachtwoord)
    {
        $query = "SELECT bedrijfid, wachtwoord FROM bedrijf WHERE naam = ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Voorbereiden mislukt: (" . $this->conn->errno . ") " . $this->conn->error);
        }

        $stmt->bind_param("s", $naam);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($bedrijfid, $hashedPassword);
            $stmt->fetch();

            // Controleer het wachtwoord
            if (password_verify($wachtwoord, $hashedPassword)) {
                return $bedrijfid; // Geldige bedrijf
            }
        }

        return false; // Ongeldige bedrijf
    }

    public function naamInGebruikVoorbedrijf($naam)
    {
        return $this->naamInGebruik($naam, 'bedrijf');
    }

    public function naamInGebruik($naam)
    {
        $query = "SELECT bedrijfid FROM bedrijf WHERE naam = ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Voorbereiden mislukt: (" . $this->conn->errno . ") " . $this->conn->error);
        }

        $stmt->bind_param("s", $naam);
        $stmt->execute();
        $stmt->store_result();

        return ($stmt->num_rows > 0);
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

    public function getRecentekenteken()
    {
        $query = "SELECT kentekenid, naam, kenteken, tijd, datum, bedrijf FROM kenteken ORDER BY datum DESC LIMIT 5";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Voorbereiden mislukt: (" . $this->conn->errno . ") " . $this->conn->error);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $recentekenteken = array();

        while ($row = $result->fetch_assoc()) {
            $recentekenteken[] = $row;
        }

        return $recentekenteken;
    }


    public function getAllekenteken()
    {
        $query = "SELECT kentekenid, naam, kenteken, tijd, datum, bedrijf FROM kenteken";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Voorbereiden mislukt: (" . $this->conn->errno . ") " . $this->conn->error);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $alleKenteken = array();

        while ($row = $result->fetch_assoc()) {
            $allekenteken[] = $row;
        }

        return $allekenteken;
    }
    public function updatebedrijfVoornaam($bedrijfid, $nieuweVoornaam)
    {
        $query = "UPDATE bedrijf SET naam = ? WHERE bedrijfid = ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Voorbereiden mislukt: (" . $this->conn->errno . ") " . $this->conn->error);
        }

        $stmt->bind_param("si", $nieuweVoornaam, $bedrijfid);

        if ($stmt->execute()) {
            return true;
        } else {
            $error = "Uitvoeren mislukt: (" . $stmt->errno . ") " . $stmt->error;
            return $error;
        }
    }
    public function updatebedrijfEmail($bedrijfid, $nieuweEmail)
    {
        $query = "UPDATE bedrijf SET email = ? WHERE bedrijfid = ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Voorbereiden mislukt: (" . $this->conn->errno . ") " . $this->conn->error);
        }

        $stmt->bind_param("si", $nieuweEmail, $bedrijfid);

        if ($stmt->execute()) {
            return true;
        } else {
            $error = "Uitvoeren mislukt: (" . $stmt->errno . ") " . $stmt->error;
            return $error;
        }}}



