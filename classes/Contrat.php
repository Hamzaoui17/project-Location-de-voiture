<?php
class Contrat {
    private $Num_contrat;
    private $ID_reservation;
    private $date_debut;
    private $date_fin;
    private $prix_total;
    private $etat_paiement;

    public function __construct($Num_contrat, $ID_reservation, $date_debut, $date_fin, $prix_total, $etat_paiement) {
        $this->Num_contrat = $Num_contrat;
        $this->ID_reservation = $ID_reservation;
        $this->date_debut = $date_debut;
        $this->date_fin = $date_fin;
        $this->prix_total = $prix_total;
        $this->etat_paiement = $etat_paiement;
    }

    // Getters
    public function getNumContrat() {
        return $this->Num_contrat;
    }

    public function getIdReservation() {
        return $this->ID_reservation;
    }

    public function getDateDebut() {
        return $this->date_debut;
    }

    public function getDateFin() {
        return $this->date_fin;
    }

    public function getPrixTotal() {
        return $this->prix_total;
    }

    public function getEtatPaiement() {
        return $this->etat_paiement;
    }

    // Setters
    public function setNumContrat($Num_contrat) {
        $this->Num_contrat = $Num_contrat;
    }

    public function setIdReservation($ID_reservation) {
        $this->ID_reservation = $ID_reservation;
    }

    public function setDateDebut($date_debut) {
        $this->date_debut = $date_debut;
    }

    public function setDateFin($date_fin) {
        $this->date_fin = $date_fin;
    }

    public function setPrixTotal($prix_total) {
        $this->prix_total = $prix_total;
    }

    public function setEtatPaiement($etat_paiement) {
        $this->etat_paiement = $etat_paiement;
    }
}
?>