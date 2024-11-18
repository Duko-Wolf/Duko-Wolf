<?php include('includes/session.php'); ?>
<?php include("functions/functions.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="img/buurmanheader2.jpg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Home || B&B Webshop</title>
    <link href="css/background.css" rel="stylesheet">
</head>

<body>
    <?php include("includes/header.php");
    ?>
    <?php include("includes/navbar.php");
    ?>
    <div class="card mx-auto" style="max-width: 600px;">
        <div class="card-body">
            <section id="banner" class="py-5 text-center" style="padding-left: 3rem !important; padding-right: 3rem !important;">
                <div class="container">
                    <h1>Welkom bij de Buurman en Buurman Webshop!</h1>
                    <p class="lead">De beste deals voor al jouw behoeften!</p>
                    <a href="shop.php" class="btn btn-primary btn-lg">Bekijk onze producten</a>
                </div>
            </section>
        </div>
    </div>

    <section id="featured-products" class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <h2 class="text-center mb-4 bg-light col-md-6 col-10 rounded">Aanbevolen Producten</h2>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <img src="img/Buurman-hamer.jpg" class="card-img-top" alt="Product 1">
                        <div class="card-body">
                            <h5 class="card-title">Buurman en Buurman hamer</h5>
                            <p class="card-text">Met deze hamer kan je echt gaan timmerren als buurman en buurman!.</p>
                            <a href="shop.php" class="btn btn-primary">Bestel nu!</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <img src="img/buurman-bordspel.jpg" class="card-img-top" alt="Product 2">
                        <div class="card-body">
                            <h5 class="card-title">Bordspel "Hamertje tik"</h5>
                            <p class="card-text">Met dit bordspel kan je de avonturen van buurman en buurman zelf beleven.
                                Ajeto!.</p>
                            <a href="shop.php" class="btn btn-primary">Bestel nu!</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <img src="img/buurman-en-buurman-houten-kluskoffer.jpg" class="card-img-top" alt="Product 3">
                        <div class="card-body">
                            <h5 class="card-title">Buurman en Buurman Kluskoffer</h5>
                            <p class="card-text">Wil je altijd al klussen als buurman en buurman? Dat kan met deze
                                kluskoffer!.</p>
                            <a href="shop.php" class="btn btn-primary">Bestel nu!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php include("includes/footer.php");

    ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>