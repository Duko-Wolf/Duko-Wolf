<?php include('includes/session.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registreer || B&B Webshop</title>
  <link rel="icon" type="image/x-icon" href="img/buurmanheader2.jpg">
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
  <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
  <link rel="stylesheet" type="text/css" href="css/background.css">
</head>

<body>

  <?php include("includes/header.php");
  ?>

  <?php include("includes/navbar.php");
  ?>

  <?php
  if (isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
  }
  // include functions.php
  include('functions/functions.php');

  // connect with database
  $conn = dbConnect();
  ?>

  <section class="bg-image" style="margin-bottom: 5%;">
    <div class="container h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-9 col-lg-7 col-xl-6">
          <div class="card" style="border-radius: 15px;">
            <div class="card-body p-5">
              <h2 class="text-uppercase text-center mb-5">Creeer een account</h2>

              <form action="registreer.php" method="post">
                <div class="form-outline mb-4">
                  <label class="form-label" for="registerform">Naam</label>
                  <input type="text" id="registerform" class="form-control form-control-lg" name="gebruikersNaam" required>
                </div>

                <div class="form-outline mb-4">
                  <label class="form-label" for="registerform">Email</label>
                  <input type="email" id="registerform" class="form-control form-control-lg" name="email" required>
                </div>

                <div class="form-outline mb-4">
                  <label class="form-label" for="registerform">Wachtwoord</label>
                  <input type="password" id="registerform" class="form-control form-control-lg" name="gebruikersWachtwoord" required>
                </div>

                <div class="form-outline mb-4">
                  <label class="form-label" for="registerform">Herhaal je wachtwoord</label>
                  <input type="password" id="registerform" class="form-control form-control-lg" name="gebruikersHerhaalWachtwoord" required>
                </div>

                <div class="d-flex justify-content-center">
                  <input type="submit" name="submit" class="btn btn-primary btn-block btn-lg gradient-custom-4 text-white">
                </div>

                <p class="text-center text-muted mt-5 mb-0">Heeft u al een account? <a href="login.php" class="fw-bold text-body"><u>Login hier</u></a></p>


              </form>
              <?php
              // import functions.php
              require_once 'functions\functions.php';

              // use function dbConnect() from functions.php 
              $conn = dbConnect();

              // use function registreer() from functions.php
              registreer($conn);

              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
  </section>

  <?php include("includes/footer.php");
  ?>

</body>

</html>