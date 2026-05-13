<?php
require_once "../../config/connection.php";

class GestionAdmin {

    private $conn;
    public static $errorMsg = "";
    public static $successMsg = "";

    public function __construct() {
        $connection = new Connection();
        $this->conn = $connection->getConnection();
    }
    

    /* ======================= */
    /* ===== DASHBOARD ======= */
    /* ======================= */

    public function getallClients() {
        $sql = "SELECT * FROM client";
        $result = mysqli_query($this->conn, $sql);

        $clients = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $clients[] = $row;
        }
        return $clients;
    }

    public function getallReservations() {
        $sql = "SELECT *  FROM reservation";
        $result = mysqli_query($this->conn, $sql);
        $reservations = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $reservations[] = $row;
        }
        return $reservations;
    }

    public function getallVehicules() {
        $sql = "SELECT *  FROM vehicule";
        $result = mysqli_query($this->conn, $sql);
        $vehicules = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $vehicules[] = $row;
        }
        return $vehicules;}

   public function getallcontrats() {
        $sql = "SELECT * FROM contrat";
        $result = mysqli_query($this->conn, $sql);
        $contracts = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $contracts[] = $row;
    }
        return $contracts;
    }




/* ================= CLIENT ================= */

public function addClient($npermis,$cin,$nom,$prenom,$adress,$telephone, $email, $password) {
    $sql = "INSERT INTO client (num_permis,CIN,nom,prénom,adress,téléphone, email, Pass)
            VALUES ('$npermis','$cin','$nom','$prenom','$adress','$telephone', '$email',' $password')";
    return mysqli_query($this->conn, $sql);
}
public function supprimerClient($id) {
        $stmt = mysqli_prepare($this->conn, "DELETE FROM client WHERE id_client = ?");
        if (!$stmt) return false;
    mysqli_stmt_bind_param($stmt, "i", $id);
        $res = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $res;
}


    // Admin management
    public function supprimerAdmin($id) {
        $stmt = mysqli_prepare($this->conn, "DELETE FROM admin WHERE id_admin = ?");
        if (!$stmt) return false;
    mysqli_stmt_bind_param($stmt, "i", $id);
        $res = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $res;
}

   


}
?>
