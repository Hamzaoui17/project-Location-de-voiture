<?php

class GestionReservation {
    private $mysqli;

    public function __construct($mysqli_conn) {
        $this->mysqli = $mysqli_conn;
    }

    /**
     * Récupère toutes les réservations
     */
    public function getAllReservations() {
    $query = "
        SELECT 
            r.ID_reservation,
            r.date_debut,
            r.date_fin,
            c.email AS contact_email,
            r.ID_vehicule,
            v.marque,
            v.modele,
            v.immatriculation
        FROM reservation r
        JOIN client c ON r.id_client = c.id_client
        JOIN vehicule v ON r.ID_vehicule = v.ID_vehicule
        ORDER BY r.date_debut DESC
    ";

    $result = $this->mysqli->query($query);

    if (!$result) {
        return [];
    }

    $reservations = [];
    while ($row = $result->fetch_assoc()) {
        $reservations[] = $row;
    }
    return $reservations;
}

    /**
     * Rejette et supprime une réservation
     */
    public function rejectReservation($id_reservation) {
        $stmt = $this->mysqli->prepare("DELETE FROM reservation WHERE ID_reservation = ?");
        $stmt->bind_param('i', $id_reservation);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /**
     * Confirme une réservation et marque le véhicule comme indisponible
     */
    public function confirmReservation($id_reservation) {
        $stmt = $this->mysqli->prepare("SELECT ID_vehicule FROM reservation WHERE ID_reservation = ?");
        $stmt->bind_param('i', $id_reservation);
        $stmt->execute();
        $result = $stmt->get_result();
        $reservation = $result->fetch_assoc();
        $stmt->close();

        if (!$reservation) {
            return false;
        }

        $vehicule_id = $reservation['ID_vehicule'];
        $updateStmt = $this->mysqli->prepare("UPDATE vehicule SET disponibilite = 0 WHERE ID_vehicule = ?");
        $updateStmt->bind_param('i', $vehicule_id);
        $updateResult = $updateStmt->execute();
        $updateStmt->close();

        return $updateResult;
    }
}

?>