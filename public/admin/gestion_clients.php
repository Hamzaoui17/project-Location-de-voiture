<?php
require_once '../../services/GestionClient.php';
require_once '../../config/connection.php';

$connObj = new Connection();
$mysqli = $connObj->getConnection();
$gestion = new GestionClient($mysqli);

$message = '';
$error = '';

// Traiter les actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && isset($_POST['id_client'])) {
        $id_client = (int)$_POST['id_client'];
        if ($_POST['action'] === 'delete') {
            if ($gestion->deleteClient($id_client)) {
                $message = 'Client supprimé.';
            } else {
                $error = 'Erreur lors de la suppression du client.';
            }
        }
    }
}

// Récupérer tous les clients
$clients = $gestion->getAllClients();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Clients</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container my-5">
    <h2>List CLIENTS from database</h2>
    <a href="../client/sign up.php" class="btn btn-primary btn-sm float-end">Sign Up</a>

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
            <th>Nom</th>
            <th>Prénom</th>
            <th>Email</th>
            <th>telephone</th>
            <th>num_permis</th> 
            <th>CIN</th>
            <th>adress</th>
                

            <th>Action</th>
        </tr>
        </thead>
        <tbody>

        <?php if (!empty($clients)): ?>
            <?php foreach ($clients as $c): ?>
            <tr>
                <td><?= htmlspecialchars($c['id_client']) ?></td>
                <td><?= htmlspecialchars($c['nom']) ?></td>
                <td><?= htmlspecialchars($c['prénom']) ?></td>
                <td><?= htmlspecialchars($c['email']) ?></td>
                <td><?= htmlspecialchars($c['téléphone']) ?></td>
                <td><?= htmlspecialchars($c['num_permis']) ?></td>
                <td><?= htmlspecialchars($c['CIN']) ?></td>
                <td><?= htmlspecialchars($c['adress']) ?></td>
                <td>
                    <a href="editClient.php?id=<?= htmlspecialchars($c['id_client']) ?>" class="btn btn-success btn-sm">Edit</a>
                    <form action="gestion_clients.php" method="POST" style="display:inline; margin-left:6px;">
                        <input type="hidden" name="id_client" value="<?= htmlspecialchars($c['id_client']) ?>">
                        <button type="submit" name="action" value="delete" class='btn btn-danger btn-sm' onclick="return confirm('Êtes-vous sûr de supprimer ce client ?');">Supprimer</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="8" class="text-center">Aucun client trouvé.</td>
            </tr>
        <?php endif; ?>

        </tbody>
        
    </table>
   
    </div>
</body>
</html>

