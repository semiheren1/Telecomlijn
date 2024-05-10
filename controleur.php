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


    public function createControleur($email, $wachtwoord)
    {
        $query = "INSERT INTO controleur (email, wachtwoord) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Voorbereiden mislukt: (" . $this->conn->errno . ") " . $this->conn->error);
        }

        $hashedPassword = password_hash($wachtwoord, PASSWORD_DEFAULT);

        $stmt->bind_param("ss", $email, $hashedPassword);

        if ($stmt->execute()) {
            return true;
        } else {
            die("Uitvoeren mislukt: (" . $stmt->errno . ") " . $stmt->error);
        }
    }

    public function getAlleControleurs()
    {
        $query = "SELECT controleurid, email, wachtwoord  FROM controleur";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Voorbereiden mislukt: (" . $this->conn->errno . ") " . $this->conn->error);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $alleControleurs = array();

        while ($row = $result->fetch_assoc()) {
            $alleControleurs[] = $row;
        }

        return $alleControleurs;
    }

    public function verwijderControleur($controleurid) {
        $query = "DELETE FROM controleur WHERE controleurid = ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            // Fout bij het voorbereiden van de query
            error_log("Voorbereiden mislukt: (" . $this->conn->errno . ") " . $this->conn->error);
            return false;
        }

        $stmt->bind_param("i", $controleurid);

        if (!$stmt->execute()) {
            // Fout bij het uitvoeren van de query
            error_log("Uitvoeren mislukt: (" . $stmt->errno . ") " . $stmt->error);
            return false;
        }

        return true; // Verwijdering succesvol
    }

    public function zoekControleurOpId($controleurid)
    {
        $query = "SELECT controleurid, email FROM controleur WHERE controleurid = ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Voorbereiden mislukt: (" . $this->conn->errno . ") " . $this->conn->error);
        }

        $stmt->bind_param("i", $controleurid); // 'i' staat voor integer
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc(); // Retourneer de gevonden beheerdergegevens
        } else {
            return null; // Geen beheerder gevonden met het opgegeven ID
        }
    }

    public function zoekWachtwoordOpId($controleurid) {
        $query = "SELECT wachtwoord FROM controleur WHERE controleurid = ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Voorbereiden mislukt: (" . $this->conn->errno . ") " . $this->conn->error);
        }

        $stmt->bind_param("i", $controleurid); // 'i' stands for integer
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['wachtwoord']; // Return the hashed password
        } else {
            return null; // No controleur found with the specified ID
        }
    }


    public function updateControleur($controleurid, $email, $wachtwoord) {
        $query = "UPDATE controleur SET email = ?, wachtwoord WHERE controleurid = ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            // Error preparing query
            error_log("Voorbereiden mislukt: (" . $this->conn->errno . ") " . $this->conn->error);
            return false;
        }

        $stmt->bind_param("ssi", $email, $wachtwoord, $controleurid);

        if (!$stmt->execute()) {
            // Error executing query
            error_log("Uitvoeren mislukt: (" . $stmt->errno . ") " . $stmt->error);
            return false;
        }

        return true; // Update successful
    }


}