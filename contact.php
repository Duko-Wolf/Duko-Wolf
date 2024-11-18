<?php include('includes/session.php'); 
include('functions/functions.php');?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact || B&B Webshop</title>
    <link rel="icon" type="image/x-icon" href="img/buurmanheader2.jpg">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/contact.css">
    <link href="css/background.css" rel="stylesheet">
</head>

<body>

    <?php include("includes/header.php");
    ?>

    <?php include("includes/navbar.php");
    ?>

    <div class="container contact-form" style="width: 70%;">
        <div class="contact-image">
            <img alt="Buurman en buurman contact" src="img/Buurman-en-buurman-contact.jpg">
        </div>
        <form method="post">
            <h3>Vragen of commentaar? Wij zijn 24/7 beschikbaar!</h3>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="text" name="txtName" class="form-control" placeholder="Naam *" required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="txtEmail" class="form-control" placeholder="Email *" required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="txtPhone" class="form-control" placeholder="Telefoon nummer *" required>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="btnSubmit" class="btnContact" value="Verstuur" required>
                    </div>
                    <?php
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        echo "Bericht is verzonden, we sturen zo spoedig mogelijk een antwoord!";
                    }
                    ?>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <textarea name="txtMsg" class="form-control" placeholder="Uw bericht *" style="width: 100%; height: 150px;"></textarea>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <?php include("includes/footer.php");
    ?>

</body>

</html>