<<?php
require_once '../../services/GestionReservation.php';
require_once '../../config/connection.php';

$connObj = new Connection();
$mysqli = $connObj->getConnection();
$gestion = new GestionReservation($mysqli);

$message = '';
$error = '';

// Traiter les actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && isset($_POST['id_reservation'])) {
        $id_reservation = (int)$_POST['id_reservation'];
        
        if ($_POST['action'] === 'reject') {
            if ($gestion->rejectReservation($id_reservation)) {
                $message = 'Réservation rejetée et supprimée.';
            } else {
                $error = 'Erreur lors du rejet de la réservation.';
            }
        } elseif ($_POST['action'] === 'confirm') {
            if ($gestion->confirmReservation($id_reservation)) {
                $message = 'Réservation confirmée. Véhicule marqué indisponible.';
            } else {
                $error = 'Erreur lors de la confirmation.';
            }
        }
    }
}

// Récupérer toutes les réservations
$reservations = $gestion->getAllReservations();
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
    <h2>List RESERVATION from database</h2>

    <?php if ($message): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($message) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    
    <?php if ($error): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($error) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <br>
    <br>
    <table class="table">
       <thead>
        <tr>
            <th>ID</th>
            <th>Véhicule</th>
            <th>Immatriculation</th>
            <th>Date Début</th>
            <th>date fin</th>
            <th>contact</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>

        <?php if (!empty($reservations)): ?>
            <?php foreach ($reservations as $res): ?>
            <tr>
                <td><?= htmlspecialchars($res['ID_reservation']) ?></td>
                <td><?= htmlspecialchars($res['marque'] . ' ' . $res['modele']) ?></td>
                <td><?= htmlspecialchars($res['immatriculation']) ?></td>
                <td><?= htmlspecialchars($res['date_debut']) ?></td>
                <td><?= htmlspecialchars($res['date_fin']) ?></td>
                <td><?= htmlspecialchars($res['contact_email']) ?></td>
                <td>
                    <form action="gestion_reservations.php" method="POST" style="display:inline;">
                        <input type="hidden" name="id_reservation" value="<?= htmlspecialchars($res['ID_reservation']) ?>">
                        <button type="submit" name="action" value="confirm" class='btn btn-success btn-sm'>confirmer</button>
                    </form>
                    <form action="gestion_reservations.php" method="POST" style="display:inline;">
                        <input type="hidden" name="id_reservation" value="<?= htmlspecialchars($res['ID_reservation']) ?>">
                        <button type="submit" name="action" value="reject" class='btn btn-danger btn-sm' onclick="return confirm('Êtes-vous sûr ?');">rejete</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7" class="text-center">Aucune réservation trouvée.</td>
            </tr>
        <?php endif; ?>

        </tbody>
        
    </table>
   
    </div>
</body>
</html>