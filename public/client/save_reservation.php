<?php
// Simple handler to save a reservation
// Expects POST: id_vehicule, date_debut, date_fin

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: listing.php');
    exit;
}

$id_vehicule = $_POST['id_vehicule'] ?? null;
$date_debut = $_POST['date_debut'] ?? null;
$date_fin = $_POST['date_fin'] ?? null;

if (!$id_vehicule || !$date_debut || !$date_fin) {
    die('Missing required fields.');
}

// Basic validation: date_debut <= date_fin
if ($date_debut > $date_fin) {
    die('La date de début doit être antérieure ou égale à la date de fin.');
}

try {
    $pdo = new PDO("mysql:host=localhost;dbname=location;charset=utf8", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $statut = 'pending';

    $stmt = $pdo->prepare("INSERT INTO reservation (date_debut, date_fin, statut, ID_vehicule) VALUES (?, ?, ?, ?)");
    $stmt->execute([$date_debut, $date_fin, $statut, $id_vehicule]);

    // Redirect back to details with success flag
    header('Location: car_details.php?id=' . urlencode($id_vehicule) . '&reserved=1');
    exit;
} catch (PDOException $e) {
    die('Database error: ' . $e->getMessage());
}

?>