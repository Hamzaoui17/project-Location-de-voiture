<?php

class GestionClient {
    private $mysqli;

    public function __construct($mysqli_conn) {
        $this->mysqli = $mysqli_conn;
    }

    /**
     * Récupère tous les clients
     */
    public function getAllClients() {
        $query = "SELECT id_client, num_permis, CIN, nom, `prénom`, adress, `téléphone`, email FROM client ORDER BY id_client DESC";
        $result = $this->mysqli->query($query);
        if (!$result) {
            return [];
        }
        $clients = [];
        while ($row = $result->fetch_assoc()) {
            $clients[] = $row;
        }
        return $clients;
    }

    /**
     * Supprime un client
      */
    // public function deleteClient($id_client) {
    //     $stmt = $this->mysqli->prepare("DELETE FROM client WHERE id_client = ?");
    //     if (!$stmt) return false;
    //     $stmt->bind_param('i', $id_client);
    //     $result = $stmt->execute();
    //     $stmt->close();
    //     return $result;
    // }public function deleteClient($id_client)
public function deleteClient($id_client) {
    // 1️⃣ Supprimer les contrats liés aux réservations du client
    $sql = "
        DELETE FROM contrat
        WHERE ID_reservation IN (
            SELECT ID_reservation FROM reservation WHERE id_client = ?
        )
    ";
    $stmt = $this->mysqli->prepare($sql);
    $stmt->bind_param("i", $id_client);
    $stmt->execute();

    // 2️⃣ Supprimer les réservations du client
    $stmt = $this->mysqli->prepare("DELETE FROM reservation WHERE id_client = ?");
    $stmt->bind_param("i", $id_client);
    $stmt->execute();

    // 3️⃣ Supprimer le client
    $stmt = $this->mysqli->prepare("DELETE FROM client WHERE id_client = ?");
    $stmt->bind_param("i", $id_client);
    $result=$stmt->execute();
    return $result;
}



public function getClientById($id)
{
    $sql = "SELECT * FROM client WHERE id_client = ?";
    $stmt = $this->mysqli->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

public function updateClient(
    $id_client,
    $nom,
    $prenom,
    $email,
    $telephone,
    $adress,
    $num_permis,
    $cin
) {
    $sql = "UPDATE client SET
                nom = ?,
                `prénom` = ?,
                email = ?,
                `téléphone` = ?,
                adress = ?,
                num_permis = ?,
                CIN = ?
            WHERE id_client = ?";

    $stmt = $this->mysqli->prepare($sql);
    if (!$stmt) {
        return false;
    }

    $stmt->bind_param(
        "sssssssi",
        $nom,
        $prenom,
        $email,
        $telephone,
        $adress,
        $num_permis,
        $cin,
        $id_client
    );

    $result = $stmt->execute();
    $stmt->close();

    return $result;
}

}

?>
