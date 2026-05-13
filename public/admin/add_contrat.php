<?php
include_once __DIR__ . '/../../services/GestionContrat.php';

 $gestionContrat = new GestionContrat();
 $error = '';
 $success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $ID_reservation = $_POST['ID_reservation'];
        $date_debut = $_POST['date_debut'];
        $date_fin = $_POST['date_fin'];
        $prix_total = $_POST['prix_total'];
        $etat_paiement = $_POST['etat_paiement'];
        
        $gestionContrat->insertContrat($ID_reservation, $date_debut, $date_fin, $prix_total, $etat_paiement);
        $success = "Contrat ajouté avec succès!";
        // Redirect after a short delay
        header("refresh:2;url=gestion_contrats.php");
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

// Get all reservations for the dropdown
try {
    $reservations = $gestionContrat->getAllReservations();
} catch (Exception $e) {
    $error = $e->getMessage();
    $reservations = [];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Contrat</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container my-5">
    <h2>Ajouter un Nouveau Contrat</h2>
    
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <?php if (!empty($success)): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>
    
    <?php if (empty($reservations)): ?>
        <div class="alert alert-warning">
            Aucune réservation n'a été trouvée. Vous devez d'abord créer une réservation avant de pouvoir créer un contrat.
            <a href="add_reservation.php" class="btn btn-primary btn-sm ms-2">Créer une réservation</a>
        </div>
    <?php else: ?>
        <form action="add_contrat.php" method="post">
            <div class="mb-3">
                <label for="ID_reservation" class="form-label">ID Réservation</label>
                <select class="form-control" id="ID_reservation" name="ID_reservation" required>
                    <option value="">Sélectionner une réservation</option>
                    <?php foreach ($reservations as $reservation): ?>
                        <option value="<?php echo $reservation; ?>"><?php echo $reservation; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="date_debut" class="form-label">Date de Début</label>
                <input type="date" class="form-control" id="date_debut" name="date_debut" required>
            </div>
            <div class="mb-3">
                <label for="date_fin" class="form-label">Date de Fin</label>
                <input type="date" class="form-control" id="date_fin" name="date_fin">
            </div>
            <div class="mb-3">
                <label for="prix_total" class="form-label">Prix Total</label>
                <input type="number" step="0.01" class="form-control" id="prix_total" name="prix_total" required>
            </div>
            <div class="mb-3">
                <label for="etat_paiement" class="form-label">État de Paiement</label>
                <select class="form-control" id="etat_paiement" name="etat_paiement" required>
                    <option value="Payé">Payé</option>
                    <option value="Non Payé">Non Payé</option>
                    <option value="Partiel">Partiel</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Ajouter le Contrat</button>
            <a href="gestion_contrats.php" class="btn btn-secondary">Annuler</a>
        </form>
    <?php endif; ?>
</div>
</body>
</html>