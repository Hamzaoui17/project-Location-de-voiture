<?php
require_once '../../services/GestionClient.php';
require_once '../../config/connection.php';

$connObj = new Connection();
$mysqli = $connObj->getConnection();
$gestion = new GestionClient($mysqli);

$message = '';
$error = '';
$client = null;

// Vérifier que l'ID du client est fourni
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $error = "ID client invalide.";
} else {
    $id_client = (int)$_GET['id'];
    $client = $gestion->getClientById($id_client);
    
    if (!$client) {
        $error = "Client introuvable.";
    }
}

// Traiter la soumission du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $client) {
    $id_client = (int)$_POST['id_client'];
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telephone = trim($_POST['telephone'] ?? '');
    $adress = trim($_POST['adress'] ?? '');
    $num_permis = trim($_POST['num_permis'] ?? '');
    $cin = trim($_POST['cin'] ?? '');
    
    // Validation basique
    if (empty($nom) || empty($prenom) || empty($email) || empty($telephone) || empty($adress) || empty($num_permis) || empty($cin)) {
        $error = "Tous les champs sont obligatoires.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Email invalide.";
    } else {
        // Mettre à jour le client
        if ($gestion->updateClient($id_client, $nom, $prenom, $email, $telephone, $adress, $num_permis, $cin)) {
            $message = "Client modifié avec succès.";
            $client = $gestion->getClientById($id_client);
        } else {
            $error = "Erreur lors de la modification du client.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Client</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container my-5">

        <h2>Modifier les informations du client</h2>

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

        <?php if ($client): ?>
        <form method="post">
            <input type="hidden" name="id_client" value="<?= htmlspecialchars($client['id_client']) ?>">
            
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="nom">Nom:</label>
                <div class="col-sm-6">
                    <input class="form-control" type="text" id="nom" name="nom" value="<?= htmlspecialchars($client['nom']) ?>" required>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="prenom">Prénom:</label>
                <div class="col-sm-6">
                    <input class="form-control" type="text" id="prenom" name="prenom" value="<?= htmlspecialchars($client['prénom']) ?>" required>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="email">Email:</label>
                <div class="col-sm-6">
                    <input class="form-control" type="email" id="email" name="email" value="<?= htmlspecialchars($client['email']) ?>" required>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="telephone">Téléphone:</label>
                <div class="col-sm-6">
                    <input class="form-control" type="text" id="telephone" name="telephone" value="<?= htmlspecialchars($client['téléphone']) ?>" required>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="adress">Adresse:</label>
                <div class="col-sm-6">
                    <input class="form-control" type="text" id="adress" name="adress" value="<?= htmlspecialchars($client['adress']) ?>" required>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="num_permis">N° Permis:</label>
                <div class="col-sm-6">
                    <input class="form-control" type="text" id="num_permis" name="num_permis" value="<?= htmlspecialchars($client['num_permis']) ?>" required>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="cin">CIN:</label>
                <div class="col-sm-6">
                    <input class="form-control" type="text" id="cin" name="cin" value="<?= htmlspecialchars($client['CIN']) ?>" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="offset-sm-2 col-sm-3 d-grid">
                    <button name="submit" type="submit" class="btn btn-primary">Modifier</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-secondary" href="gestion_clients.php">Annuler</a>
                </div>
            </div>
        </form>
        <?php endif; ?>

    </div>

</body>
</html>