<?php
 
  $emailValue = "";
  $lnameValue = "";
  $fnameValue = "";
  $passwordValue = "";
  $numPermisValue = "";
  $cinValue = "";
  $adressValue = "";
  $telephoneValue = "";
  $errorMessage = "";
  $successMessage = "";

  if (isset($_POST['submit'])) {
  
    $emailValue = trim($_POST['email'] ?? '');
    $lnameValue = trim($_POST['lastName'] ?? '');
    $fnameValue = trim($_POST['firstName'] ?? '');
    $passwordValue = $_POST['password'] ?? '';
    $numPermisValue = trim($_POST['num_permis'] ?? '');
    $cinValue = trim($_POST['cin'] ?? '');
    $adressValue = trim($_POST['adress'] ?? '');
    $telephoneValue = trim($_POST['telephone'] ?? '');


    if (empty($emailValue) || empty($fnameValue) || empty($lnameValue) || empty($passwordValue)) {
      $errorMessage = "Tous les champs obligatoires doivent être remplis.";
    } else if (strlen($passwordValue) < 8) {
      $errorMessage = "Le mot de passe doit contenir au moins 8 caractères.";
    } else if (preg_match('/[A-Z]+/', $passwordValue) == 0) {
      $errorMessage = "Le mot de passe doit contenir au moins une lettre majuscule.";
    } else if (!filter_var($emailValue, FILTER_VALIDATE_EMAIL)) {
      $errorMessage = "Adresse email invalide.";
    } else {
      
      require_once('../../config/connection.php');
      require_once('../../classes/Client.php');
      $connObj = new Connection();
      $conn = $connObj->conn; 

      // select database (connection.php does not select a DB)
      if (!mysqli_select_db($conn, 'location')) {
        $errorMessage = 'Erreur base de données non sélectionnée : ' . mysqli_error($conn);
      } else {

        $hash = password_hash($passwordValue, PASSWORD_DEFAULT);

        // check existing email
        if (Client::existsByEmail($conn, $emailValue)) {
          $errorMessage = 'Un compte avec cet email existe déjà.';
        } else {
          $client = new Client(null, $numPermisValue, $cinValue, $lnameValue, $fnameValue, $adressValue, $telephoneValue, $emailValue, $hash);
          $res = $client->save($conn);
          if (!empty($res['success'])) {
            $successMessage = 'Inscription réussie. Vous pouvez maintenant vous connecter.';
            $passwordValue = '';
          } else {
            $errorMessage = 'Erreur lors de l\'inscription : ' . ($res['error'] ?? 'Erreur inconnue');
          }
        }
      }
    }
  }
  ?>
  <!doctype html>
  <html lang="fr">

    <head>
      <title>RoCARS — Sign up</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

      <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700;900&display=swap" rel="stylesheet">

      <link rel="stylesheet" href="fonts/icomoon/style.css">

      <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
      <link rel="stylesheet" href="../../assets/css/bootstrap-datepicker.css">
      <link rel="stylesheet" href="../../assets/css/jquery.fancybox.min.css">
      <link rel="stylesheet" href="../../assets/css/owl.carousel.min.css">
      <link rel="stylesheet" href="../../assets/css/owl.theme.default.min.css">
      <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">
      <link rel="stylesheet" href="../../assets/css/aos.css">

      <!-- MAIN CSS -->
      <link rel="stylesheet" href="../../assets/css/style.css">

    </head>

    <body style="background-color: rgb(157, 160, 161);">

      <div class="site-wrap" id="home-section">

        <div class="site-mobile-menu site-navbar-target">
          <div class="site-mobile-menu-header">
            <div class="site-mobile-menu-close mt-3">
              <span class="icon-close2 js-menu-toggle"></span>
            </div>
          </div>
          <div class="site-mobile-menu-body"></div>
        </div>

        <header class="site-navbar site-navbar-target" role="banner">

          <div class="container">
            <div class="row align-items-center position-relative">

              <div class="col-3">
                <div class="site-logo">
                  <a href="index.php"><strong>RoCARS</strong></a>
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

        <div class="card-body py-5 px-md-5">

          <div class="row d-flex justify-content-center">
            <div class="col-lg-8">
              <h2 class="fw-bold mb-5">Sign up</h2>
              <?php if (!empty($errorMessage)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($errorMessage) ?></div>
              <?php elseif (!empty($successMessage)): ?>
                <div class="alert alert-success"><?= htmlspecialchars($successMessage) ?></div>
              <?php endif; ?>
              <form method="post" action="sign up.php">
                <div class="row">
                  <div class="col-md-6 mb-4">
                    <div data-mdb-input-init class="form-outline">
                      <input type="text" name="firstName" id="firstName" class="form-control" value="<?= htmlspecialchars($fnameValue ?? '') ?>" />
                      <label class="form-label" for="firstName">First name</label>
                    </div>
                  </div>
                  <div class="col-md-6 mb-4">
                    <div data-mdb-input-init class="form-outline">
                      <input type="text" name="lastName" id="lastName" class="form-control" value="<?= htmlspecialchars($lnameValue ?? '') ?>" />
                      <label class="form-label" for="lastName">Last name</label>
                    </div>
                  </div>
                </div>

                <div data-mdb-input-init class="form-outline mb-4">
                  <input type="email" name="email" id="email" class="form-control" value="<?= htmlspecialchars($emailValue ?? '') ?>" />
                  <label class="form-label" for="email">Email</label>
                </div>

                <div data-mdb-input-init class="form-outline mb-4">
                  <input type="password" name="password" id="password" class="form-control" />
                  <label class="form-label" for="password">Password</label>
                </div>

                <div class="row">
                  <div class="col-md-6 mb-4">
                    <div data-mdb-input-init class="form-outline">
                      <input type="text" name="num_permis" id="num_permis" class="form-control" value="<?= htmlspecialchars($numPermisValue ?? '') ?>" />
                      <label class="form-label" for="num_permis">Numéro de permis</label>
                    </div>
                  </div>
                  <div class="col-md-6 mb-4">
                    <div data-mdb-input-init class="form-outline">
                      <input type="text" name="cin" id="cin" class="form-control" value="<?= htmlspecialchars($cinValue ?? '') ?>" />
                      <label class="form-label" for="cin">CIN</label>
                    </div>
                  </div>
                </div>

                <div data-mdb-input-init class="form-outline mb-4">
                  <input type="text" name="adress" id="adress" class="form-control" value="<?= htmlspecialchars($adressValue ?? '') ?>" />
                  <label class="form-label" for="adress">Address</label>
                </div>

                <div data-mdb-input-init class="form-outline mb-4">
                  <input type="text" name="telephone" id="telephone" class="form-control" value="<?= htmlspecialchars($telephoneValue ?? '') ?>" />
                  <label class="form-label" for="telephone">Telephone</label>
                </div>

                <button type="submit" name="submit" class="btn btn-primary btn-block mb-4">Sign up</button>

              </form>
            </div>
          </div>

        </div>

      <script src="../../assets/images/script.js"></script>
    </body>
    </html>
