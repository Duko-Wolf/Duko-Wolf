<?php
session_start();
include("functions/functions.php");

// Totaal variabele initialiseren
$totaal = 0;

// Controleer of de gebruiker ingelogd is
if (isset($_SESSION["email"])) {
    // Gebruiker is ingelogd, haal producten op uit de database
    $user_email = $_SESSION["email"];
    $conn = dbConnect();
    $statement = $conn->prepare("SELECT * FROM kruiwagen WHERE email = (SELECT email FROM gebruikers WHERE email = ?)");
    $statement->execute(array($user_email));
    $producten = $statement->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Gebruiker is niet ingelogd, haal producten op uit de sessie
    if (isset($_SESSION["producten"])) {
        $producten = $_SESSION["producten"];
    } else {
        $producten = array(); // Lege lijst als er geen producten zijn
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gegevens || B&B Webshop</title>
    <link rel="icon" type="image/x-icon" href="img/buurmanheader2.jpg">
    <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
    <link href="css/background.css" rel="stylesheet">
    <style>
        /* Stijl de achtergrondkleur van de toastr-popup */
        .toast-success {
            background-color: #28a745 !important; /* Groene kleur */
        }
    </style>
 <script>
        // Voeg een eventlistener toe aan de afrekenknop om de toastr-melding te tonen
        document.addEventListener('DOMContentLoaded', function() {
            var afrekenenBtn = document.getElementById('afrekenen');
            afrekenenBtn.addEventListener('click', function(event) {
                if (!afrekenenBtn.disabled) {
                    event.preventDefault(); // Voorkom standaardformulierinzending
                    toastr.success('Wij zijn niet gemachtigd om geld te vragen');
                    afrekenenBtn.disabled = true; // Schakelt de knop uit
                    setTimeout(function() {
                        afrekenenBtn.disabled = false; // Schakelt de knop na 5 seconden weer in
                    }, 5000);
                    setTimeout(function() {
                        window.location.href = 'index.php'; // herleid je naar de indexpagina na 3 seconden
                    }, 3000);
                }
            });
        });
    </script>
</head>

<body>
    <?php
    include("includes/header.php");
    include("includes/navbar.php");
    ?>
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-7">
                <div class="column">
                    <div class="card card-registration card-registration-2" style="border-radius: 15px;">
                        <div class="card-body p-0">
                            <div class="row g-0">
                                <div class="col-lg-12">
                                    <div class="p-5">
                                        <div class="d-flex justify-content-between align-items-center mb-5">
                                            <h1 class="fw-bold mb-0 text-black">Gegevens</h1>
                                        </div>
                                        <hr class="my-4">
                                        <form method="post" action="wagen_update.php">
                                            <table class="table table-striped">
                                                <div class="row">
                                                    <div class="col-md-12 mb-4">
                                                        <div class="card mb-4">
                                                            <div class="card-header py-3">
                                                                <h5 class="mb-0">betaal gegevens</h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <form onsubmit="return validateForm()">
                                                                    <div class="row mb-4">
                                                                        <div class="col">
                                                                            <div data-mdb-input-init class="form-outline">
                                                                                <input type="text" id="voornaam" class="form-control" required />
                                                                                <label class="form-label" for="voornaam">Voornaam</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col">
                                                                            <div data-mdb-input-init class="form-outline">
                                                                                <input type="text" id="Achternaam" class="form-control" required />
                                                                                <label class="form-label" for="Achternaam">Achternaam</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row mb-4">
                                                                        <div class="col">
                                                                            <div data-mdb-input-init class="form-outline">
                                                                                <input type="text" id="adres1" class="form-control" required />
                                                                                <label class="form-label" for="adres1">Adres 1</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col">
                                                                            <div data-mdb-input-init class="form-outline">
                                                                                <input type="text" id="adres2" class="form-control" required />
                                                                                <label class="form-label" for="adres2">Adres 2</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div data-mdb-input-init class="form-outline mb-4">
                                                                        <input type="text" id="postcode" class="form-control" required />
                                                                        <label class="form-label" for="postcode">postcode</label>
                                                                    </div>

                                                                    <div>
                                                                        <div class="form-outline mb-4">
                                                                            <select id="bank" class="form-select" required>
                                                                                <option value="" selected disabled>Kies je bank</option>
                                                                                <option value="bank1">ING</option>
                                                                                <option value="bank2">ABN AMRO</option>
                                                                                <option value="bank3">RABO BANK</option>
                                                                                <option value="bank4">REGIO BANK</option>
                                                                                <option value="bank5">ASN BANK</option>
                                                                                <option value="bank6">bunq</option>
                                                                                <option value="bank7">SNS</option>

                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <?php
                                                                    if (!isset($_SESSION['email'])) {
                                                                        echo '<!-- Email input -->
                                                                            <div data-mdb-input-init class="form-outline mb-4">
                                                                            <input type="email" id="email" class="form-control" required />
                                                                            <label class="form-label" for="email">Email</label>
                                                                            </div>';
                                                                    } ?>

                                                                    <div data-mdb-input-init class="form-outline mb-4">
                                                                        <input type="number" id="telefoonnummer" class="form-control" />
                                                                        <label class="form-label" for="telefoonnummer">Telefoonnummer</label>
                                                                    </div>
                                                                    <div class="form-check d-flex justify-content-center mb-2">
                                                                        <input class="form-check-input me-2" type="checkbox" value="" id="akkoord" required />
                                                                        <label class="form-check-label" for="akkoord">Ik ga akkoord met de algemene voorwaarden</label>
                                                                    </div>
                                                                    <button type="button" id='afrekenen' class="btn btn-success">Afrekenen</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <?php
    include("includes/footer.php");
    ?>
</body>

</html>
