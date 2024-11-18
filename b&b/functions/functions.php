<?php

function dbConnect()
{
    //mysql gegevens
    $servername = "localhost";
    $database = "buur";
    $dsn = "mysql:host=$servername;dbname=$database";
    $gebruikername = "bit_academy";
    $wachtwoord = "bit_academy";
    //database aanmaken met pdo functie
    $conn = new PDO($dsn, $gebruikername, $wachtwoord);
    //geeft de connectie terug
    return $conn;
}

function dbConnect1()
{
    // MySQL credentials for the new database
    $servername = "localhost";
    $database = "buur";
    $dsn = "mysql:host=$servername;dbname=$database";
    $username = "bit_academy";
    $password = "bit_academy";

    try {
        $conn = new PDO($dsn, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        return null;
    }
}


function registreer($conn)
{
    // kijkt of de knop is ingeklit en daarna vult nieuwe variabelen met waardes van de input velden
    if (isset($_POST['submit'])) {
        $gebruikersNaam = $_POST['gebruikersNaam'];
        $email = $_POST['email'];
        $gebruikersWachtwoord = $_POST['gebruikersWachtwoord'];
        $gebruikersHerhaalWachtwoord = $_POST['gebruikersHerhaalWachtwoord'];
        $hashedPassword = password_hash($gebruikersWachtwoord, PASSWORD_DEFAULT);

        // try catch voor pdo zodat hij niet crasht
        try {
            // zet statement klaar en bind de variabelen aan de values van de statement
            $stmtUpdate = $conn->prepare("INSERT INTO `gebruikers` (`gebruikersNaam`, `email`, `gebruikersWachtwoord`) 
            VALUES (:gebruikersNaam, :email, :gebruikersWachtwoord)");

            $stmtUpdate->bindParam(':gebruikersNaam', $gebruikersNaam);
            $stmtUpdate->bindParam(':email', $email);
            $stmtUpdate->bindParam(':gebruikersWachtwoord', $hashedPassword);

            // kijkt of het wachtwoord en herhaal wachtwoord het zelfde zijn
            if ($gebruikersHerhaalWachtwoord == $gebruikersWachtwoord) {

                // voor de statement uit
                if ($stmtUpdate->execute()) {
                    echo "<script type=\"text/javascript\">toastr.success('registered successfully!')</script>";
                    exit();
                } else {
                    echo "er ging iets mis";
                }
            } else {
                echo "wachtwoord is niet het zelfde";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}

function login($conn)
{
    // kijkt of de submit knop is ingeklikt
    if (isset($_POST['submit'])) {

        // kijkt of de email en wachtwoord zijn ingevuld en daarna vult hij ze in variabelen
        if (isset($_POST['email']) && isset($_POST['gebruikersWachtwoord'])) {
            $email = $_POST['email'];
            $wachtwoord = $_POST['gebruikersWachtwoord'];

            // try catch voor pdo
            try {
                $stmt = $conn->prepare("SELECT * FROM gebruikers WHERE email = :email");
                $stmt->bindParam(':email', $email);
                $stmt->execute();
                $gebruiker = $stmt->fetch(PDO::FETCH_ASSOC);

                // als die de gebruiker kan ophalen uit de database en als de statement niet false is dan voert die de volgende code uit
                if ($gebruiker !== false) {

                    // kijkt of het wachtwoord gelijk is als het wachtwoord in de database
                    if (password_verify($wachtwoord, $gebruiker['gebruikersWachtwoord'])) {
                        echo "Wachtwoord klopt";

                        // Start de sessie en sla e-mail op
                        $_SESSION['email'] = $gebruiker['email'];

                        // Redirect naar index.php na succesvolle login, header functie werkte niet
                        echo "<script>window.location.href='index.php';</script>";
                        exit();
                    } else {
                        echo "Verkeerd wachtwoord";
                    }
                } else {
                    echo "Gebruiker niet gevonden";
                }
            } catch (PDOException $e) {
                echo "Fout: " . $e->getMessage();
            }
        } else {
            echo "Email en wachtwoord moeten worden ingevuld";
        }
    }
}

function wachtwoordVergeten($conn)
{
    // kijkt of de submit knop is ingeklikt
    if (isset($_POST['submit'])) {

        if (isset($_POST['email'])) {

            $email = $_POST['email'];
            $gebruikersWachtwoord = $_POST['gebruikersNieuwWachtwoord'];
            $gebruikersHerhaalWachtwoord = $_POST['gebruikersNieuwHerhaalWachtwoord'];
            $hashedPassword = password_hash($gebruikersWachtwoord, PASSWORD_DEFAULT);

            // try catch voor pdo zodat hij niet crasht
            try {
                // zet statement klaar en checkt of email in de database gelijk is aan de email die je hebt ingevuld
                $stmtUpdate = $conn->prepare("UPDATE gebruikers SET gebruikersWachtwoord = :gebruikersNieuwWachtwoord WHERE email = :email;");


                $stmtUpdate->bindParam(':email', $email);
                $stmtUpdate->bindParam(':gebruikersNieuwWachtwoord', $hashedPassword);

                // kijkt of het wachtwoord en herhaal wachtwoord het zelfde zijn
                if ($gebruikersHerhaalWachtwoord == $gebruikersWachtwoord) {

                    // voor de statement uit
                    if ($stmtUpdate->execute()) {
                        echo "<script>window.location.href='login.php';</script>";
                        exit();
                    } else {
                        echo "er ging iets mis";
                    }
                } else {
                    echo "wachtwoord is niet het zelfde";
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
    }
}

// euro
$euroteken = '€';