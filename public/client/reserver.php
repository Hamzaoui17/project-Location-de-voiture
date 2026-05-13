<?php
require_once '../../classes/car.php';

// Simple styled form to choose reservation dates

$id = $_GET['id'] ?? $_POST['id_vehicule'] ?? null;
if (!$id) {
    die('Véhicule non sélectionné.');
}

$pdo = new PDO("mysql:host=localhost;dbname=location;charset=utf8", "root", "");
$stmt = $pdo->prepare("SELECT * FROM vehicule WHERE ID_vehicule = ?");
$stmt->execute([$id]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$data) die('Véhicule introuvable.');

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

 $error = '';
 $date_debut = $_POST['date_debut'] ?? '';
 $date_fin = $_POST['date_fin'] ?? '';
 $contact_email = $_POST['contact_email'] ?? '';

 if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date_debut = $_POST['date_debut'] ?? null;
    $date_fin = $_POST['date_fin'] ?? null;
    $contact_email = trim($_POST['contact_email'] ?? '');

    if (!$date_debut || !$date_fin || !$contact_email) {
        $error = 'Tous les champs sont requis.';
    } elseif (!filter_var($contact_email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Adresse e-mail invalide.';
    } elseif ($date_debut > $date_fin) {
        $error = 'Erreur : la date de début ne peut pas être supérieure à la date de fin.';
    } else {
        // Rediriger vers la fiche de réservation en transmettant l'email
        $params = http_build_query([
            'id_vehicule' => $vehicule->getId(),
            'date_debut' => $date_debut,
            'date_fin' => $date_fin,
            'contact_email' => $contact_email,
        ]);
        header('Location: reservation_summary.php?' . $params);
        exit;
    }
 }
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Réserver - <?= htmlspecialchars($vehicule->getMarque() . ' ' . $vehicule->getModele()) ?></title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <style>
           body{background:#ffffff;color:#222;font-family:Arial,Helvetica,sans-serif}
           .box{max-width:520px;margin:40px auto;padding:20px;border:1px solid #e9e9e9;border-radius:8px;background:#ffffff}
           .box h2{margin-top:0}
           .row{display:flex;gap:12px}
           .row .col{flex:1}
           label{display:block;margin-bottom:6px;color:#333}
           .form-control{width:100%;padding:8px;border:1px solid #dcdcdc;border-radius:4px;background:#fff;color:#222}
           .btn{display:inline-block;padding:10px 16px;background:#007bff;color:#fff;border-radius:4px;text-decoration:none;border:none;cursor:pointer}
           .btn.secondary{background:#6c757d;color:#fff}
           .notice{padding:10px;background:#fff;border:1px solid #f0f0f0;color:#333;border-radius:4px;margin-bottom:16px}
    </style>
</head>
<body>
    <div class="box">
        <h2>Réserver : <?= htmlspecialchars($vehicule->getMarque() . ' ' . $vehicule->getModele()) ?></h2>
        <p>Tarif journalier : <strong><?= htmlspecialchars($vehicule->getTarif()) ?> $</strong></p>

        <?php if ($error): ?>
            <div style="color:red; padding:10px; background:#ffe6e6; border-radius:4px; margin-bottom:16px;">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form action="reserver.php" method="post">
            <input type="hidden" name="id_vehicule" value="<?= htmlspecialchars($vehicule->getId()) ?>">
            <div style="margin-top:12px">
                <label for="contact_email">Email de contact</label>
                <input type="email" id="contact_email" name="contact_email" required class="form-control" value="<?= htmlspecialchars($contact_email) ?>">
            </div>
            <div class="row">
                <div class="col">
                    <label for="date_debut">Date de début</label>
                    <input type="date" id="date_debut" name="date_debut" required class="form-control" value="<?= htmlspecialchars($date_debut) ?>">
                </div>
                <div class="col">
                    <label for="date_fin">Date de fin</label>
                    <input type="date" id="date_fin" name="date_fin" required class="form-control" value="<?= htmlspecialchars($date_fin) ?>">
                </div>
            </div>
            <div style="margin-top:16px">
                <button type="submit" class="btn">Voir la fiche de réservation</button>
                <a href="car_details.php?id=<?= htmlspecialchars($vehicule->getId()) ?>" class="btn secondary">Annuler</a>
            </div>
        </form>
    </div>
</body>
</html>
