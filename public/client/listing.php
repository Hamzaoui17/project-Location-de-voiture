<?php
// Connexion à la base SQL
$pdo = new PDO("mysql:host=localhost;dbname=location;charset=utf8", "root", "");

// Récupérer tous les véhicules disponibles
$query = $pdo->query("SELECT * FROM vehicule WHERE disponibilite = 1");
$vehicules = $query->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="en">
<head>
    <title>RoCARS — listing</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="fonts/icomoon/style.css">
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
<div class="site-wrap" id="home-section">
<header class="site-navbar site-navbar-target" role="banner">

        <div class="container">
          <div class="row align-items-center position-relative">

            <div class="col-3">
              <div class="site-logo">
                <a href="index.html"><strong>RoCARS</strong></a>
              </div>
            </div>

            <div class="col-9  text-right">
              
              <span class="d-inline-block d-lg-none"><a href="#" class=" site-menu-toggle js-menu-toggle py-5 "><span class="icon-menu h3 text-black"></span></a></span>

              <nav class="site-navigation text-right ml-auto d-none d-lg-block" role="navigation">
                <ul class="site-menu main-menu js-clone-nav ml-auto ">
                  <li><a href="index.php" class="nav-link">Home</a></li>
                  <li><a href="listing.php" class="nav-link">Listing</a></li>
                  
                  <li class="active"><a href="contact.php" class="nav-link">Contact</a></li>
                                     <li><a href="login.php" class="nav-link">log in</a></li>

                </ul>
              </nav>
            </div>

            
          </div>
        </div>

      </header>
    <!-- Hero / Header -->
    <div class="hero inner-page" style="background-image: url('../../assets/images/carrrrr.png');">
        <div class="container">
            <div class="row align-items-end ">
                <div class="col-lg-5">
                    <div class="intro">
                        <h1><strong>Listings</strong></h1>
                        <div class="custom-breadcrumbs"><a href="index.php">Home</a> <span class="mx-2">/</span> <strong>Listings</strong></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Vehicles List -->
    <div class="site-section bg-light">
        <div class="row">
            <?php foreach ($vehicules as $v): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="listing d-block align-items-stretch">
                        <div class="listing-img h-100 mr-4">
                            <img src="<?= $v['image'] ?>" alt="<?= htmlspecialchars($v['marque'] . ' ' . $v['modele']) ?>" class="img-fluid">
                        </div>
                        <div class="listing-contents h-100">
                            <h3><?= htmlspecialchars($v['marque'] . ' ' . $v['modele']) ?></h3>

                            <div class="rent-price">
                                <strong>$<?= number_format($v['tarif_du_jour'], 2) ?></strong><span class="mx-1">/</span>day
                            </div>

                            <div class="d-block d-md-flex mb-3 border-bottom pb-3">
                                <div class="listing-feature pr-4">
                                    <span class="caption">Genre:</span>
                                    <span class="number"><?= htmlspecialchars($v['genre']) ?></span>
                                </div>
                                <div class="listing-feature pr-4">
                                    <span class="caption">Carburant:</span>
                                    <span class="number"><?= htmlspecialchars($v['type_carburant']) ?></span>
                                </div>
                                <div class="listing-feature pr-4">
                                    <span class="caption">Catégorie:</span>
                                    <span class="number"><?= htmlspecialchars($v['categorie']) ?></span>
                                </div>
                            </div>

                            <div>
                                
                                <a href="car_details.php?id=<?= $v['ID_vehicule'] ?>" class="btn btn-primary btn-sm">Rent Now</a>


                            </div>

                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</div>
</body>
</html>
