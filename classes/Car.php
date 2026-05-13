<?php

class Vehicule {

    private $id_vehicule;
    private $immatriculation;
    private $marque;
    private $modele;
    private $genre;
    private $type_carburant;
    private $tarif_du_jour;
    private $disponibilite;
    private $categorie;
    private $cout_retard;
    private $image;

    public function __construct(
        $id_vehicule,
        $immatriculation,
        $marque,
        $modele,
        $genre,
        $type_carburant,
        $tarif_du_jour,
        $disponibilite,
        $categorie,
        $cout_retard,
        $image
    ) {
        $this->id_vehicule = $id_vehicule;
        $this->immatriculation = $immatriculation;
        $this->marque = $marque;
        $this->modele = $modele;
        $this->genre = $genre;
        $this->type_carburant = $type_carburant;
        $this->tarif_du_jour = $tarif_du_jour;
        $this->disponibilite = $disponibilite;
        $this->categorie = $categorie;
        $this->cout_retard = $cout_retard;
        $this->image = $image;
    }

    public function getId() { return $this->id_vehicule; }
    public function getImmatriculation() { return $this->immatriculation; }
    public function getMarque() { return $this->marque; }
    public function getModele() { return $this->modele; }
    public function getGenre() { return $this->genre; }
    public function getTypeCarburant() { return $this->type_carburant; }
    public function getTarif() { return $this->tarif_du_jour; }
    public function getDisponibilite() { return $this->disponibilite; }
    public function getCategorie() { return $this->categorie; }
    public function getCoutRetard() { return $this->cout_retard; }
    public function getImage() { return $this->image; }
}


?>

