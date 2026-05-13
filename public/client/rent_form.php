<?php
require_once '../../classes/car.php';
require_once '../../classes/Reservation.php';
require_once '../../config/connection.php';

// Get id from URL (or from POST when returning due to validation error)
$id = $_GET['id'] ?? $_POST['id_vehicule'] ?? null;

if (!$id) {
    die("Aucun véhicule sélectionné.");
}

// Fetch vehicle from DB using mysqli (Connection class)
$connObj = new Connection();
$mysqli = $connObj->getConnection();

$stmt = $mysqli->prepare("SELECT * FROM vehicule WHERE ID_vehicule = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();
$stmt->close();

if (!$data) {
    die("Véhicule introuvable.");
}

$vehicule = new Vehicule(
    $data['ID_vehicule'],
    $data['immatriculation'],
    $data['marque'],
    $data['modele'],
    $data['genre'],
    $data['type_carburant'],
    $data['tarif_du_jour'],
    $data['disponibilite'],
    $data['categorie'],
    $data['cout_retard']
);

$error = '';
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date_debut = $_POST['date_debut'] ?? null;
    $date_fin = $_POST['date_fin'] ?? null;
    $id_vehicule = $_POST['id_vehicule'] ?? null;

    if (!$date_debut || !$date_fin || !$id_vehicule) {
        $error = 'Tous les champs sont requis.';
    } elseif ($date_debut > $date_fin) {
        $error = 'La date de début doit être antérieure ou égale à la date de fin.';
    } else {
        $reservation = new Reservation(null, $date_debut, $date_fin, 'pending', (int)$id_vehicule);
        $saved = $reservation->save($mysqli);
        if ($saved) {
            $success = true;
        } else {
            $error = 'Erreur lors de l\'enregistrement. Réessayez.';
        }
    }
}
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Réserver - <?= htmlspecialchars($vehicule->getMarque() . ' ' . $vehicule->getModele()) ?></title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body class="container">

<h1>Réserver : <?= htmlspecialchars($vehicule->getMarque() . ' ' . $vehicule->getModele()) ?></h1>
<p>Tarif / jour : <?= htmlspecialchars($vehicule->getTarif()) ?> $</p>

<?php if ($error): ?>
    <div style="color:red;"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<?php if ($success): ?>
    <div style="color:green;">Réservation enregistrée avec succès. <a href="car_details.php?id=<?= htmlspecialchars($vehicule->getId()) ?>">Retour</a></div>
<?php else: ?>

<form action="rent_form.php" method="post">
    <input type="hidden" name="id_vehicule" value="<?= htmlspecialchars($vehicule->getId()) ?>">

    <div>
        <label for="date_debut">Date de début</label>
        <input type="date" id="date_debut" name="date_debut" required value="<?= isset($date_debut) ? htmlspecialchars($date_debut) : '' ?>">
    </div>

    <div>
        <label for="date_fin">Date de fin</label>
        <input type="date" id="date_fin" name="date_fin" required value="<?= isset($date_fin) ? htmlspecialchars($date_fin) : '' ?>">
    </div>

    <div>
        <button type="submit">Confirmer la réservation</button>
        <a href="car_details.php?id=<?= htmlspecialchars($vehicule->getId()) ?>">Annuler</a>
    </div>
</form>

<?php endif; ?>

</body>
</html>
