<?php
session_start();
$errorMessage = '';
$emailValue = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $emailValue = trim($_POST['email'] ?? '');
    $passwordValue = $_POST['password'] ?? '';
    if ($emailValue === '' || $passwordValue === '') {
        $errorMessage = 'Veuillez renseigner l\'email et le mot de passe.';
    } else {
        // PDO version similar to professor's example
        try {
            $dsn = 'mysql:host=localhost;dbname=location;port=3306;charset=utf8mb4';
            $pdo = new PDO($dsn, 'root', '', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
            $stmt = $pdo->prepare('SELECT id_client, Pass, nom, `prénom` AS prenom FROM client WHERE email = ? LIMIT 1');
            $stmt->execute([$emailValue]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($user && password_verify($passwordValue, $user['Pass'])) {
                session_regenerate_id(true);
                $_SESSION['client_id'] = $user['id_client'];
                $_SESSION['client_name'] = $user['nom'] . ' ' . ($user['prenom'] ?? '');
                header('Location: index.php');
                exit;
            } else {
                $errorMessage = 'Email ou mot de passe incorrect.';
            }
        } catch (PDOException $e) {
            $errorMessage = 'Erreur base de données : ' . $e->getMessage();
        }
    }
}
?>
<!doctype html>
<html lang="en">

  <head>
    <title>RoCARS &mdash; HOME</title>
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

  <body>

    
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
                <a href="index.html"><strong>RoCARS</strong></a>
              </div>
            </div>

            <div class="col-9  text-right">
              
              <span class="d-inline-block d-lg-none"><a href="#" class=" site-menu-toggle js-menu-toggle py-5 "><span class="icon-menu h3 text-black"></span></a></span>

              <nav class="site-navigation text-right ml-auto d-none d-lg-block" role="navigation">
                <ul class="site-menu main-menu js-clone-nav ml-auto ">
                  <?php if (!empty(
                    
                    
                    
                    $_SESSION['client_id']
                  )): ?>
                    <li><a href="index.php" class="nav-link">Home</a></li>
                    <li><a href="listing.php" class="nav-link">Listing</a></li>
                    <li class=""><a href="contact.php" class="nav-link">Contact</a></li>
                    <li class="active"><a href="index.php" class="nav-link"><?php echo htmlspecialchars($_SESSION['client_name'] ?? 'Profil'); ?></a></li>
                    <li><a href="logout.php" class="nav-link">Logout</a></li>
                  <?php else: ?>
                    <li><a href="index.php" class="nav-link">Home</a></li>
                    <li><a href="listing.php" class="nav-link">Listing</a></li>
                    <li class="active"><a href="contact.php" class="nav-link">Contact</a></li>
                    <li><a href="login.php" class="nav-link">log in</a></li>
                  <?php endif; ?>
                </ul>
              </nav>
            </div>

            
          </div>
        </div>

      </header>
    <section class="vh-100 gradient-custom">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card bg-dark text-white" style="border-radius: 1rem;">
          <div class="card-body p-5 text-center">

            <div class="mb-md-5 mt-md-4 pb-5">

              <h2 class="fw-bold mb-2 text-uppercase">Login</h2>
              <p class="text-white-50 mb-5">Please enter your login and password!</p>

              <?php if (!empty($errorMessage)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($errorMessage) ?></div>
              <?php endif; ?>
              <form method="post" action="">
              <div data-mdb-input-init class="form-outline form-white mb-4">
                <input type="email" name="email" id="typeEmailX" class="form-control form-control-lg" value="<?= htmlspecialchars($emailValue ?? '') ?>" />
                <label class="form-label" for="typeEmailX">Email</label>
              </div>

              <div data-mdb-input-init class="form-outline form-white mb-4">
                <input type="password" name="password" id="typePasswordX" class="form-control form-control-lg" />
                <label class="form-label" for="typePasswordX">Password</label>
              </div>

              <p class="small mb-5 pb-lg-2"><a class="text-white-50" href="#!">Forgot password?</a></p>

              <button data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-light btn-lg px-5" type="submit" name="login">Login</button>

              <div class="d-flex justify-content-center text-center mt-4 pt-1">
                <a href="#!" class="text-white"><i class="fab fa-facebook-f fa-lg"></i></a>
                <a href="#!" class="text-white"><i class="fab fa-twitter fa-lg mx-4 px-2"></i></a>
                <a href="#!" class="text-white"><i class="fab fa-google fa-lg"></i></a>
              </div>

            </div>

            </form>
            <div>
              <p class="mb-0">Don't have an account? <a href="sign up.php" class="text-white-50 fw-bold">Sign Up</a>
              </p>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</body>
</html>