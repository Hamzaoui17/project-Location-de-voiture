<?php
session_start();

require_once '../../classes/car.php';
require_once '../../classes/Reservation.php';
require_once '../../classes/Client.php';
require_once '../../config/connection.php';

$method = $_SERVER['REQUEST_METHOD'];

// Vérifier les paramètres GET ou POST
if ((isset($_GET['id_vehicule']) && isset($_GET['date_debut']) && isset($_GET['date_fin'])) ||
    ($method === 'POST' && isset($_POST['id_vehicule']) && isset($_POST['date_debut']) && isset($_POST['date_fin']))) {

    $id_vehicule = (int)($_GET['id_vehicule'] ?? $_POST['id_vehicule']);
    $date_debut = $_GET['date_debut'] ?? $_POST['date_debut'];
    $date_fin = $_GET['date_fin'] ?? $_POST['date_fin'];
    $contact_email = $_GET['contact_email'] ?? $_POST['contact_email'] ?? '';

} else {
    die('Données manquantes.');
}

// Connexion PDO
$pdo = new PDO("mysql:host=localhost;dbname=location;charset=utf8", "root", "");

// 1️⃣ Récupérer le véhicule
$stmt = $pdo->prepare("SELECT * FROM vehicule WHERE ID_vehicule = ?");
$stmt->execute([$id_vehicule]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$data) die('Véhicule introuvable.');

// Créer l’objet Vehicule
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
    $data['cout_retard'],
    $data['image']
);

// 2️⃣ Récupérer le client (par email si fourni)
if (!$contact_email) {
    die('Email du client manquant.');
}

$stmt = $pdo->prepare("SELECT * FROM client WHERE email = ?");
$stmt->execute([$contact_email]);
$dat = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$dat) die('Client introuvable.');

// Créer l’objet Client
$client = new Client(
    $dat['id_client'],    // id_client
    $dat['num_permis'],   // num_permis
    $dat['CIN'],          // CIN
    $dat['nom'],          // nom
    $dat['prénom'],       // prenom
    $dat['adress'],       // adress
    $dat['téléphone'],    // telephone
    $dat['email'],        // email
    $dat['Pass']          // pass
);

// 3️⃣ Créer la réservation
$reservation = new Reservation(
    null,                   // id auto-incrément
    $date_debut,
    $date_fin,
    $vehicule->getId(),
    $client->getId(),
    $contact_email
);

$days = $reservation->getDays();
$total = $reservation->computeTotal($vehicule->getTarif());

$error = '';
$success = false;

// 4️⃣ Confirmer la réservation
if ($method === 'POST' && isset($_POST['action']) && $_POST['action'] === 'confirm') {
    $connObj = new Connection();
    $mysqli = $connObj->getConnection();

    $saved = $reservation->save($mysqli);
    if ($saved) {
        $success = true;
    } else {
        $error = 'Erreur lors de la confirmation : ' . htmlspecialchars($mysqli->error);
    }
}
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Fiche de réservation</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <style>
        body{background:#ffffff;color:#222;font-family:Arial,Helvetica,sans-serif}
        .card{max-width:640px;margin:30px auto;padding:20px;border:1px solid #e9e9e9;border-radius:8px;background:#ffffff}
        .card h3{margin-top:0}
        .actions{display:flex;gap:12px;margin-top:16px}
        .btn{padding:10px 14px;background:#ff8c00;color:#0b0b0b;border-radius:4px;text-decoration:none;border:0;cursor:pointer}
        .btn.cancel{background:#3a3a3a;color:#fff}
        p{margin:6px 0}
    </style>
</head>
<body>
<div class="card">
    <h3>Fiche de réservation</h3>
    <p><strong>Véhicule :</strong> <?= htmlspecialchars($vehicule->getMarque() . ' ' . $vehicule->getModele()) ?></p>
    <p><strong>Date de début :</strong> <?= htmlspecialchars($date_debut) ?></p>
    <p><strong>Date de fin :</strong> <?= htmlspecialchars($date_fin) ?></p>
    <p><strong>Nombre de jours :</strong> <?= $days ?></p>
    <p><strong>Tarif journalier :</strong> <?= htmlspecialchars($vehicule->getTarif()) ?> $</p>
    <p><strong>Montant total :</strong> <?= number_format($total, 2) ?> $</p>
    <?php if ($contact_email): ?><p><strong>Email de contact :</strong> <?= htmlspecialchars($contact_email) ?></p><?php endif; ?>

    <?php if ($error): ?><div style="color:red"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <?php if ($success): ?><div style="color:green">Réservation confirmée. <a href="car_details.php?id=<?= htmlspecialchars($vehicule->getId()) ?>">Retour</a></div><?php endif; ?>

    <?php if (!$success): ?>
    <form method="post">
        <input type="hidden" name="id_vehicule" value="<?= htmlspecialchars($vehicule->getId()) ?>">
        <input type="hidden" name="date_debut" value="<?= htmlspecialchars($date_debut) ?>">
        <input type="hidden" name="date_fin" value="<?= htmlspecialchars($date_fin) ?>">
        <input type="hidden" name="contact_email" value="<?= htmlspecialchars($contact_email) ?>">
        <div class="actions">
            <button type="submit" name="action" value="confirm" class="btn" style="background:#0066cc;color:#fff;">Confirmer</button>
            <a href="car_details.php?id=<?= htmlspecialchars($vehicule->getId()) ?>" class="btn cancel">Annuler</a>
        </div>
    </form>
    <?php endif; ?>
</div>
</body>
</html>
