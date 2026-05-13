<?php
require_once '../../classes/car.php';

// Connect to DB
$pdo = new PDO("mysql:host=localhost;dbname=location;charset=utf8", "root", "");

// Get id from URL
$id = $_GET['id'] ?? null;

if (!$id) {
    die("No vehicle selected.");
}

// Fetch vehicle from DB
$stmt = $pdo->prepare("SELECT * FROM vehicule WHERE ID_vehicule = ?");
$stmt->execute([$id]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$data) {
    die("Vehicle not found.");
}

// Create Vehicule object
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
?>
<!doctype html>
<html lang="en">
<head>
    <title>Vehicle Details</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../../assets/css/car_details.css">
</head>
<body class="container ">

<h1><?= $vehicule->getMarque() . " " . $vehicule->getModele() ?></h1>

<img src="<?= $data['image'] ?>" class="img" style="max-width:400px;">

<ul class="list-grp">
    <li class="list"><strong>Immatriculation:</strong> <?= $vehicule->getImmatriculation() ?></li>
    <li class="list"><strong>Genre:</strong> <?= $vehicule->getGenre() ?></li>
    <li class="list"><strong>Carburant:</strong> <?= $vehicule->getTypeCarburant() ?></li>
    <li class="list"><strong>Tarif / jour:</strong> <?= $vehicule->getTarif() ?> $</li>
    <li class="list"><strong>Categorie:</strong> <?= $vehicule->getCategorie() ?></li>
    <li class="list"><strong>Cout retard:</strong> <?= $vehicule->getCoutRetard() ?> $</li>
</ul>

<a href="reserver.php?id=<?= $vehicule->getId() ?>" class="btn ">
    Proceed to Rent
</a>

</body>
</html>
