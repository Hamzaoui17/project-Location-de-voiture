<?php
include_once __DIR__ . '/../../services/GestionContrat.php';

 $gestionContrat = new GestionContrat();

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $gestionContrat->deleteContrat($id);
    header('Location: gestion_contrats.php');
    exit();
}

 $contrats = $gestionContrat->getAllContrats();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Contrats</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container my-5">
    <h2>Liste des Contrats</h2>
    <a class="btn btn-primary" href="add_contrat.php" role="button">Ajouter un Contrat</a>
    <br>
    <br>
    <table class="table">
        <thead>
            <tr>
                <th>Numéro de Contrat</th>
                <th>ID Réservation</th>
                <th>Date de Début</th>
                <th>Date de Fin</th>
                <th>Prix Total</th>
                <th>État de Paiement</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contrats as $contrat): ?>
                <tr>
                    <td><?php echo $contrat->getNumContrat(); ?></td>
                    <td><?php echo $contrat->getIdReservation(); ?></td>
                    <td><?php echo $contrat->getDateDebut(); ?></td>
                    <td><?php echo $contrat->getDateFin(); ?></td>
                    <td><?php echo $contrat->getPrixTotal(); ?></td>
                    <td><?php echo $contrat->getEtatPaiement(); ?></td>
                    <td>
                        <a class='btn btn-success btn-sm' href="edit_contrat.php?id=<?php echo $contrat->getNumContrat(); ?>">Modifier</a>
                        <a class='btn btn-danger btn-sm' href="gestion_contrats.php?delete=<?php echo $contrat->getNumContrat(); ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce contrat?')">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>