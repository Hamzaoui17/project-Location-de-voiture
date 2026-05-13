<?php
include_once __DIR__ . '/../../services/GestionVehicule.php';

$gestionVehicule = new GestionVehicule();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $immatriculation = $_POST['immatriculation'];
    $marque = $_POST['marque'];
    $modele = $_POST['modele'];
    $genre = $_POST['genre'];
    $type_carburant = $_POST['type_carburant'];
    $tarif_du_jour = $_POST['tarif_du_jour'];
    $disponibilite = isset($_POST['disponibilite']) ? 1 : 0;
    $categorie = $_POST['categorie'];
    $cout_retard = $_POST['cout_retard'];

    $image = $_POST['current_image'];
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $uploadDir = __DIR__ . '/../../assets/images/';
        $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
        $uploadFile = $uploadDir . $fileName;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            $image = 'assets/images/' . $fileName;
        }
    }

    $gestionVehicule->updateVehicule($id, $immatriculation, $marque, $modele, $genre, $type_carburant, $tarif_du_jour, $disponibilite, $categorie, $cout_retard, $image);
    header('Location: gestion_vehicules.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $vehicule = $gestionVehicule->getVehiculeById($id);
    if (!$vehicule) {
        echo "Vehicule not found.";
        exit();
    }
} else {
    echo "No vehicule ID provided.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Vehicule</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container my-5">
    <h2>Edit Vehicule</h2>
    <form action="edit_vehicule.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $vehicule->getId(); ?>">
        <input type="hidden" name="current_image" value="<?php echo $vehicule->getImage(); ?>">
        <div class="mb-3">
            <label for="immatriculation" class="form-label">Immatriculation</label>
            <input type="text" class="form-control" id="immatriculation" name="immatriculation" value="<?php echo $vehicule->getImmatriculation(); ?>" required>
        </div>
        <div class="mb-3">
            <label for="marque" class="form-label">Marque</label>
            <input type="text" class="form-control" id="marque" name="marque" value="<?php echo $vehicule->getMarque(); ?>" required>
        </div>
        <div class="mb-3">
            <label for="modele" class="form-label">Modele</label>
            <input type="text" class="form-control" id="modele" name="modele" value="<?php echo $vehicule->getModele(); ?>" required>
        </div>
        <div class="mb-3">
            <label for="genre" class="form-label">Genre</label>
            <input type="text" class="form-control" id="genre" name="genre" value="<?php echo $vehicule->getGenre(); ?>" required>
        </div>
        <div class="mb-3">
            <label for="type_carburant" class="form-label">Type Carburant</label>
            <input type="text" class="form-control" id="type_carburant" name="type_carburant" value="<?php echo $vehicule->getTypeCarburant(); ?>" required>
        </div>
        <div class="mb-3">
            <label for="tarif_du_jour" class="form-label">Tarif du Jour</label>
            <input type="number" step="0.01" class="form-control" id="tarif_du_jour" name="tarif_du_jour" value="<?php echo $vehicule->getTarif(); ?>" required>
        </div>
        <div class="mb-3">
            <label for="disponibilite" class="form-label">Disponibilite</label>
            <input type="checkbox" id="disponibilite" name="disponibilite" <?php echo $vehicule->getDisponibilite() ? 'checked' : ''; ?>>
        </div>
        <div class="mb-3">
            <label for="categorie" class="form-label">Categorie</label>
            <input type="text" class="form-control" id="categorie" name="categorie" value="<?php echo $vehicule->getCategorie(); ?>" required>
        </div>
        <div class="mb-3">
            <label for="cout_retard" class="form-label">Cout Retard</label>
            <input type="number" step="0.01" class="form-control" id="cout_retard" name="cout_retard" value="<?php echo $vehicule->getCoutRetard(); ?>" required>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*">
            <?php if ($vehicule->getImage()): ?>
                <img src="<?php echo $vehicule->getImage(); ?>" width="100" alt="Current Image">
            <?php endif; ?>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="gestion_vehicules.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>