<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Winkel || B&B Webshop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="css/background.css" rel="stylesheet">
</head>
<body>

<!--Includes voor de header en de navbar-->
<?php include("includes/header.php");
include("includes/navbar.php");
include ("functions/functions.php");
$pdo = dbConnect();
?>

<!--Filter stukje om de producten te filteren-->
<div class="container mt-5">
    <div class="row">
        <!-- Filter sectie -->
        <div class="col-md-3">
            <div class="bg-light p-3 rounded">
                <h4>Filter</h4>
                <div class="form-group">
                    <label for="priceRange">Prijsbereik</label>
                    <select class="form-control" id="priceRange">
                        <option value="">Alle prijzen</option>
                        <option value="0-50">€0 - €5</option>
                        <option value="50-100">€50 - €10</option>
                        <option value="100-200">€10 - €20</option>
                        <option value="200+">€20+</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="category">Categorie</label>
                    <select class="form-control" id="category">
                        <option value="">Alle categorieën</option>
                        <option value="gereedschap">Gereedschap</option>
                        <option value="spelletjes">Spelletjes</option>
                        <option value="plushies">Knuffels</option>
                        <option value="media">DVD's en CD's</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="age">Leeftijd</label>
                    <select class="form-control" id="age">
                        <option value="">Alle leeftijden</option>
                        <option value="age3">3+</option>
                        <option value="age6">6+</option>
                        <option value="age9">9+</option>
                        <option value="age12">12+</option>
                    </select>
                </div>
                <button class="btn btn-primary">Filter toepassen</button>
            </div>
        </div>
        <!-- Producten sectie -->
        <div class="col-md-9">
            <div class="container bg-light p-3 rounded">
                <h2 class="text-center mb-4">Producten</h2>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <img src="img/Buurman-hamer.jpg" class="card-img-top" alt="Product 1">
                            <div class="card-body">
                                <h5 class="card-title">Buurman en Buurman hamer</h5>
                                <p class="card-text">Met deze hamer kan je echt gaan timmerren als buurman en
                                    buurman!.</p>
                                <p class="card-text"><strong>Prijs:</strong> €19.99</p>
                                <a href="kruiwagen.php?productCode=2" class="btn btn-primary">Bestel nu!</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <img src="img/buurman-bordspel.jpg" class="card-img-top" alt="Product 2">
                            <div class="card-body">
                                <h5 class="card-title">Bordspel "Hamertje tik"</h5>
                                <p class="card-text">Met dit bordspel kan je de avonturen van buurman en buurman zelf
                                    beleven.
                                    Ajeto!.</p>
                                <p class="card-text"><strong>Prijs:</strong> €24,99</p>
                                <a href="kruiwagen.php?productCode=3" class="btn btn-primary">Bestel nu!</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <img src="img/buurman-en-buurman-houten-kluskoffer.jpg" class="card-img-top"
                                 alt="Product 3">
                            <div class="card-body">
                                <h5 class="card-title">Buurman en Buurman Kluskoffer</h5>
                                <p class="card-text">Wil je altijd al klussen als buurman en buurman? Dat kan met deze
                                    kluskoffer!.</p>
                                <p class="card-text"><strong>Prijs:</strong> €29,99</p>
                                <a href="kruiwagen.php?productCode=4" class="btn btn-primary">Bestel nu!</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <img src="img/strijkbout.jpg" class="card-img-top" alt="Product 4">
                            <div class="card-body">
                                <h5 class="card-title">Strijkbout</h5>
                                <p class="card-text">Wil je atlassen vernietigen en ramen breken? Dat kan met deze
                                    strijkbout! </p>
                                <p class="card-text"><strong>Prijs:</strong> ̶€̶2̶9̶,̶9̶9̶ €14,99</p>
                                <a href="kruiwagen.php?productCode=1" class="btn btn-primary">Bestel nu!</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <img src="img/B&B-DVD-Bak-Gril.jpg" class="card-img-top" alt="Product 5">
                            <div class="card-body">
                                <h5 class="card-title">Buurman en Buurman "Bakken en Grillen" DVD</h5>
                                <p class="card-text">Met deze DVD kan je de avonturen van Buurman en Buurman
                                    bekijken.</p>
                                <p class="card-text"><strong>Prijs:</strong> €14,99</p>
                                <a href="kruiwagen.php?productCode=5" class="btn btn-primary">Bestel nu!</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <img src="img/B&B-DVD-Bundel.jpeg" class="card-img-top"
                                 alt="Product 6">
                            <div class="card-body">
                                <h5 class="card-title">Buurman en Buurman DVD Bundel</h5>
                                <p class="card-text">De beste vrienden bedenken iedere keer nieuwe klusideeën om hun
                                    levens nog leuker en handiger te maken. Het resultaat liegt er niet om. Tijd om te
                                    klussen!</p>
                                <p class="card-text"><strong>Prijs:</strong> €19,99</p>
                                <a href="kruiwagen.php?productCode=6" class="btn btn-primary">Bestel nu!</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <img src="img/B&B-DVD-Rood.jpg" class="card-img-top"
                                 alt="Product 6">
                            <div class="card-body">
                                <h5 class="card-title">Buurman en Buurman DVD Compleet</h5>
                                <p class="card-text">Met deze DVD kan je de avonturen van Buurman en Buurman
                                    bekijken. Nu met veel avonturen!</p>
                                <p class="card-text"><strong>Prijs:</strong> €24,99</p>
                                <a href="kruiwagen.php?productCode=6" class="btn btn-primary">Bestel nu!</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <aside class="bg-light p-2 rounded">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <img src="img/strijkbout.jpg" class="img-fluid mb-3" alt="Strijkbout aanbieding">
                        <h3>Wat krijgen we nou?!</h3>
                        <p>Een strijkbout in de aanbieding? Met deze strijkbout kan je gegarandeerd strijken zonder je
                            buurman boos te maken.</p>
                        <a href="#" class="btn btn-primary">Voeg aan kruiwagen!</a>
                    </div>
                </div>
            </div>
        </aside>
    </div>
    <?php include("includes/footer.php");

    ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
        //Kijkt of er iets naar de winkelwagen gestuurd is
        if (isset($_SESSION["producten"]) && count($_SESSION["producten"]) > 0) {
            echo '<div class="cart-view-table-front bg-light p-3 rounded mt-3" id="view-cart" style="max-height: 460px; overflow-y: auto;">';
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

                echo '<td>Aantal <input type="text" class="form-control" size="2" maxlength="2" name="product_aantal[' . $product_code . ']" value="' . $product_aantal . '" /></td>';
                echo '<td>' . $product_naam . '</td>';
                echo '<td><input type="checkbox" name="verwijder_code[]" value="' . $product_code . '" /> Verwijder</td>';
                echo '</tr>';
                $subtotaal = ($product_prijs * $product_aantal);
                $totaal = ($totaal + $subtotaal);
            }
            echo '<td colspan="4">';
            echo '<button type="submit" class="btn btn-success">Update</button><a href="kruiwagen.php" class="btn btn-primary">Betalen</a>';
            echo '</td>';
            echo '</tbody>';
            echo '</table>';

            $url = urlencode($url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
            echo '<input type="hidden" name="url_terug" value="' . $url . '" />';
            echo '</form>';
            echo '</div>';
        } else {
            echo '<div class="cart-view-table-front bg-light p-3 rounded mt-3" id="view-cart" style="max-height: 460px; overflow-y: auto;">';
            echo '<h3>Uw kruiwagen</h3>';
            echo '<div class="bg-light p-3 rounded mt-3">Uw kruiwagen is leeg</div>';
            echo '</div>';
        }
        ?>

        