<?php
include_once __DIR__ . '/../config/connection.php';
include_once __DIR__ . '/../classes/Contrat.php';

class GestionContrat {
    private $connection;

    public function __construct() {
        $conn = new Connection();
        $this->connection = $conn->getConnection();
        
        if (!$this->connection) {
            throw new Exception("Database connection failed");
        }
    }

    // Check if a reservation exists
    public function reservationExists($ID_reservation) {
        $sql = "SELECT ID_reservation FROM reservation WHERE ID_reservation = ?";
        $stmt = mysqli_prepare($this->connection, $sql);
        
        if (!$stmt) {
            throw new Exception("Prepare failed: " . mysqli_error($this->connection));
        }
        
        mysqli_stmt_bind_param($stmt, 'i', $ID_reservation);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        
        $exists = mysqli_stmt_num_rows($stmt) > 0;
        mysqli_stmt_close($stmt);
        
        return $exists;
    }

    // Get all reservations for dropdown
    public function getAllReservations() {
        $sql = "SELECT ID_reservation FROM reservation";
        $result = mysqli_query($this->connection, $sql);
        $reservations = [];

        if (!$result) {
            throw new Exception("Query failed: " . mysqli_error($this->connection));
        }

        while ($row = mysqli_fetch_assoc($result)) {
            $reservations[] = $row['ID_reservation'];
        }
        
        mysqli_free_result($result);
        return $reservations;
    }

    // Récupérer tous les contrats
    public function getAllContrats() {
        $sql = "SELECT * FROM contrat";
        $result = mysqli_query($this->connection, $sql);
        $contrats = [];

        if (!$result) {
            throw new Exception("Query failed: " . mysqli_error($this->connection));
        }

        while ($row = mysqli_fetch_assoc($result)) {
            $contrat = new Contrat(
                $row['Num_contrat'],
                $row['ID_reservation'],
                $row['date_debut'],
                $row['date_fin'],
                $row['prix_total'],
                $row['etat_paiement']
            );
            $contrats[] = $contrat;
        }
        
        mysqli_free_result($result);
        return $contrats;
    }

    // Récupérer un contrat par ID
    public function getContratById($num_contrat) {
        $sql = "SELECT * FROM contrat WHERE Num_contrat = ?";
        $stmt = mysqli_prepare($this->connection, $sql);
        
        if (!$stmt) {
            throw new Exception("Prepare failed: " . mysqli_error($this->connection));
        }
        
        mysqli_stmt_bind_param($stmt, 'i', $num_contrat);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            $contrat = new Contrat(
                $row['Num_contrat'],
                $row['ID_reservation'],
                $row['date_debut'],
                $row['date_fin'],
                $row['prix_total'],
                $row['etat_paiement']
            );
            mysqli_stmt_close($stmt);
            return $contrat;
        }
        
        mysqli_stmt_close($stmt);
        return null;
    }

    // Insérer un contrat
    public function insertContrat($ID_reservation, $date_debut, $date_fin, $prix_total, $etat_paiement) {
        // Check if the reservation exists
        if (!$this->reservationExists($ID_reservation)) {
            throw new Exception("Reservation with ID $ID_reservation does not exist");
        }
        
        $sql = "INSERT INTO contrat (ID_reservation, date_debut, date_fin, prix_total, etat_paiement)
                VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($this->connection, $sql);
        
        if (!$stmt) {
            throw new Exception("Prepare failed: " . mysqli_error($this->connection));
        }
        
        mysqli_stmt_bind_param($stmt, 'issds', $ID_reservation, $date_debut, $date_fin, $prix_total, $etat_paiement);
        $result = mysqli_stmt_execute($stmt);
        
        if (!$result) {
            mysqli_stmt_close($stmt);
            throw new Exception("Execute failed: " . mysqli_stmt_error($stmt));
        }
        
        $insertId = mysqli_insert_id($this->connection);
        mysqli_stmt_close($stmt);
        return $insertId;
    }

    // Modifier un contrat
    public function updateContrat($num_contrat, $ID_reservation, $date_debut, $date_fin, $prix_total, $etat_paiement) {
        // Check if the reservation exists
        if (!$this->reservationExists($ID_reservation)) {
            throw new Exception("Reservation with ID $ID_reservation does not exist");
        }
        
        $sql = "UPDATE contrat 
                SET ID_reservation = ?, date_debut = ?, date_fin = ?, prix_total = ?, etat_paiement = ?
                WHERE Num_contrat = ?";
        $stmt = mysqli_prepare($this->connection, $sql);
        
        if (!$stmt) {
            throw new Exception("Prepare failed: " . mysqli_error($this->connection));
        }
        
        mysqli_stmt_bind_param($stmt, 'issdsi', $ID_reservation, $date_debut, $date_fin, $prix_total, $etat_paiement, $num_contrat);
        $result = mysqli_stmt_execute($stmt);
        
        if (!$result) {
            mysqli_stmt_close($stmt);
            throw new Exception("Execute failed: " . mysqli_stmt_error($stmt));
        }
        
        $affectedRows = mysqli_stmt_affected_rows($stmt);
        mysqli_stmt_close($stmt);
        return $affectedRows > 0;
    }

    // Supprimer un contrat
    public function deleteContrat($num_contrat) {
        $sql = "DELETE FROM contrat WHERE Num_contrat = ?";
        $stmt = mysqli_prepare($this->connection, $sql);
        
        if (!$stmt) {
            throw new Exception("Prepare failed: " . mysqli_error($this->connection));
        }
        
        mysqli_stmt_bind_param($stmt, 'i', $num_contrat);
        $result = mysqli_stmt_execute($stmt);
        
        if (!$result) {
            mysqli_stmt_close($stmt);
            throw new Exception("Execute failed: " . mysqli_stmt_error($stmt));
        }
        
        $affectedRows = mysqli_stmt_affected_rows($stmt);
        mysqli_stmt_close($stmt);
        return $affectedRows > 0;
    }
}
?>