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
    <title>Kruiwagen || B&B Webshop</title>
    <link rel="icon" type="image/x-icon" href="img/buurmanheader2.jpg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/background.css" rel="stylesheet">
</head>

<body>
    <?php
    include("includes/header.php");
    include("includes/navbar.php");
    ?>
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12">
                <div class="column">
                    <div class="card card-registration card-registration-2" style="border-radius: 15px;">
                        <div class="card-body p-0">
                            <div class="row g-0">
                                <div class="col-lg-7">
                                    <div class="p-5">
                                        <div class="d-flex justify-content-between align-items-center mb-5">
                                            <h1 class="fw-bold mb-0 text-black">Kruiwagen</h1>
                                        </div>
                                        <hr class="my-4">
                                        <form method="post" action="wagen_update.php">
                                            <div class="table-responsive">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Aantal</th>
                                                            <th>Naam</th>
                                                            <th>Prijs</th>
                                                            <th>Totaal</th>
                                                            <th>Verwijder</th>
                                                            <th>Verminder</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        // wanneer je bent ingelogd:
                                                        if (isset($_SESSION["email"])) {
                                                            foreach ($producten as $product) {
                                                                $product_naam = $product["productNaam"];
                                                                $product_aantal = min(max($product["productAantal"], 1), 10);
                                                                $product_prijs = $product["productPrijs"];
                                                                $subtotaal = $product_prijs * $product_aantal;
                                                                $totaal += $subtotaal;
                                                                echo '<tr>';
                                                                echo '<td> ' . $product_aantal . '</td>';
                                                                echo '<td>' . $product_naam . '</td>';
                                                                echo '<td>€' . $product_prijs . '</td>';
                                                                echo '<td>€' . $subtotaal . '</td>';
                                                                echo '<td><button type="submit" name="verwijder_code[]" value="' . $product['productCode'] . '" class="btn btn-danger">Verwijder</button></td>';
                                                                echo '<td><button type="submit" name="verminder_code[]" value="' . $product['productCode'] . '" class="btn btn-danger">-1</button></td>';
                                                                echo '</tr>';
                                                            }
                                                            // wanneer je niet bent ingelogd:
                                                        } else {
                                                            $b = 0;
                                                            // als producten naar de winkelwagen worden gestuurd, wordt alles netjes met bootstrap in de winkelwagen gezet
                                                            if (isset($_SESSION["producten"])) {

                                                                foreach ($_SESSION["producten"] as $wagen_item) {
                                                                    $product_naam = $wagen_item["product_naam"];
                                                                    $product_aantal = min(max($wagen_item["product_aantal"], 1), 10);
                                                                    $product_prijs = $wagen_item["product_prijs"];
                                                                    $product_code = $wagen_item["product_code"];
                                                                    $subtotaal = ($product_prijs * $product_aantal);
                                                                    echo '<td> ' . $product_aantal . ' </td>';
                                                                    echo '<td> ' . $product_naam . ' </td>';
                                                                    echo '<td>' . $euroteken . $product_prijs . '</td>';
                                                                    echo '<td>' . $euroteken . $subtotaal . '</td>';
                                                                    echo '<td><button type="submit" name="verwijder_code[]" value="' . $product_code . '" class="btn btn-danger">Verwijder</button></td>';
                                                                    echo '<td><button type="submit" name="verminder_code[]" value="' . $product_code . '" class="btn btn-danger">-1</button></td>';
                                                                    echo '</tr>';
                                                                    $totaal = ($totaal + $subtotaal);
                                                                }
                                                            }
                                                        }

                                                        ?>
                                                        <tr>
                                                            <td colspan="6">
                                                                <a href="shop.php" class="btn btn-primary">Verder winkelen</a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <input type="hidden" name="url_terug" value="<?php echo urlencode("http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>" />
                                        </form>
                                    </div>
                                </div>
                                <!-- prijs sectie -->
                                <div class="col-md-5 offset-md-6.5" style="margin-top: 140px;">
                                    <div class="card mb-3">
                                        <div class="card-header text-center">
                                            <h5>Overzicht</h5>
                                        </div>
                                        <div class="card-body">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    Subtotaal
                                                    <span>€<?php echo $totaal; ?></span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    Verzendkosten
                                                    <span>€5.00</span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    totaal
                                                    <span>€<?php echo $totaal + 5; ?></span>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="card-footer text-center">
                                            <a class="btn btn-primary" href="adressgegevens.php">Betalen</a>
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