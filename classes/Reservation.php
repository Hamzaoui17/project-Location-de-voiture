<?php

class Reservation {

    private $id_reservation;
    private $date_debut;
    private $date_fin;
    private $contact_email;
    private $id_vehicule;
    private $id_client;

    public function __construct(
        $id_reservation,
        $date_debut,
        $date_fin,
        $id_vehicule,
        $contact_email = null,
        $id_client
    ) {
        $this->id_reservation = $id_reservation;
        $this->date_debut = $date_debut;
        $this->date_fin = $date_fin;
        $this->id_vehicule = $id_vehicule;
        $this->contact_email = $contact_email;
        $this->id_client = $id_client;
    }

    public function save($mysqli_conn) {
        if (!$mysqli_conn) {
            return false;
        }

        $query = "INSERT INTO reservation (date_debut, date_fin, ID_vehicule, id_client,contact_email) VALUES (?, ?, ?, ?, ?)";
        $stmt = $mysqli_conn->prepare($query);
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param('ssiis', $this->date_debut, $this->date_fin, $this->id_vehicule, $this->contact_email, $this->id_client);
        $result = $stmt->execute();
        if ($result) {
            $this->id_reservation = $mysqli_conn->insert_id;
        }
        $stmt->close();
        return $result;
    }

    // Retourne le nombre de jours de la réservation (inclusif)
    public function getDays() {
        try {
            $start = new DateTime($this->date_debut);
            $end = new DateTime($this->date_fin);
            $diff = $start->diff($end);
            $days = $diff->days + 1; // inclusif : même jour = 1
            return ($days > 0) ? $days : 1;
        } catch (Exception $e) {
            return 1;
        }
    }

    // Calcule le montant total selon un tarif journalier
    public function computeTotal($tarif_par_jour) {
        $days = $this->getDays();
        return $days * $tarif_par_jour;
    }

    // GETTERS pour accéder aux valeurs
    public function getId() { return $this->id_reservation; }
    public function getDateDebut() { return $this->date_debut; }
    public function getDateFin() { return $this->date_fin; }
    public function getIdVehicule() { return $this->id_vehicule; }
    public function getContactEmail() { return $this->contact_email; }
    public function getIdClient() { return $this->id_client; }

    // SETTERS pour modifier les valeurs
    public function setDateDebut($date_debut) { $this->date_debut = $date_debut; }
    public function setDateFin($date_fin) { $this->date_fin = $date_fin; }
    public function setIdVehicule($id_vehicule) { $this->id_vehicule = $id_vehicule; }
    public function setContactEmail($email) { $this->contact_email = $email; }
}

?>
