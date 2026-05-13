<?php
class Admin {
    public $id_admin;
    public $nom;
    public $email;
    public $mot_de_passe;

    


    public function __construct($id_admin, $nom, $email,  $mot_de_passe) {
        $this->id_admin= $id_admin;
        $this->nom = $nom;
        $this->email = $email;
        $this-> mot_de_passe = password_hash($mot_de_passe, PASSWORD_DEFAULT);
    }

    // GETTERS
    public function getid_admin() { return $this->id_admin; }
    public function getNom() { return $this->nom; }
    public function getEmail() { return $this->email; }
    public function getMotDePasse() { return $this->mot_de_passe; }

    // SETTERS
    public function setNom($nom) { $this->nom = $nom; }
    public function setEmail($email) { $this->email = $email; }
    public function setMotDePasse($mot_de_passe) { $this->mot_de_passe = password_hash($mot_de_passe, PASSWORD_DEFAULT); }
}
?>
