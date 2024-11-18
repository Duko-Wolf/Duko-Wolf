<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Winkel || B&B Webshop</title>
    <link rel="icon" type="image/x-icon" href="img/buurmanheader2.jpg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/background.css" rel="stylesheet" type="text/css">
    <style>
        .card {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <!--Includes voor de header en de navbar-->
    <?php
    session_start();
    include("functions/functions.php");
    include("includes/header.php");
    include("includes/navbar.php");
    $pdo = dbConnect1();

    $url = urlencode($url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);

    ?>

    <!-- Filter en Producten -->
    <div class="container mt-5 mb-5">
        <div class="row">
            <!-- Producten sectie -->
            <div class="col-md-8">
                <div class="container bg-light p-3 rounded">
                    <h2 class="text-center mb-4">Producten</h2>
                    <div class="row">
                        <?php
                        // als er op de zoekknop wordt gedrukt wordt de volgende if statement uitgevoerd:
                        if (isset($_POST['zoekterm'])) {
                            $zoekterm = $_POST['zoekterm'];
                            // query voor producten tonen die worden opgezocht
                            $stmt = $pdo->prepare("SELECT productCode AS product_code, productNaam AS product_naam, productValue AS prijs, productDescription AS product_beschrijving, productImg AS product_img FROM producten WHERE productNaam LIKE ?");
                            $stmt->execute(["%$zoekterm%"]);

                            // wanneer er wat opgezocht wordt, worden er producten getoond
                            if ($stmt->rowCount() > 0) {
                                echo "<div class='container bg-light p-3 rounded'>";
                                echo "<h2 class='col-md-4'>Zoekresultaten voor '$zoekterm':</h2>";
                                echo "<div class='row'>";
                                while ($obj = $stmt->fetch(PDO::FETCH_OBJ)) {
                                    echo '<div class="col-md-4">';
                                    echo '<div class="card">';
                                    echo '<div class="card-body">';
                                    echo '<img src="img/' . $obj->product_img . '" class="card-img-top" alt="...">';
                                    echo '<h5 class="card-title">' . $obj->product_naam . '</h5>';
                                    echo '<p class="card-text">' . $obj->product_beschrijving . '</p>';
                                    echo '<p class="card-text">prijs: €' . $obj->prijs . '</p>';
                                    echo '<form method="post" action="wagen_update.php">';
                                    echo '<div class="mb-3">';
                                    echo '<label for="Aantal' . $obj->product_code . '" class="form-label">Aantal</label>';
                                    echo '<input type="number" class="form-control" id="Aantal' . $obj->product_code . '" name="product_aantal" value="1" max="10" min="1">';
                                    echo '</div>';
                                    echo '<input type="hidden" name="product_code" value="' . $obj->product_code . '">';
                                    echo '<input type="hidden" name="type" value="add">';
                                    echo '<input type="hidden" name="url_terug" value="' . $url . '">';
                                    echo '<button type="submit" class="btn btn-primary">Voeg toe aan de kruiwagen!</button>';
                                    echo '</form>';
                                    echo '</div>';
                                    echo '</div>';
                                    echo '</div>';
                                }
                                echo '</div></div>';
                            } else {
                                echo "<p>Geen zoekresultaten gevonden voor '$zoekterm'.</p>";
                            }

//                            Als er geen zoekopdracht wordt gegeven dan kijkt deze elseif of er een filter is ingeklikt en de knop is ingedrukt
                        } elseif (isset($_POST['search'])) {
                            //code die kijkt of er een filter is ingeklikt en dan de juiste query uitvoert
                            if (isset($_POST['category'])) {
                                $category = $_POST['category'];

                                //Switch voor de verschillende categorieen
                                switch ($category) {
                                    case 'alles':
                                        $stmt = $pdo->prepare("SELECT productCode AS product_code, productNaam AS product_naam, productValue AS prijs, productDescription AS product_beschrijving, productImg AS product_img FROM producten");
                                        $stmt->execute();
                                        if ($stmt) {
                                            while ($obj = $stmt->fetch(PDO::FETCH_OBJ)) {
                                                echo '<div class="col-md-4">';
                                                echo '<div class="card">';
                                                echo '<div class="card-body">';
                                                echo '<img src="img/' . $obj->product_img . '" class="card-img-top" alt="...">';
                                                echo '<h5 class="card-title">' . $obj->product_naam . '</h5>';
                                                echo '<p class="card-text">' . $obj->product_beschrijving . '</p>';
                                                echo '<p class="card-text">prijs: €' . $obj->prijs . '</p>';
                                                echo '<form method="post" action="wagen_update.php">';
                                                echo '<div class="mb-3">';
                                                echo '<label for="Aantal' . $obj->product_code . '" class="form-label">Aantal</label>';
                                                echo '<input type="number" class="form-control" id="Aantal' . $obj->product_code . '" name="product_aantal" value="1" max="10" min="1">';
                                                echo '</div>';
                                                echo '<input type="hidden" name="product_code" value="' . $obj->product_code . '">';
                                                echo '<input type="hidden" name="type" value="add">';
                                                echo '<input type="hidden" name="url_terug" value="' . $url . '">';
                                                echo '<button type="submit" class="btn btn-primary">Voeg toe aan de kruiwagen!</button>';
                                                echo '</form>';
                                                echo '</div>';
                                                echo '</div>';
                                                echo '</div>';
                                            }
                                        }
                                        break;
                                    case 'gereedschap':
                                        $stmt = $pdo->prepare("SELECT productCode AS product_code, productNaam AS product_naam, productValue AS prijs, productDescription AS product_beschrijving, productImg AS product_img FROM producten WHERE productCategory = 'gereedschap'");
                                        $stmt->execute([]);
                                        if ($stmt) {
                                            while ($obj = $stmt->fetch(PDO::FETCH_OBJ)) {
                                                echo '<div class="col-md-4">';
                                                echo '<div class="card">';
                                                echo '<div class="card-body">';
                                                echo '<img src="img/' . $obj->product_img . '" class="card-img-top" alt="...">';
                                                echo '<h5 class="card-title">' . $obj->product_naam . '</h5>';
                                                echo '<p class="card-text">' . $obj->product_beschrijving . '</p>';
                                                echo '<p class="card-text">prijs: €' . $obj->prijs . '</p>';
                                                echo '<form method="post" action="wagen_update.php">';
                                                echo '<div class="mb-3">';
                                                echo '<label for="Aantal' . $obj->product_code . '" class="form-label">Aantal</label>';
                                                echo '<input type="number" class="form-control" id="Aantal' . $obj->product_code . '" name="product_aantal" value="1" max="10" min="1">';
                                                echo '</div>';
                                                echo '<input type="hidden" name="product_code" value="' . $obj->product_code . '">';
                                                echo '<input type="hidden" name="type" value="add">';
                                                echo '<input type="hidden" name="url_terug" value="' . $url . '">';
                                                echo '<button type="submit" class="btn btn-primary">Voeg toe aan de kruiwagen!</button>';
                                                echo '</form>';
                                                echo '</div>';
                                                echo '</div>';
                                                echo '</div>';
                                            }
                                        }
                                        break;
                                    case 'spelletjes':
                                        $stmt = $pdo->prepare("SELECT productCode AS product_code, productNaam AS product_naam, productValue AS prijs, productDescription AS product_beschrijving, productImg AS product_img FROM producten WHERE productCategory = 'spelletjes'");
                                        $stmt->execute();
                                        if ($stmt) {
                                            while ($obj = $stmt->fetch(PDO::FETCH_OBJ)) {
                                                echo '<div class="col-md-4">';
                                                echo '<div class="card">';
                                                echo '<div class="card-body">';
                                                echo '<img src="img/' . $obj->product_img . '" class="card-img-top" alt="...">';
                                                echo '<h5 class="card-title">' . $obj->product_naam . '</h5>';
                                                echo '<p class="card-text">' . $obj->product_beschrijving . '</p>';
                                                echo '<p class="card-text">prijs: €' . $obj->prijs . '</p>';
                                                echo '<form method="post" action="wagen_update.php">';
                                                echo '<div class="mb-3">';
                                                echo '<label for="Aantal' . $obj->product_code . '" class="form-label">Aantal</label>';
                                                echo '<input type="number" class="form-control" id="Aantal' . $obj->product_code . '" name="product_aantal" value="1" max="10" min="1">';
                                                echo '</div>';
                                                echo '<input type="hidden" name="product_code" value="' . $obj->product_code . '">';
                                                echo '<input type="hidden" name="type" value="add">';
                                                echo '<input type="hidden" name="url_terug" value="' . $url . '">';
                                                echo '<button type="submit" class="btn btn-primary">Voeg toe aan de kruiwagen!</button>';
                                                echo '</form>';
                                                echo '</div>';
                                                echo '</div>';
                                                echo '</div>';
                                            }
                                        }
                                        break;
                                    case 'media':
                                        $stmt = $pdo->prepare("SELECT productCode AS product_code, productNaam AS product_naam, productValue AS prijs, productDescription AS product_beschrijving, productImg AS product_img FROM producten WHERE productCategory = 'media'");
                                        $stmt->execute();
                                        if ($stmt) {
                                            while ($obj = $stmt->fetch(PDO::FETCH_OBJ)) {
                                                echo '<div class="col-md-4">';
                                                echo '<div class="card">';
                                                echo '<div class="card-body">';
                                                echo '<img src="img/' . $obj->product_img . '" class="card-img-top" alt="...">';
                                                echo '<h5 class="card-title">' . $obj->product_naam . '</h5>';
                                                echo '<p class="card-text">' . $obj->product_beschrijving . '</p>';
                                                echo '<p class="card-text">prijs: €' . $obj->prijs . '</p>';
                                                echo '<form method="post" action="wagen_update.php">';
                                                echo '<div class="mb-3">';
                                                echo '<label for="Aantal' . $obj->product_code . '" class="form-label">Aantal</label>';
                                                echo '<input type="number" class="form-control" id="Aantal' . $obj->product_code . '" name="product_aantal" value="1" max="10" min="1">';
                                                echo '</div>';
                                                echo '<input type="hidden" name="product_code" value="' . $obj->product_code . '">';
                                                echo '<input type="hidden" name="type" value="add">';
                                                echo '<input type="hidden" name="url_terug" value="' . $url . '">';
                                                echo '<button type="submit" class="btn btn-primary">Voeg toe aan de kruiwagen!</button>';
                                                echo '</form>';
                                                echo '</div>';
                                                echo '</div>';
                                                echo '</div>';
                                            }
                                        }
                                        break;
                                    case 'kleding':
                                        $stmt = $pdo->prepare("SELECT productCode AS product_code, productNaam AS product_naam, productValue AS prijs, productDescription AS product_beschrijving, productImg AS product_img FROM producten WHERE productCategory = 'kleding'");
                                        $stmt->execute();
                                        if ($stmt) {
                                            while ($obj = $stmt->fetch(PDO::FETCH_OBJ)) {
                                                echo '<div class="col-md-4">';
                                                echo '<div class="card">';
                                                echo '<div class="card-body">';
                                                echo '<img src="img/' . $obj->product_img . '" class="card-img-top" alt="...">';
                                                echo '<h5 class="card-title">' . $obj->product_naam . '</h5>';
                                                echo '<p class="card-text">' . $obj->product_beschrijving . '</p>';
                                                echo '<p class="card-text">prijs: €' . $obj->prijs . '</p>';
                                                echo '<form method="post" action="wagen_update.php">';
                                                echo '<div class="mb-3">';
                                                echo '<label for="Aantal' . $obj->product_code . '" class="form-label">Aantal</label>';
                                                echo '<input type="number" class="form-control" id="Aantal' . $obj->product_code . '" name="product_aantal" value="1" max="10" min="1">';
                                                echo '</div>';
                                                echo '<input type="hidden" name="product_code" value="' . $obj->product_code . '">';
                                                echo '<input type="hidden" name="type" value="add">';
                                                echo '<input type="hidden" name="url_terug" value="' . $url . '">';
                                                echo '<button type="submit" class="btn btn-primary">Voeg toe aan de kruiwagen!</button>';
                                                echo '</form>';
                                                echo '</div>';
                                                echo '</div>';
                                                echo '</div>';
                                            }
                                        }
                                        break;
                                    case 'speelgoed':
                                        $stmt = $pdo->prepare("SELECT productCode AS product_code, productNaam AS product_naam, productValue AS prijs, productDescription AS product_beschrijving, productImg AS product_img FROM producten WHERE productCategory = 'speelgoed'");
                                        $stmt->execute();
                                        if ($stmt) {
                                            while ($obj = $stmt->fetch(PDO::FETCH_OBJ)) {
                                                echo '<div class="col-md-4">';
                                                echo '<div class="card">';
                                                echo '<div class="card-body">';
                                                echo '<img src="img/' . $obj->product_img . '" class="card-img-top" alt="...">';
                                                echo '<h5 class="card-title">' . $obj->product_naam . '</h5>';
                                                echo '<p class="card-text">' . $obj->product_beschrijving . '</p>';
                                                echo '<p class="card-text">prijs: €' . $obj->prijs . '</p>';
                                                echo '<form method="post" action="wagen_update.php">';
                                                echo '<div class="mb-3">';
                                                echo '<label for="Aantal' . $obj->product_code . '" class="form-label">Aantal</label>';
                                                echo '<input type="number" class="form-control" id="Aantal' . $obj->product_code . '" name="product_aantal" value="1" max="10" min="1">';
                                                echo '</div>';
                                                echo '<input type="hidden" name="product_code" value="' . $obj->product_code . '">';
                                                echo '<input type="hidden" name="type" value="add">';
                                                echo '<input type="hidden" name="url_terug" value="' . $url . '">';
                                                echo '<button type="submit" class="btn btn-primary">Voeg toe aan de kruiwagen!</button>';
                                                echo '</form>';
                                                echo '</div>';
                                                echo '</div>';
                                                echo '</div>';
                                            }
                                        }
                                        break;
                                    case 'prijsoplopend':
                                        $stmt = $pdo->prepare("SELECT productCode AS product_code, productNaam AS product_naam, productValue AS prijs, productDescription AS product_beschrijving, productImg AS product_img FROM producten ORDER BY prijs ASC ");
                                        $stmt->execute();
                                        if ($stmt) {
                                            while ($obj = $stmt->fetch(PDO::FETCH_OBJ)) {
                                                echo '<div class="col-md-4">';
                                                echo '<div class="card">';
                                                echo '<div class="card-body">';
                                                echo '<img src="img/' . $obj->product_img . '" class="card-img-top" alt="...">';
                                                echo '<h5 class="card-title">' . $obj->product_naam . '</h5>';
                                                echo '<p class="card-text">' . $obj->product_beschrijving . '</p>';
                                                echo '<p class="card-text">prijs: €' . $obj->prijs . '</p>';
                                                echo '<form method="post" action="wagen_update.php">';
                                                echo '<div class="mb-3">';
                                                echo '<label for="Aantal' . $obj->product_code . '" class="form-label">Aantal</label>';
                                                echo '<input type="number" class="form-control" id="Aantal' . $obj->product_code . '" name="product_aantal" value="1" max="10" min="1">';
                                                echo '</div>';
                                                echo '<input type="hidden" name="product_code" value="' . $obj->product_code . '">';
                                                echo '<input type="hidden" name="type" value="add">';
                                                echo '<input type="hidden" name="url_terug" value="' . $url . '">';
                                                echo '<button type="submit" class="btn btn-primary">Voeg toe aan de kruiwagen!</button>';
                                                echo '</form>';
                                                echo '</div>';
                                                echo '</div>';
                                                echo '</div>';
                                            }
                                        }
                                        break;
                                    case 'prijsaflopend':
                                        $stmt = $pdo->prepare("SELECT productCode AS product_code, productNaam AS product_naam, productValue AS prijs, productDescription AS product_beschrijving, productImg AS product_img FROM producten ORDER BY prijs DESC ");
                                        $stmt->execute();
                                        if ($stmt) {
                                            while ($obj = $stmt->fetch(PDO::FETCH_OBJ)) {
                                                echo '<div class="col-md-4">';
                                                echo '<div class="card">';
                                                echo '<div class="card-body">';
                                                echo '<img src="img/' . $obj->product_img . '" class="card-img-top" alt="...">';
                                                echo '<h5 class="card-title">' . $obj->product_naam . '</h5>';
                                                echo '<p class="card-text">' . $obj->product_beschrijving . '</p>';
                                                echo '<p class="card-text">prijs: €' . $obj->prijs . '</p>';
                                                echo '<form method="post" action="wagen_update.php">';
                                                echo '<div class="mb-3">';
                                                echo '<label for="Aantal' . $obj->product_code . '" class="form-label">Aantal</label>';
                                                echo '<input type="number" class="form-control" id="Aantal' . $obj->product_code . '" name="product_aantal" value="1" max="10" min="1">';
                                                echo '</div>';
                                                echo '<input type="hidden" name="product_code" value="' . $obj->product_code . '">';
                                                echo '<input type="hidden" name="type" value="add">';
                                                echo '<input type="hidden" name="url_terug" value="' . $url . '">';
                                                echo '<button type="submit" class="btn btn-primary">Voeg toe aan de kruiwagen!</button>';
                                                echo '</form>';
                                                echo '</div>';
                                                echo '</div>';
                                                echo '</div>';
                                            }
                                        }
                                        break;
                                }
                            }
                        } else {
                            // wanneer er nergens naar gezocht wordt of er wordt nergens gefilterd haalt hij alles op uit de data base en zet het met bootstrap netjes op de pagina
                            $stmt = $pdo->query("SELECT productCode AS product_code, productNaam AS product_naam, productValue AS prijs, productDescription AS product_beschrijving, productImg AS product_img FROM producten ORDER BY productNaam ASC");
                            if ($stmt) {
                                while ($obj = $stmt->fetch(PDO::FETCH_OBJ)) {
                                    echo '<div class="col-md-4">';
                                    echo '<div class="card">';
                                    echo '<div class="card-body">';
                                    echo '<img src="img/' . $obj->product_img . '" class="card-img-top" alt="...">';
                                    echo '<h5 class="card-title">' . $obj->product_naam . '</h5>';
                                    echo '<p class="card-text">' . $obj->product_beschrijving . '</p>';
                                    echo '<p class="card-text">prijs: €' . $obj->prijs . '</p>';
                                    echo '<form method="post" action="wagen_update.php">';
                                    echo '<div class="mb-3">';
                                    echo '<label for="Aantal' . $obj->product_code . '" class="form-label">Aantal</label>';
                                    echo '<input type="number" class="form-control" id="Aantal' . $obj->product_code . '" name="product_aantal" value="1" max="10" min="1">';
                                    echo '</div>';
                                    echo '<input type="hidden" name="product_code" value="' . $obj->product_code . '">';
                                    echo '<input type="hidden" name="type" value="add">';
                                    echo '<input type="hidden" name="url_terug" value="' . $url . '">';
                                    echo '<button type="submit" class="btn btn-primary">Voeg toe aan de kruiwagen!</button>';
                                    echo '</form>';
                                    echo '</div>';
                                    echo '</div>';
                                    echo '</div>';
                                }
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <!--  HTML Filter sectie -->
            <div class="col-md-4">
                <div class="sticky-top" style="top: 15px">
                    <div class="bg-light p-3 rounded">
                        <h4>Filter</h4>
                        <form action="shop.php" method="POST">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <p><b>Categorieën</b></p>
                                            <div class="form-check">
                                                <input class="form-check-input" value="gereedschap" type="radio" name="category" id="category_een">
                                                <label class="form-check-label" for="category_een">Gereedschap</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" value="spelletjes" type="radio" name="category" id="category_twee">
                                                <label class="form-check-label" for="category_twee">Spelletjes</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" value="media" type="radio" name="category" id="category_drie">
                                                <label class="form-check-label" for="category_drie">Media</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" value="kleding" type="radio" name="category" id="category_vier">
                                                <label class="form-check-label" for="category_vier">Kleding</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" value="speelgoed" type="radio" name="category" id="category_vijf">
                                                <label class="form-check-label" for="category_vijf">Speelgoed</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <p><b>Prijs</b></p>
                                            <div class="form-check">
                                                <input class="form-check-input" value="prijsoplopend" type="radio" name="category" id="category_zes">
                                                <label class="form-check-label" for="category_zes">Prijs oplopend</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" value="prijsaflopend" type="radio" name="category" id="category_zeven">
                                                <label class="form-check-label" for="category_zeven">Prijs aflopend</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row col-xl-12">
                                <div class="col-xl-6">
                                    <div class="form-group my-1 mx-1">
                                        <input type="submit" name="search" value="Zoeken" class="btn btn-primary">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group my-1 mx-1">
                                        <input type="submit" name="category" value="Verwijder alle filters" class="btn btn-primary">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!--Winkelwagen sectie-->
                    <?php
                    if (isset($_SESSION['email'])) {
                        // Query om alle producten op te halen
                        $conn = dbConnect();
                        $query = "SELECT productCode, productNaam, productPrijs, productAantal FROM kruiwagen WHERE email = '" . $_SESSION['email'] . "'";
                        $result = $conn->query($query);
                        if ($result->rowCount() > 0) {
                            echo '<div class="cart-view-table-front bg-light p-3 rounded mt-3 mb-1" id="view-cart" style="max-height: 380px; overflow-y: auto; overflow-x: hidden;">';
                            echo '<h3>Uw kruiwagen</h3>';
                            echo '<form method="post" action="wagen_update.php">';
                            echo '<table class="table table-striped">';
                            echo '<tbody>';

                            $totaal = 0;
                            // Loop door elk product en print deze op de pagina
                            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                $product_code = $row["productCode"];
                                $product_naam = $row["productNaam"];
                                $product_prijs = $row["productPrijs"];
                                $product_aantal = min(max($row["productAantal"], 1), 10);

                                echo '<tr>';
                                echo '<td>Aantal: ' . $product_aantal . '</td>';
                                echo '<td>' . $product_naam . '</td>';
                                echo '<td>&euro;' . $product_prijs . '</td>';
                                echo '<td>&euro;' . ($product_prijs * $product_aantal) . '</td>';
                                echo '<td><button type="submit" name="verwijder_code[]" value="' . $product_code . '" class="btn btn-danger">Verwijder</button></td>';
                                echo '</tr>';
                                $totaal += ($product_prijs * $product_aantal);
                            }

                            echo '</tbody>';
                            echo '</table>';
                            echo '<a href="kruiwagen.php" class="btn btn-primary">Betalen</a>';
                            echo '</form>';
                            echo '</div>';
                        } else {
                            //als de wagen leeg is 
                            echo '<div class="cart-view-table-front bg-light p-3 rounded mt-3" id="view-cart" style="max-height: 380px; overflow-y: auto; overflow-x: hidden;">';
                            echo '<h3>Uw kruiwagen</h3>';
                            echo '<div class="bg-light p-3 rounded mt-3">Uw kruiwagen is leeg</div>';
                            echo '</div>';
                        }
                    } else {
                        if (isset($_SESSION["producten"]) && count($_SESSION["producten"]) > 0) {
                            echo '<div class="cart-view-table-front bg-light p-3 rounded mt-3" id="view-cart" style="max-height: 380px; overflow-y: auto; overflow-x: hidden;">';
                            echo '<h3>Uw kruiwagen</h3>';
                            echo '<form method="post" action="wagen_update.php">';
                            echo '<table class="table table-striped">';
                            echo '<tbody>';

                            $totaal = 0;
                            $b = 0;
                            //Pakt de items die worden besteld en stopt het in de winkelwagen
                            foreach ($_SESSION["producten"] as $wagen_product) {
                                $product_naam = $wagen_product["product_naam"];
                                $product_aantal = min(max($wagen_product["product_aantal"], 1), 10);
                                $product_prijs = $wagen_product["product_prijs"];
                                $product_code = $wagen_product["product_code"];

                                echo '<tr>';
                                echo '<td>Aantal: ' . $product_aantal . '</td>';;
                                echo '<td>' . $product_naam . '</td>';
                                echo '<td><button type="submit" name="verwijder_code[]" value="' . $product_code . '" class="btn btn-danger">Verwijder</button></td>';
                                echo '</tr>';
                                $subtotaal = ($product_prijs * $product_aantal);
                                $totaal = ($totaal + $subtotaal);
                            }
                            echo '<td colspan="3">';
                            echo '<a href="kruiwagen.php" class="btn btn-primary">Betalen</a>';
                            echo '</td>';
                            echo '</tbody>';
                            echo '</table>';

                            $url = urlencode($url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                            echo '<input type="hidden" name="url_terug" value="' . $url . '" />';
                            echo '</form>';
                            echo '</div>';
                        } else {
                            echo '<div class="cart-view-table-front bg-light p-3 rounded mt-3" id="view-cart" style="max-height: 380px; overflow-y: auto; overflow-x: hidden;">';
                            echo '<h3>Uw kruiwagen</h3>';
                            echo '<div class="bg-light p-3 rounded mt-3">Uw kruiwagen is leeg</div>';
                            echo '</div>';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <?php include("includes/footer.php"); ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>