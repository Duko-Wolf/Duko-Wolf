<?php
$dsn = "mysql:host=localhost;dbname=fieldlabs";
$username = "bit_academy";
$password = "bit_academy";

try {
    $pdo = new PDO($dsn, $username, $password);
    $query = "SELECT * FROM opdrachten";
    $statement = $pdo->prepare($query);
    $statement->execute();
    $mediaDetails = $statement->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Database connectie gefaald: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fieldlabs || Student</title>
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/pinboard.css">
    <link rel="stylesheet" href="css/detail.css">
    <link rel="icon" type="image/x-icon" href="images/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</head>
<style>
    body {
        overflow-y: auto;
    }
</style>

<body>
    <!-- sidebar -->
    <div class="w3-sidebar w3-bar-block w3-collapse w3-card w3-animate-left" style="width:200px; background-color: #28A7E2" id="mySidebar">
        <button class="w3-bar-item w3-button w3-large w3-hide-large" style="color: white" onclick="w3_close()">Sluit &times;</button>
        <img id="logo" src="images/logo.png" alt="logo">
        <a href="pinboardstudent.php" class="w3-bar-item w3-button" style="color: white">Bekijk Opdrachten</a>
        <a href="index.php" class="w3-bar-item w3-button" style="color: white">Andere Gebruiker</a>
    </div>
    <main>
        <!-- Wanneer er een opdracht is toegevoegd wordt hij hier neergezet -->
        <div class="w3-main" style="margin-left:200px">
            <button class="w3-button w3-blue w3-xlarge w3-hide-large" onclick="w3_open()">&#9776;</button>
            <div class="container my-4">
                <div class="row">
                    <?php
                    $stmt = $pdo->query("SELECT opdrachtNaam AS opdracht_naam, opdrachtBeschrijving AS opdracht_beschrijving, naam AS Bedrijf, telefoon AS telefoon_nummer FROM opdrachten");
                    if ($stmt) {
                        while ($obj = $stmt->fetch(PDO::FETCH_OBJ)) {
                            echo '<div class="col-md-4 col-sm-6 mb-4">';
                            echo '<div class="card">';
                            echo '<div class="card-body">';
                            echo '<h5 class="card-title">' . $obj->opdracht_naam . '</h5>';
                            echo '<p class="card-text">' . $obj->opdracht_beschrijving . '</p>';
                            echo '<p class="card-text">Product Owner: ' . $obj->Bedrijf . '</p>';
                            echo '<p class="card-text">Telefoonnummer: ' . $obj->telefoon_nummer . '</p>';
                            echo '<button onclick="showOverlay(`' . $obj->opdracht_naam . '`, `' . $obj->opdracht_beschrijving . '`, `' . $obj->Bedrijf . '`, `' . $obj->telefoon_nummer . '`)" type="button" class="btn btn-primary">Toon details</button>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php
        include('functies/functie.php');

        $conn = connectie();

        ?>
        <!-- Overlay voor de details van de opdracht -->
        <div class="overlay" id="overlay">
            <div class="overlay-content">
                <div class="container text-center my-5" id="mediaDetailsContainer">
                    <div class="bg text-white p-5 rounded">
                        <h3>Titel: </h3>
                        <p class="font-weight-bold" id="overlayTitle"></p>
                        <h3>Beschrijving: </h3>
                        <p id="overlayDescription"></p>
                        <h3>Opdrachtgever: </h3>
                        <p class="font-weight-bold" id="overlayCompany"></p>
                        <h3>Telefoonnummer: </h3>
                        <p id="overlayPhone"></p>
                        <div class="d-flex justify-content-center">
                            <button onclick="showEnrollmentForm()" class="btn btn-primary m-4" id="enrollButton">Schrijf in</button>
                            <button onclick="closeOverlay()" class="btn btn-primary m-4" id="closeButton">Sluit</button>
                        </div>
                        <div id="enrollmentForm" style="display: none;">
                            <form method="post" action="pinboardstudent.php">
                                <div class="form-group">
                                    <label for="groupName">Groepsnaam</label>
                                    <input type="text" class="form-control" id="groupName" name="groepNaam" required>
                                </div>
                                <div class="form-group">
                                    <label for="yourName">Eigen naam</label>
                                    <input type="text" class="form-control" id="yourName" name="eigenNaam" required>
                                </div>
                                <div class="form-group">
                                    <label for="groupMembers">Groepleden</label>
                                    <input type="text" class="form-control" id="groupMembers" name="leden" required>
                                </div>
                                <input type="hidden" id="assignmentName" name="opdrachtNaam">
                                <button name="submit" type="submit" class="btn btn-primary mt-3">Verzend</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php
    // import functie.php
    require_once 'functies/functie.php';

    // use function connectie() from functie.php 
    $conn = connectie();

    // use function opdrachtmaken() from functie.php
    inschrijvingen($conn);

    ?>

    <script>
        // javascript voor de overlay en de sidebar
        function showOverlay(opdrachtNaam, opdrachtBeschrijving, Bedrijf, telefoonNummer) {
            document.getElementById('overlayTitle').innerText = opdrachtNaam;
            document.getElementById('overlayDescription').innerText = opdrachtBeschrijving;
            document.getElementById('overlayCompany').innerText = Bedrijf;
            document.getElementById('overlayPhone').innerText = telefoonNummer;
            document.getElementById('assignmentName').value = opdrachtNaam;
            document.getElementById('overlay').classList.add('show');
        }


        function closeOverlay() {
            document.getElementById('overlay').classList.remove('show');
            document.getElementById('enrollmentForm').style.display = 'none';
        }

        function showEnrollmentForm() {
            document.getElementById('enrollmentForm').style.display = 'block';
        }

        function w3_open() {
            document.getElementById("mySidebar").style.display = "block";
        }

        function w3_close() {
            document.getElementById("mySidebar").style.display = "none";
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>