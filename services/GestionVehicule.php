<?php
include_once __DIR__ . '/../config/connection.php';
include_once __DIR__ . '/../classes/Car.php';

class GestionVehicule {
    private $connection;

    public function __construct() {
        $this->connection = new Connection();
        $this->connection = $this->connection->getConnection();
    }

    public function getAllVehicules() {
        $sql = "SELECT * FROM vehicule";
        $result = mysqli_query($this->connection, $sql);
        $vehicules = [];
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $vehicule = new Vehicule(
                    $row['ID_vehicule'],
                    $row['immatriculation'],
                    $row['marque'],
                    $row['modele'],
                    $row['genre'],
                    $row['type_carburant'],
                    $row['tarif_du_jour'],
                    $row['disponibilite'],
                    $row['categorie'],
                    $row['cout_retard'],
                    $row['image']
                );
                $vehicules[] = $vehicule;
            }
        }
        return $vehicules;
    }

    public function deleteVehicule($id) {
        $sql = "DELETE FROM vehicule WHERE ID_vehicule = ?";
        $stmt = mysqli_prepare($this->connection, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    public function getVehiculeById($id) {
        $sql = "SELECT * FROM vehicule WHERE ID_vehicule = ?";
        $stmt = mysqli_prepare($this->connection, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($result)) {
            $vehicule = new Vehicule(
                $row['ID_vehicule'],
                $row['immatriculation'],
                $row['marque'],
                $row['modele'],
                $row['genre'],
                $row['type_carburant'],
                $row['tarif_du_jour'],
                $row['disponibilite'],
                $row['categorie'],
                $row['cout_retard'],
                $row['image']
            );
            mysqli_stmt_close($stmt);
            return $vehicule;
        }
        mysqli_stmt_close($stmt);
        return null;
    }

    public function updateVehicule($id, $immatriculation, $marque, $modele, $genre, $type_carburant, $tarif_du_jour, $disponibilite, $categorie, $cout_retard, $image) {
        $sql = "UPDATE vehicule SET immatriculation = ?, marque = ?, modele = ?, genre = ?, type_carburant = ?, tarif_du_jour = ?, disponibilite = ?, categorie = ?, cout_retard = ?, image = ? WHERE ID_vehicule = ?";
        $stmt = mysqli_prepare($this->connection, $sql);
        mysqli_stmt_bind_param($stmt, 'sssssdssssd', $immatriculation, $marque, $modele, $genre, $type_carburant, $tarif_du_jour, $disponibilite, $categorie, $cout_retard, $image, $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    public function insertVehicule($immatriculation, $marque, $modele, $genre, $type_carburant, $tarif_du_jour, $disponibilite, $categorie, $cout_retard, $image) {
        $sql = "INSERT INTO vehicule (immatriculation, marque, modele, genre, type_carburant, tarif_du_jour, disponibilite, categorie, cout_retard, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($this->connection, $sql);
        mysqli_stmt_bind_param($stmt, 'sssssdssss', $immatriculation, $marque, $modele, $genre, $type_carburant, $tarif_du_jour, $disponibilite, $categorie, $cout_retard, $image);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}
?>