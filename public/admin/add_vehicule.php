<?php
include_once __DIR__ . '/../../services/GestionVehicule.php';

$gestionVehicule = new GestionVehicule();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $immatriculation = $_POST['immatriculation'];
    $marque = $_POST['marque'];
    $modele = $_POST['modele'];
    $genre = $_POST['genre'];
    $type_carburant = $_POST['type_carburant'];
    $tarif_du_jour = $_POST['tarif_du_jour'];
    $disponibilite = isset($_POST['disponibilite']) ? 1 : 0;
    $categorie = $_POST['categorie'];
    $cout_retard = $_POST['cout_retard'];

    $image = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $uploadDir = __DIR__ . '/../../assets/images/';
        $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
        $uploadFile = $uploadDir . $fileName;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            $image = 'assets/images/' . $fileName;
        }
    }

    $gestionVehicule->insertVehicule($immatriculation, $marque, $modele, $genre, $type_carburant, $tarif_du_jour, $disponibilite, $categorie, $cout_retard, $image);
    header('Location: gestion_vehicules.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Vehicule</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container my-5">
    <h2>Add Vehicule</h2>
    <form action="add_vehicule.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="immatriculation" class="form-label">Immatriculation</label>
            <input type="text" class="form-control" id="immatriculation" name="immatriculation" required>
        </div>
        <div class="mb-3">
            <label for="marque" class="form-label">Marque</label>
            <input type="text" class="form-control" id="marque" name="marque" required>
        </div>
        <div class="mb-3">
            <label for="modele" class="form-label">Modele</label>
            <input type="text" class="form-control" id="modele" name="modele" required>
        </div>
        <div class="mb-3">
            <label for="genre" class="form-label">Genre</label>
            <input type="text" class="form-control" id="genre" name="genre" required>
        </div>
        <div class="mb-3">
            <label for="type_carburant" class="form-label">Type Carburant</label>
            <input type="text" class="form-control" id="type_carburant" name="type_carburant" required>
        </div>
        <div class="mb-3">
            <label for="tarif_du_jour" class="form-label">Tarif du Jour</label>
            <input type="number" step="0.01" class="form-control" id="tarif_du_jour" name="tarif_du_jour" required>
        </div>
        <div class="mb-3">
            <label for="disponibilite" class="form-label">Disponibilite</label>
            <input type="checkbox" id="disponibilite" name="disponibilite">
        </div>
        <div class="mb-3">
            <label for="categorie" class="form-label">Categorie</label>
            <input type="text" class="form-control" id="categorie" name="categorie" required>
        </div>
        <div class="mb-3">
            <label for="cout_retard" class="form-label">Cout Retard</label>
            <input type="number" step="0.01" class="form-control" id="cout_retard" name="cout_retard" required>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*">
        </div>
        <button type="submit" class="btn btn-primary">Add</button>
        <a href="gestion_vehicules.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>