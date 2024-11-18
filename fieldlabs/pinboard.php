<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

$email = $_SESSION['email'];

$dsn = "mysql:host=localhost;dbname=fieldlabs";
$username = "bit_academy";
$password = "bit_academy";

try {
    $pdo = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
    echo "Database connectie gefaald: " . $e->getMessage();
    exit();
}

include('functies/functie.php');
$conn = connectie();

$opdrachten = [];
$query = "SELECT o.opdrachtSleutel, o.opdrachtNaam AS opdracht_naam, o.opdrachtBeschrijving AS opdracht_beschrijving, o.naam AS Bedrijf, o.telefoon AS telefoon_nummer, COUNT(i.groepNaam) AS groepen 
          FROM opdrachten o 
          LEFT JOIN inschrijvingen i ON o.opdrachtNaam = i.opdrachtNaam 
          WHERE o.email = :email 
          GROUP BY o.opdrachtSleutel";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':email', $email, PDO::PARAM_STR);
$stmt->execute();
if ($stmt) {
    while ($obj = $stmt->fetch(PDO::FETCH_OBJ)) {
        $opdrachten[] = $obj;
    }
}

$inschrijvingen = [];
$inschrijvingenQuery = "SELECT opdrachtNaam, groepNaam, eigenNaam, emailLeider, motivatie FROM inschrijvingen";
$stmtInschrijvingen = $pdo->query($inschrijvingenQuery);
if ($stmtInschrijvingen) {
    while ($inschrijving = $stmtInschrijvingen->fetch(PDO::FETCH_OBJ)) {
        $inschrijvingen[] = $inschrijving;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fieldlabs || Opdrachtgever</title>
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/pinboard.css">
    <link rel="icon" type="image/x-icon" href="images/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</head>

<style>
    main {
        overflow-y: auto;
    }

    .scrollable-block {
        max-height: 300px;
        overflow-y: auto;
        border: 1px solid #ddd;
        padding: 10px;
        border-radius: 5px;
    }
</style>

<body>
    <div class="w3-sidebar w3-bar-block w3-collapse w3-card w3-animate-left" style="width:200px; background-color: #28A7E2" id="mySidebar">
        <button class="w3-bar-item w3-button w3-large w3-hide-large" style="color: white" onclick="w3_close()">Sluit &times;</button>
        <img id="logo" src="images/logo.png" alt="logo">
        <a href="loguit.php" class="w3-bar-item w3-button" style="color: white">Andere Gebruiker</a>
    </div>
    <main>
        <div class="w3-main" style="margin-left:200px">
            <button class="w3-button w3-blue w3-xlarge w3-hide-large" onclick="w3_open()">&#9776;</button>

            <!-- Sidebar voor het aanmaken van opdrachten -->
            <div class="sidebar right hidden" id="sidebar">
                <button class="btn-toggle">&raquo; Voeg toe</button>
                <form id="assignment-form" action="pinboard.php" method="post">
                    <div class="form-group m-2">
                        <label for="assignment-title">Titel</label>
                        <input type="text" class="form-control" id="assignment-title" name="opdrachtNaam" placeholder="Vul hier de titel in" required>
                    </div>
                    <div class="form-group m-2">
                        <label for="assignment-description">Beschrijving</label>
                        <textarea class="form-control" id="assignment-description" name="opdrachtBeschrijving" rows="4" placeholder="Vul hier de beschrijving in" required></textarea>
                    </div>
                    <div class="form-group m-2">
                        <label for="name">Naam</label>
                        <input type="text" class="form-control" id="naam" name="naam" placeholder="Vul hier uw naam in" required>
                    </div>
                    <div class="form-group m-2">
                        <label for="name">Telefoon</label>
                        <input type="number" class="form-control" id="telefoon" name="telefoon" placeholder="Vul hier uw Telefoonnummer in" required>
                    </div>
                    <div class="form-group m-2">
                        <label class="form-check-label" for="consent">Ik ga akkoord met het openbaar delen van mijn naam en telefoonnummer: </label>
                        <input type="checkbox" class="form-check-input" id="consent" name="consent" required>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary btn-block m-2">Verzend</button>
                </form>
                <?php
                require_once 'functies/functie.php';
                $conn = connectie();
                opdrachtmaken($conn);
                ?>
            </div>
            <!-- Gemaakte opdrachten worden hier geecho't met keuze om te verwijderen. -->
            <div class="container my-4">
                <div class="row">
                    <?php foreach ($opdrachten as $obj) : ?>
                        <div class="col-md-4 col-sm-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($obj->opdracht_naam) ?></h5>
                                    <p class="card-text"><?= htmlspecialchars($obj->opdracht_beschrijving) ?></p>
                                    <p class="card-text">Product Owner: <?= htmlspecialchars($obj->Bedrijf) ?></p>
                                    <p class="card-text">Telefoonnummer: <?= htmlspecialchars($obj->telefoon_nummer) ?></p>
                                    <p class="card-text">Aantal groepen: <?= htmlspecialchars($obj->groepen) ?></p>
                                    <button onclick="showOverlay('<?= htmlspecialchars($obj->opdracht_naam) ?>')" type="button" class="btn btn-primary">Toon details</button>
                                    <form action="delete.php" method="post">
                                        <input type="hidden" name="opdrachtSleutel" value="<?= htmlspecialchars($obj->opdrachtSleutel) ?>">
                                        <button type="submit" class="btn btn-danger">Verwijder</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <!-- Overlay voor de details -->
        <div class="overlay" id="overlay">
            <div class="overlay-content">
                <div class="container text-center my-5" id="mediaDetailsContainer">
                    <div class="bg text-white p-5 rounded">
                        <h3>Titel: </h3>
                        <p class="font-weight-bold" id="overlayTitle"></p>
                        <h3>Ingeschreven groepen: </h3>
                        <ul id="overlayGroupList"></ul>
                        <h3>Motivatie Blok: </h3>
                        <div id="motiblok" class="scrollable-block"></div>
                        <div id="emailLeaderBlock" class="scrollable-block"></div>
                        <div class="d-flex justify-content-center">
                            <button onclick="closeOverlay()" class="btn btn-primary m-4" id="closeButton">Sluit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <script>
        const inschrijvingen = <?php echo json_encode($inschrijvingen); ?>;

        function showOverlay(opdrachtNaam) {
            document.getElementById('overlayTitle').innerText = opdrachtNaam;

            const relevantInschrijvingen = inschrijvingen.filter(inschrijving => inschrijving.opdrachtNaam === opdrachtNaam);

            const overlayGroupList = document.getElementById('overlayGroupList');
            overlayGroupList.innerHTML = '';

            relevantInschrijvingen.forEach(inschrijving => {
                const li = document.createElement('li');
                li.innerHTML = `${inschrijving.groepNaam}
                    <form action="delete_group.php" method="post" style="display:inline;">
                            <div class="d-flex justify-content-end">
                                <input type="hidden" name="groepNaam" value="${inschrijving.groepNaam}">
                                <button type="submit" class="btn btn-outline-secondary btn-sm" style="color: white; border-color: white; background-color: transparent;">Verwijder</button>
                            </div>
                    </form>`;
                li.style.cursor = 'pointer';
                li.onclick = function() {
                    document.getElementById('motiblok').innerText = inschrijving.motivatie || 'Geen motivatie beschikbaar';
                    document.getElementById('emailLeaderBlock').innerText = 'Email Leider: ' + inschrijving.emailLeider;
                };
                overlayGroupList.appendChild(li);
            });

            if (relevantInschrijvingen.length === 0) {
                const li = document.createElement('li');
                li.innerText = 'Geen groepen ingeschreven';
                overlayGroupList.appendChild(li);
            }

            document.getElementById('motiblok').innerText = 'Klik op een groep om de motivatie te zien';
            document.getElementById('emailLeaderBlock').innerText = 'Klik op een groep om de email te zien';
            document.getElementById('overlay').classList.add('show');
        }

        function closeOverlay() {
            document.getElementById('overlay').classList.remove('show');
            document.getElementById('enrollmentForm').style.display = 'none';
        }

        function w3_open() {
            document.getElementById("mySidebar").style.display = "block";
        }

        function w3_close() {
            document.getElementById("mySidebar").style.display = "none";
        }

        document.querySelectorAll('.btn-toggle').forEach(button => {
            button.addEventListener('click', function() {
                const sidebar = this.closest('.sidebar');
                sidebar.classList.toggle('hidden');
            });
        });
    </script>
</body>

</html>