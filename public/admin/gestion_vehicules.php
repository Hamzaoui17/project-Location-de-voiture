<?php
include_once __DIR__ . '/../../services/GestionVehicule.php';

$gestionVehicule = new GestionVehicule();

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $gestionVehicule->deleteVehicule($id);
    header('Location: gestion_vehicules.php');
    exit();
}

$vehicules = $gestionVehicule->getAllVehicules();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container my-5">
    <h2>List of VEHICULES</h2>
    <a class="btn btn-primary" href="add_vehicule.php" role="button">ADD VEHICULES</a>
    <br>
    <br>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Immatriculation</th>
                <th>Marque</th>
                <th>Modele</th>
                <th>Tarif du jour</th>
                <th>Disponibilite</th>
                <th>Cout de retard</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($vehicules as $vehicule): ?>
                <tr>
                    <td><?php echo $vehicule->getId(); ?></td>
                    <td><?php echo $vehicule->getImmatriculation(); ?></td>
                    <td><?php echo $vehicule->getMarque(); ?></td>
                    <td><?php echo $vehicule->getModele(); ?></td>
                    <td><?php echo $vehicule->getTarif(); ?></td>
                    <td><?php echo $vehicule->getDisponibilite() ? 'Oui' : 'Non'; ?></td>
                    <td><?php echo $vehicule->getCoutRetard(); ?></td>
                    <td><?php if ($vehicule->getImage()): ?><img src="<?php echo $vehicule->getImage(); ?>" width="50"><?php endif; ?></td>
                    <td>
                        <a class='btn btn-success btn-sm' href="edit_vehicule.php?id=<?php echo $vehicule->getId(); ?>">Edit</a>
                        <a class='btn btn-danger btn-sm' href="gestion_vehicules.php?delete=<?php echo $vehicule->getId(); ?>" onclick="return confirm('Are you sure you want to delete this vehicule?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
