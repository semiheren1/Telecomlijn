<?php
require_once 'db.php';

class Beheerders
{
    private $conn;

    public function __construct()
    {
        $dbConnection = new DBConnection();
        $this->conn = $dbConnection->getConnection();
    }

    public function create($gebruikersnaam, $wachtwoord, $voornaam, $achternaam, $email)
    {
        $query = "INSERT INTO beheerders (gebruikersnaam, wachtwoord, voornaam, achternaam, email) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Voorbereiden mislukt: (" . $this->conn->errno . ") " . $this->conn->error);
        }

        $hashedPassword = password_hash($wachtwoord, PASSWORD_DEFAULT);

        $stmt->bind_param("sssss", $gebruikersnaam, $hashedPassword, $voornaam, $achternaam, $email);

        if ($stmt->execute()) {
            return true;
        } else {
            die("Uitvoeren mislukt: (" . $stmt->errno . ") " . $stmt->error);
        }
    }

    public function validatebeheerder($gebruikersnaam, $wachtwoord)
    {
        $query = "SELECT beheerderid, wachtwoord FROM beheerders WHERE gebruikersnaam = ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Voorbereiden mislukt: (" . $this->conn->errno . ") " . $this->conn->error);
        }

        $stmt->bind_param("s", $gebruikersnaam);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($beheerderid, $hashedPassword);
            $stmt->fetch();

            // Controleer het wachtwoord
            if (password_verify($wachtwoord, $hashedPassword)) {
                return $beheerderid; // Geldige beheerder
            }
        }

        return false; // Ongeldige beheerder
    }


    public function gebruikersnaamInGebruikVoorBeheerders($gebruikersnaam)
    {
        return $this->gebruikersnaamInGebruik($gebruikersnaam, 'beheerders');
    }

    public function gebruikersnaamInGebruik($gebruikersnaam)
    {
        $query = "SELECT beheerderid FROM beheerders WHERE gebruikersnaam = ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Voorbereiden mislukt: (" . $this->conn->errno . ") " . $this->conn->error);
        }

        $stmt->bind_param("s", $gebruikersnaam);
        $stmt->execute();
        $stmt->store_result();

        return ($stmt->num_rows > 0);
    }


    public function zoekKentekenOpId($kentekenid)
    {
        $query = "SELECT kentekenid, naam, kenteken, tijd, datum, bedrijf FROM kentekens WHERE kentekenid = ?";
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


    public function getAlleKentekens()
    {
        $query = "SELECT kentekenid, naam, kenteken, tijd, datum, bedrijf  FROM kenteken";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Voorbereiden mislukt: (" . $this->conn->errno . ") " . $this->conn->error);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $alleKenteken = array();

        while ($row = $result->fetch_assoc()) {
            $alleKentekens[] = $row;
        }

        return $alleKentekens;
    }

    public function getAlleBeheerders()
    {
        $query = "SELECT beheerderid, gebruikersnaam, wachtwoord, voornaam, achternaam, email  FROM beheerders";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Voorbereiden mislukt: (" . $this->conn->errno . ") " . $this->conn->error);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $alleBeheerders = array();

        while ($row = $result->fetch_assoc()) {
            $alleBeheerders[] = $row;
        }

        return $alleBeheerders;
    }

    public function updateBeheerder($beheerderid, $gebruikersnaam, $wachtwoord, $voornaam, $achternaam, $email) {
        $query = "UPDATE beheerders SET gebruikersnaam = ?, wachtwoord = ?, voornaam = ?, achternaam = ?, email = ? WHERE beheerderid = ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            // Error preparing query
            error_log("Voorbereiden mislukt: (" . $this->conn->errno . ") " . $this->conn->error);
            return false;
        }

        $stmt->bind_param("sssssi", $gebruikersnaam, $wachtwoord, $voornaam, $achternaam, $email, $beheerderid);

        if (!$stmt->execute()) {
            // Error executing query
            error_log("Uitvoeren mislukt: (" . $stmt->errno . ") " . $stmt->error);
            return false;
        }

        return true; // Update successful
    }

    public function verwijderBeheerder($beheerderid) {
        $query = "DELETE FROM beheerders WHERE beheerderid = ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            // Fout bij het voorbereiden van de query
            error_log("Voorbereiden mislukt: (" . $this->conn->errno . ") " . $this->conn->error);
            return false;
        }

        $stmt->bind_param("i", $beheerderid);

        if (!$stmt->execute()) {
            // Fout bij het uitvoeren van de query
            error_log("Uitvoeren mislukt: (" . $stmt->errno . ") " . $stmt->error);
            return false;
        }

        return true; // Verwijdering succesvol
    }


    public function updateKenteken($kentekenid, $naam, $kenteken, $tijd, $datum, $bedrijf) {
        $query = "UPDATE kenteken SET naam = ?, kenteken = ?, tijd = ?, datum = ?, bedrijf = ? WHERE kentekenid = ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            // Error preparing query
            error_log("Voorbereiden mislukt: (" . $this->conn->errno . ") " . $this->conn->error);
            return false;
        }

        $stmt->bind_param("sass", $naam, $kenteken, $tijd, $datum, $bedrijf, $kentekenid);

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

        $stmt->bind_param("i", $beheerderid);

        if (!$stmt->execute()) {
            // Fout bij het uitvoeren van de query
            error_log("Uitvoeren mislukt: (" . $stmt->errno . ") " . $stmt->error);
            return false;
        }

        return true; // Verwijdering succesvol
    }


    public function updateBeheerderVoornaam($beheerderid, $nieuweVoornaam)
    {
        $query = "UPDATE beheerders SET voornaam = ? WHERE beheerderid = ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Voorbereiden mislukt: (" . $this->conn->errno . ") " . $this->conn->error);
        }

        $stmt->bind_param("si", $nieuweVoornaam, $beheerderid);

        if ($stmt->execute()) {
            return true;
        } else {
            $error = "Uitvoeren mislukt: (" . $stmt->errno . ") " . $stmt->error;
            return $error;
        }
    }
    public function updateBeheerderAchternaam($beheerderid, $nieuweAchternaam)
    {
        $query = "UPDATE beheerders SET achternaam = ? WHERE beheerderid = ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Voorbereiden mislukt: (" . $this->conn->errno . ") " . $this->conn->error);
        }

        $stmt->bind_param("si", $nieuweAchternaam, $beheerderid);

        if ($stmt->execute()) {
            return true;
        } else {
            $error = "Uitvoeren mislukt: (" . $stmt->errno . ") " . $stmt->error;
            return $error;
        }
    }
    public function updateBeheerderEmail($beheerderid, $nieuweEmail)
    {
        $query = "UPDATE beheerders SET email = ? WHERE beheerderid = ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Voorbereiden mislukt: (" . $this->conn->errno . ") " . $this->conn->error);
        }

        $stmt->bind_param("si", $nieuweEmail, $beheerderid);

        if ($stmt->execute()) {
            return true;
        } else {
            $error = "Uitvoeren mislukt: (" . $stmt->errno . ") " . $stmt->error;
            return $error;
        }
    }
    public function zoekBeheerderOpId($beheerderid)
    {
        $query = "SELECT beheerderid, gebruikersnaam, voornaam, achternaam, email FROM beheerders WHERE beheerderid = ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Voorbereiden mislukt: (" . $this->conn->errno . ") " . $this->conn->error);
        }

        $stmt->bind_param("i", $beheerderid); // 'i' staat voor integer
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc(); // Retourneer de gevonden beheerdergegevens
        } else {
            return null; // Geen beheerder gevonden met het opgegeven ID
        }
    }

    public function zoekWachtwoordOpId($beheerderid) {
        $query = "SELECT wachtwoord FROM beheerders WHERE beheerderid = ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Voorbereiden mislukt: (" . $this->conn->errno . ") " . $this->conn->error);
        }

        $stmt->bind_param("i", $beheerderid); // 'i' stands for integer
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['wachtwoord']; // Return the hashed password
        } else {
            return null; // No beheerder found with the specified ID
        }
    }

    public function updateBeheerderGegevens($beheerderid, $nieuweVoornaam, $nieuweAchternaam, $nieuweEmail)
    {
        // ... (bestaande update code blijft ongewijzigd)
    }

    // ...

    public function updateBeheerderGebruikersnaam($beheerderid, $nieuweGebruikersnaam)
    {
        $query = "UPDATE beheerders SET gebruikersnaam = ? WHERE beheerderid = ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Voorbereiden mislukt: (" . $this->conn->errno . ") " . $this->conn->error);
        }

        $stmt->bind_param("si", $nieuweGebruikersnaam, $beheerderid);

        if ($stmt->execute()) {
            return true;
        } else {
            $error = "Uitvoeren mislukt: (" . $stmt->errno . ") " . $stmt->error;
            return $error;
        }
    }

    public function updateBeheerderWachtwoord($beheerderid, $nieuwWachtwoord)
    {
        $hashedPassword = password_hash($nieuwWachtwoord, PASSWORD_DEFAULT);

        $query = "UPDATE beheerders SET wachtwoord = ? WHERE beheerderid = ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Voorbereiden mislukt: (" . $this->conn->errno . ") " . $this->conn->error);
        }

        $stmt->bind_param("si", $hashedPassword, $beheerderid);

        if ($stmt->execute()) {
            return true;
        } else {
            $error = "Uitvoeren mislukt: (" . $stmt->errno . ") " . $stmt->error;
            return $error;
        }
    }
}
?>
