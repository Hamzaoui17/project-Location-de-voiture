<?php

class Client {
    private $id_client;
    private $num_permis;
    private $CIN;
    private $nom;
    private $prenom;
    private $adress;
    private $telephone;
    private $email;
    private $pass; // hashed

    public function __construct($id_client, $num_permis, $CIN, $nom, $prenom, $adress, $telephone, $email, $pass) {
        $this->id_client = $id_client;
        $this->num_permis = $num_permis;
        $this->CIN = $CIN;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->adress = $adress;
        $this->telephone = $telephone;
        $this->email = $email;
        $this->pass = $pass;
    }

    // getters
    public function getId() { return $this->id_client; }
    public function getNumPermis() { return $this->num_permis; }
    public function getCIN() { return $this->CIN; }
    public function getNom() { return $this->nom; }
    public function getPrenom() { return $this->prenom; }
    public function getAdress() { return $this->adress; }
    public function getTelephone() { return $this->telephone; }
    public function getEmail() { return $this->email; }

    // setters
    public function setNumPermis($v) { $this->num_permis = $v; }
    public function setCIN($v) { $this->CIN = $v; }
    public function setNom($v) { $this->nom = $v; }
    public function setPrenom($v) { $this->prenom = $v; }
    public function setAdress($v) { $this->adress = $v; }
    public function setTelephone($v) { $this->telephone = $v; }
    public function setEmail($v) { $this->email = $v; }
    public function setPass($v) { $this->pass = $v; }

    // Vérifie si un email existe déjà (mysqli connection)
    public static function existsByEmail($mysqli_conn, $email) {
        $stmt = $mysqli_conn->prepare("SELECT 1 FROM client WHERE email = ? LIMIT 1");
        if (!$stmt) return false;
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $res = $stmt->get_result();
        $exists = ($res && $res->num_rows > 0);
        $stmt->close();
        return $exists;
    }

    // Sauvegarde le client en base (mysqli connection expects Connection->conn)
    public function save($mysqli_conn) {
        $sql = "INSERT INTO client (num_permis, CIN, nom, prénom, adress, téléphone, email, Pass) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $mysqli_conn->prepare($sql);
        if (!$stmt) {
            return ['success' => false, 'error' => $mysqli_conn->error];
        }
        $stmt->bind_param('ssssssss', $this->num_permis, $this->CIN, $this->nom, $this->prenom, $this->adress, $this->telephone, $this->email, $this->pass);
        $ok = $stmt->execute();
        if ($ok) {
            $this->id_client = $mysqli_conn->insert_id;
            $stmt->close();
            return ['success' => true, 'id' => $this->id_client];
        } else {
            $err = $stmt->error;
            $stmt->close();
            return ['success' => false, 'error' => $err];
        }
    }
}

?>
