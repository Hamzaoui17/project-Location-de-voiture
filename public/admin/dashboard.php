<?php
require_once "..\..\services\GestionAdmin.php";

$admin = new GestionAdmin();

$nbClients = $admin->getallClients();
$nbClients = count($nbClients);
$nbReservations = $admin->getallReservations();
$nbReservations = count($nbReservations);
$nbVehicules = $admin->getallVehicules();
$nbVehicules = count($nbVehicules);
$allcontrats = $admin->getallcontrats();
$nbContrats = count($allcontrats);
?>


<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin</title>
    <style>
        body {
            font-family: Arial;
            background: #f4f4f4;
            padding: 20px;
        }
        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            width: 250px;
            margin: 15px;
            float: left;
            box-shadow: 0 0 10px #ccc;
        }
        .card-link {
  text-decoration: none;
  color: inherit;
  display: block;
}

.card {
  border: 1px solid #ccc;
  padding: 20px;
  cursor: pointer;
}

    </style>
</head>
<body >

<h1>Dashboard Administrateur</h1>
<a href="gestion_clients.php" class="card-link">
<div class="card">
    <h2>Clients</h2>
    <p>Total : <?= $nbClients ?></p>
</div>
</a>
<a href="gestion_reservations.php"class="card-link">
<div href=""class="card">
    <h2>Réservations</h2>
    <p>Total : <?= $nbReservations ?></p>
</div>
</a>
<a href="gestion_vehicules.php"class="card-link">
<div class="card">
    <h2>Véhicules</h2>
    <p>Total : <?= $nbVehicules ?></p>
</div>
</a>
<a href="">
<div class="card"class="card-link">
    <h2>Contrats</h2>
    <p>Total : <?= $nbContrats ?></p>
</div>
</a>
</body>
</html>
